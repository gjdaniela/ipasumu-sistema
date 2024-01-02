<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Events\Registered;
 use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerify;



class Lietotaji extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
   
    protected $table = 'users';	
 
    // ...
    protected $fillable = [
        'name',
        'email',
        'password',
        'loma',
        // Add other fields as needed
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    // ... any additional relationships or methods

    

}
