<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function index(){
        $Students=  Student::all();

        $Students->each(function ($s) {
            $s->profile_image = asset("uploads/students/" . $s->profile_image);
        });

        return response()->json([
            "message"=>"reteval Secessfull",
            "data" => $Students,
        ], status: 200);
    }

    public function store(Request $request){
        $student = new Student();
        $student->name=$request->input('name');
        $student->phone=$request->input('phone');
        // $student->id=$request->input('id');

        if($request->hasFile('profile_image')){

            $file= $request->file('profile_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'. $extention;
            $file->move('uploads/students/',$filename);
            $student->profile_image=$filename;
        }
        $student->save();
        return response()->json([
            "message"=>"Saved  Secessfull",

        ], status: 200);




    }
    public function show($id){

        $student = Student::find($id);
        return $student;


    }

    ///// need api
    public function update(Request $request , $id){
        $validated = $request->validate([
            'name' => 'required',
//            'phone' => 'required|',
            'phone' => 'required|numeric|regex:/(01)[0-9]{9}/
',
        ]);
        $student=Student::find($id);
        $student->name = $request->input('name');
//        $student->name = $request->input('name') ?? ($student->name ?? '');
        $student->phone=$request->input('phone');

        if($request->hasFile('profile_image')){

            $destination = 'uploads/students/'.$student->profile_image;
            if (File::exists( $destination)){
                File::delete( $destination);
            }
            $file= $request->file('profile_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'. $extention;
            $file->move('uploads/students/', $filename);
            $student->profile_image=$filename;
        }
        $student->Update();

//        return redirect()->back()->with('status','Student image Updated successfully');
        return ApiResponse::sendResponse(201,"updated successfully",[
            $student->name,
            $student->phone,
            asset("/uploads/students/". $student->profile_image),
        ]);


    }
    ///need api
    public function destroy($id){
        if (Student::find($id)){


        $student=Student::find($id);
        $destination = 'uploads/students/'.$student->profile_image;
        if (File::exists( $destination)){
            File::delete( $destination);
        }
        $student->delete();
      //  return redirect()->back()->with('status','Student image deleted  successfully');


       return ApiResponse::sendResponse(201,"image deleted successfully");
        }
        else{
            return ApiResponse::sendResponse(404,"image not found");
        }
    }


}
