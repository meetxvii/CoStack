<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Technologies;

class TechnologiesController extends Controller
{
    function addTechnology(Request $request){

        $upload_path = public_path('storage/images/technologies');
        $file_name = time().'.'.$request->logo->getClientOriginalName();
        $request->logo->move($upload_path, $file_name);

        $technology = new Technologies;
        $technology->name = $request->name;
        $technology->description = $request->description; 
        $technology->image = $file_name;
     
        if($technology->save()){
            return response()->json([
                'message' => 'success',
            ], 200);   
        }
        else{
            return response()->json([
                'message' => 'Failed',
            ], 500);   
        }
    }    

    function getTechnology(Request $request){
        $technology = Technologies::where('name', "$request->name")->first();
        if($technology){
            return response()->json([
                'technology' => $technology
            ], 200);   
        }
        else{
            return response()->json([
                'message' => 'Failed',
            ], 500);   
        }
    }

    function getTechnologies(){
        $technologies = Technologies::orderBy('name', 'asc')->get();
        return response()->json([
            'message' => 'success',
            'technologies' => $technologies,
        ], 200);   
    }
    function delete(Request $request){
        $technology = Technologies::find($request->id);
        if($technology->delete()){
            
            $image_path = public_path('storage/images/technologies/'.$technology->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }

            return response()->json([
                'message' => 'success',
                'technologies' => Technologies::orderBy('name', 'asc')->get(),
            ], 200);   
        }
        else{
            return response()->json([
                'message' => 'Failed',
            ], 500);   
        }
    }
}
