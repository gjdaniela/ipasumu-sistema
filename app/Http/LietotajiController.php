<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lietotaji;

class LietotajiController extends Controller
{
    public function store(Request  $request)
    {
    $rules = [
        'name'=> 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'loma' => 'required',
    ];

    // Validate the incoming request data
    $validatedData = $request->validate($rules);

    // Create a new Ipasums instance and populate it with the validated data
    $lietotajs = new Lietotaji();
    $lietotajs->name = $validatedData['name'];
    $lietotajs->loma = $validatedData['loma'];
    $lietotajs->email = $validatedData['email'];
    $lietotajs->password =Hash::make($validatedData['password']);
    // Save the new Ipasums record
    $lietotajs->save();

    // You can also add a success message or redirection here
    return view('/pages.pievienotjaunulietotaju')->with('success', 'The record has been saved.');
    }

}
