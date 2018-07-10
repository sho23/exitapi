<?php

namespace App\Http\Controllers;

use Request;
use DB;
use Illuminate\Support\Facades\Input;
use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth', ['except' => 'getExits']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = DB::table('tracks')->where('publish_flag', 1)->orderBy('name', 'desc')->get();
        return view('home', compact('tracks'));
    }

    public function search(){
        $query = Request::get('q');
        if ($query) {
            $spots = DB::table('spots')
                ->where('spots.name', $query)
                // ->where('spots.name', 'LIKE', "%$query%")
                ->get();
            $spotList = [];
            foreach ($spots as $spot) {
                $spotList[] = $spot->id;
            }

            $exits = DB::table('exit_spots')
                ->whereIn('exit_spots.spot_id', $spotList)
                ->join('exits', 'exit_spots.exit_id', '=', 'exits.id')
                ->join('spots', 'exit_spots.spot_id', '=', 'spots.id')
                ->join('stations', 'exits.station_id', '=', 'stations.id')
                ->join('tracks', 'stations.track_id', '=', 'tracks.id')
                ->select('spots.id as spot_id','stations.id as station_id', 'spots.name as spot_name', 'stations.name as station_name','tracks.name as track_name','exits.name as exit_name')
                ->get();
            $spotList = [];
            foreach ($exits as $exit) {
                $spotList[$exit->spot_name][$exit->station_name][] = $exit;
            }
        }
        return view('search', compact('spotList'));
    }

    public function autoSearch(){
       $term = Input::get('term');

        $results = array();

        $spots = DB::table('spots')
        ->where('spots.name','like','%'.$term.'%')
        ->take(10)
        ->get();
        foreach ($spots as $spot) {
            $results[] = ['label' => $spot->name, 'value' => $spot->name];
        }
        return Response::json($results);
    }

    public function getExits(){
        $query = Request::get('station');
        $lang = Request::get('lang');
        if ($query) {
            if (isset($lang) && $lang == 'en') {
                $station = DB::table('stations')
                    ->where('stations.en_name', $query)
                    ->where('tracks.publish_flag', 2)
                    ->join('tracks', 'stations.track_id', '=', 'tracks.id')
                    ->select('stations.en_name as station_name', 'tracks.name as track_name', 'stations.id as station_id')
                    ->first();
            } else {
                $station = DB::table('stations')
                    ->where('stations.name', $query)
                    ->where('tracks.publish_flag', 2)
                    ->join('tracks', 'stations.track_id', '=', 'tracks.id')
                    ->select('stations.name as station_name', 'tracks.name as track_name', 'stations.id as station_id')
                    ->first();
            }
            $exits = DB::table('exits')
                ->where('station_id', $station->station_id)
                ->whereNotNull('latitude')
                ->where('exits.publish_flag', 1)
                ->get();
            $exits = $exits->toArray();

            $exitList= [];
            foreach ($exits as $exit) {
                $exitList[$exit->name] = [$exit->latitude, $exit->longitude];
            }
            $dataList = ['track' => $station->track_name,'station' => $station->station_name, 'exits' => $exitList];
            return json_encode($dataList);
        }
    }
}
