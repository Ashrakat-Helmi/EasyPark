<?php

namespace App\Http\Controllers;
use App\Models\garages;
use App\Models\floors;
use App\Models\places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;


class GaragesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  garages::all();

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
            'name' => "required|string",
            'numFloors' => "required",
            'location' => "required|string",
            'lat' => "required",
            'longt' => "required",
            'desc' => "required",
            'price' => "required"
        ]);
        // $image = $request->file('img');
        // $imageName = time() . '.' . $image->extension();
        // $image->move(public_path('images'), $imageName);
        $garage= garages::create([
            'id'=>$request->id,
            'name' => $request->name,
            'numFloors' => $request->numFloors,
            'location' => $request->location,
            'lat' => $request->lat,
            'longt' => $request->longt,
            'rate' => $request->rate,
            'img' => 'any',
            'desc' => $request->desc,
            'price' => $request->price,
            'numSpaces'=>$request->numSpaces
        ]);
        $this->addFloors($request->id,$request->numFloors,$request->numSpaces);

        return $request->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\garages  $garages
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return garages::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\garages  $garages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => "required|string",
            'numFloors' => "required",
            'location' => "required|string",
            'lat' => "required",
            'longt' => "required",
            'rate' => "required",
            'desc' => "required",
            'price' => "required"
        ]);
        $grage = garages::find($id);
        $grage ->update($request->all());
        return $grage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\garages  $garages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return garages::destroy($id);
    }

    public function getImage($id)
    {
        $garage = garages::find($id);
        $imageName = $garage->img;
        $path = public_path("\images\\" . $imageName);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    public function updateImage(Request $request, $id)
    {
        $garage = garages::find($id);

        // Validate the image.
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $image = $request->file('img');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        // Update the user's image in the database.
        $garage->update([
            'img' => $imageName,
        ]);

        return $garage;
    }
    public function addFloors($id,$numFloors,$numSpaces)
    {
        $placesNo =$numSpaces/$numFloors;
        if ($numFloors > 0) {
            for ($i = 1; $i <= $numFloors; $i++) {
                $floor = new floors;
                $floor->code = chr($i+64);
                $floor->garageId = $id;
                $floor->save();

                for ($j=1 ; $j<=$placesNo ; $j++){  
                    $place = new places;
                    $place->num = $j;
                    $place->floorId = $floor->id;
                    $place->save();
                }
            }

            return response()->json(['success' => 'Floors have been added successfully.']);
        } else {
            return response()->json(['error' => 'Invalid number of floors.']);
        }
      
    }

}
