<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lietotaji;
use Illuminate\Auth\Events\Registered;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\CustomEmailVerification;

class LietotajiController extends Controller
{
    public function all()
    {
       $lietotaji = Lietotaji::all();
       return view('pages.iestatijumi', compact('lietotaji'));
    }
    
    public function store(Request  $request)
    {

    $rules = [
        'name'=> 'required',
        'email' => 'required|email|unique:users,email|regex:/@lvkv\.lv$/i',
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

    
    
 // Dispatch the Registered event
 event(new Registered($lietotajs));

 // Send the verification email
 /*$verificationUrl = URL::temporarySignedRoute(
    'verification.verify',
    now()->addMinutes(config('auth.verification.expire', 60)),
    ['id' => $lietotajs->id]
);*/

/*Mail::to($lietotajs->email)->send(new EmailVerify($verificationUrl));*/
 
 

    return redirect()->route('agents.getall');
    
    }

}
