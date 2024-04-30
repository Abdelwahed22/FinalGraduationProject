<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Qr;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class QrController extends Controller
{
    public function index()
    {
        return view("qr");
    }
    public function create(Request $request)
    {


// Generate a data URI to include image data inline (i.e. inside an <img> tag)
        $qr = Qr::create([
            "user_id"=>auth()->user()->id,

            "info"=>"https://quickchart.io/qr?text=". $request->data,
        ]);

        $response = [
            "model" => $qr,
            "url" =>  "https://quickchart.io/qr?text=". $request->data
        ];


        return "<img src='". $response["url"] . "'/>";
    }


}
