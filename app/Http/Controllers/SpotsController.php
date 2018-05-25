<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Response;
use App\Spot;
use App\ExitSpot;

class SpotsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $exit = DB::table('exits')
                ->where('id', $id)
                ->first();
        $spots = DB::table('exit_spots')
                ->where('exit_spots.exit_id', $id)
                ->join('spots', 'exit_spots.spot_id', '=', 'spots.id')
                ->get();
        // var_dump($spots);
        // exit();
        return view('spots.index', compact('spots', 'exit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trackList = $this->getTrackList();
        $stationList = ['路線を選択してください'];
        $exitList = ['駅を選択してください'];
        return view('spots.create', compact('trackList', 'stationList', 'exitList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'exit' => 'required',
            'address' => 'required',
        ]);
        $currentSpot = DB::table('spots')
                ->where('name', $request->name)
                ->first();
        if (!empty($currentSpot)) {
            $spotId = $currentSpot->id;
        } else {
            $spot = new Spot;
            $spot->name = $request->name;
            $spot->address = $request->address;
            $spot->save();
            $spotId = $spot->id;;
        }

        $exitSpot = new ExitSpot;
        $exitSpot->exit_id = $request->exit;
        $exitSpot->spot_id = $spotId;
        $exitSpot->save();

        return redirect()->route('spots.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTrackList()
    {
        $query = DB::table('tracks'); 
        $query->where('publish_flag', 1);
        $query->orderBy('name', 'desc');
        $tracks = $query->get();
        $trackList = [];
        foreach ($tracks as $track) {
            $trackList[$track->id] = $track->name;
        }
        return $trackList;
    }
    public function getStationList(Request $request)
    {
        $query = DB::table('stations');
        $query->where('publish_flag', 1);
        $query->where('stations.track_id', $request->track_id);
        $stations = $query->get();

        $stationList = [];
        foreach ($stations as $station) {
            $stationList[$station->id] = $station->name;
        }
        return Response::json($stationList);
    }
    public function getExitList(Request $request)
    {
        $query = DB::table('exits');
        $query->where('publish_flag', 1);
        $query->where('exits.station_id', $request->station_id);
        $exits = $query->get();

        $exitList = [];
        foreach ($exits as $exit) {
            $exitList[$exit->id] = $exit->name;
        }
        return Response::json($exitList);
    }
}
