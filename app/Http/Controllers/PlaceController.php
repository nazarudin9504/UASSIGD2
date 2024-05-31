<?php

namespace App\Http\Controllers;

use App\Models\Place;
// use App\Http\Resources\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::all();
        return view('places.index', compact('places'));
    }


    public function create()
    {
        return view('places.create');
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
            'place_name' => 'required|min:3',
            'address'   => 'required|min:10',
            'description' => 'required|min:10',
            'longitude'  => 'required',
            'latitude'  => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        Place::create([
            'place_name' => $request->place_name,
            'address'  => $request->address,
            'description' => $request->description,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'image' => $request->image
        ]);
        notify()->success('Place has been created');
        return redirect()->route('places.index');
    }


    public function show(Place $place)
    {
        return view('places.detail', [
            'place' => $place,
        ]);
    }


    public function edit(Place $place)
    {
        return view('places.edit', [
            'place' => $place,
        ]);
    }


    public function update(Request $request, Place $place)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'place_name' => 'required|min:3',
                'description' => 'required|min:10',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional image validation
            ]);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validatedData['image'] = $imagePath;
            }

            // Update place with validated data
            $place->update($validatedData);

            notify()->info('Place has been updated successfully.'); 
        } catch (\Exception $e) {
            \Log::error('Error updating place: '.$e->getMessage());
            notify()->error('There was an issue updating the place.');
        }
        return redirect()->route('places.index');
    }
    

    public function destroy(Place $place)
    {
        $place->delete();
        notify()->warning('Place has been deleted');
        return redirect()->route('places.index');
    }
}
