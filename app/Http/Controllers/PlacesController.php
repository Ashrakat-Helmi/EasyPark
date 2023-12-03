<?php

namespace App\Http\Controllers;

use App\Models\places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return places::join('floors', 'floors.id', '=', 'places.floorId')
            ->join('garages', 'garages.id', '=', 'floors.garageId')
            ->select('places.id as pId', 'places.num', 'floors.id as fId', 'floors.code', 'garages.id as gId', 'garages.name as garageName', 'garages.numFloors', 'garages.location', 'garages.lat', 'garages.longt', 'garages.rate', 'garages.img', 'garages.desc', 'garages.price', 'garages.numSpaces')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'num'=> "required",
           'floorId'=>'required|exists:floors,id'
        ]);
        return places::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\places  $places
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return places::join('floors', 'floors.id', '=', 'places.floorId')
        ->join('garages', 'garages.id', '=', 'floors.garageId')
        ->select('places.id as pId', 'places.num', 'floors.id as fId', 'floors.code', 'garages.id as gId', 'garages.name as garageName', 'garages.numFloors', 'garages.location', 'garages.lat', 'garages.longt', 'garages.rate', 'garages.img', 'garages.desc', 'garages.price', 'garages.numSpaces')
        ->where("places.id","=",$id)
        ->get();
        // return places::join('floors',"floors.id","=","places.floorId")->join('garages',"garages.id","=","floors.garageId")->where("places.id","=",$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\places  $places
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'num'=> "required|numaric",
           'floorId'=>'required|exists:floors,id'
        ]);
        $place = places::find($id);
        $place->update($request->all());
        return $place;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\places  $places
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return places::destroy($id);
    }

    public function showByFloor($floorId){
        return places::join('floors', 'floors.id', '=', 'places.floorId')
        ->select('places.id as pId', 'places.num', 'floors.id as fId', 'floors.code', 'floors.numSpaces')
        ->where('floorId', '=', $floorId)
        ->get();
        // return places::join('floors',"floors.id","=","places.floorId")->where('floorId', '=', $floorId)->get();
    }


    public function showByGarage($garageId){
        return places::join('floors', 'floors.id', '=', 'places.floorId')
        ->join('garages', 'garages.id', '=', 'floors.garageId')
        ->select('places.id as pId', 'places.num', 'floors.id as fId', 'floors.code', 'floors.numSpaces', 'garages.id as gId', 'garages.name as garageName', 'garages.numFloors', 'garages.location', 'garages.lat', 'garages.longt', 'garages.rate', 'garages.img', 'garages.desc', 'garages.price')
        ->where('garageId', '=', $garageId)
        ->get();
        // return places::join('floors',"floors.id","=","places.floorId")->join('garages',"garages.id","=","floors.garageId")->where('garageId', '=', $garageId)->get();
    }
}
