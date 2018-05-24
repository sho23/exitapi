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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = DB::table('tracks')->where('publish_flag', 1)->get();
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

            $exits = DB::table('exit_spot')
                ->whereIn('exit_spot.spot_id', $spotList)
                ->join('exits', 'exit_spot.exit_id', '=', 'exits.id')
                ->join('spots', 'exit_spot.spot_id', '=', 'spots.id')
                ->join('stations', 'exits.station_id', '=', 'stations.id')
                ->join('tracks', 'stations.track_id', '=', 'tracks.id')
                ->select('spots.id as spot_id','stations.id as station_id', 'spots.name as spot_name', 'stations.name as station_name','tracks.name as track_name','exits.name as exit_name')
                ->get();
            $spotList = [];
            foreach ($exits as $exit) {
                $spotList[$exit->spot_name][$exit->station_name][] = $exit;
            }
            // $spots = DB::table('spots')
            //     ->where('spots.name', 'LIKE', "%$query%")
            //     ->join('exits', 'spots.exit_id', '=', 'exits.id')
            //     ->join('stations', 'exits.station_id', '=', 'stations.id')
            //     ->join('tracks', 'stations.track_id', '=', 'tracks.id')
            //     ->select('spots.name', 'exits.name as exit_name', 'stations.name as station_name', 'tracks.name as track_name', 'tracks.id as track_id', 'stations.id as station_id')
            //     ->get();
            // $spots = $spots->toArray();
            // $spotList = [];
            // $stationIdList = [];
            // foreach ($spots as $spot) {
            //     $spotList[$spot->track_id][] = $spot->exit_name;
            //     $stationIdList[] = $spot->station_id;
            // }
            // $stationIdList = array_unique($stationIdList);
            // $stations = DB::table('stations')
            //     ->whereIn('stations.id', $stationIdList)
            //     ->join('tracks', 'stations.track_id', '=', 'tracks.id')
            //     ->select('stations.*','tracks.name as track_name')
            //     ->get();
            // $stations = $stations->toArray();
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
}
