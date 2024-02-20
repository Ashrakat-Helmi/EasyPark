<?php

namespace App\Http\Controllers;

use App\Models\floors;
use App\Models\garages;
use Illuminate\Http\Request;
use App\Http\Controllers\FloorsController;

class FloorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return floors::join('garages', 'garages.id', '=', 'floors.garageId')
        ->select('floors.id as fId', 'floors.code', 'garages.id as gId', 'garages.name as garageName', 'garages.numFloors', 'garages.location', 'garages.lat', 'garages.longt', 'garages.rate', 'garages.img', 'garages.desc', 'garages.price', 'garages.numSpaces')
        ->get();
        // return floors::join('garages',"garages.id","=","floors.garageId")->get();
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\floors  $floors
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return floors::join('garages', 'garages.id', '=', 'floors.garageId')
        ->select('floors.id as fId', 'floors.code', 'garages.id as gId', 'garages.name as garageName', 'garages.numFloors', 'garages.location', 'garages.lat', 'garages.longt', 'garages.rate', 'garages.img', 'garages.desc', 'garages.price', 'garages.numSpaces')
        ->where('floors.id',"=",$id)
        ->get();
        // return floors::join('garages',"garages.id","=","floors.garageId")->where('floors.id',"=",$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\floors  $floors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required|string',
            'garageId'=>'required|exists:garages,id'
        ]);
        $floor = floors::find($id);
        $floor ->update($request->all());
        return $floor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\floors  $floors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return floors::destroy($id);
    }

    public function showByGarage($garageId){
        return floors::join('garages', 'garages.id', '=', 'floors.garageId')
        ->select('floors.id as fId', 'floors.code', 'garages.id as gId', 'garages.name as garageName', 'garages.numFloors', 'garages.location', 'garages.lat', 'garages.longt', 'garages.rate', 'garages.img', 'garages.desc', 'garages.price', 'garages.numSpaces')
        ->where('garageId', '=', $garageId)
        ->get();
        // return floors::join('garages',"garages.id","=","floors.garageId")->where('garageId', '=', $garageId)->get();

}
