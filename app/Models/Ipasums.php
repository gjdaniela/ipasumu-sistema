<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipasums extends Model
{
   // use HasFactory;
    protected $table = 'statusmainaipasumi';
    public function agent()
    {
        return $this->belongsTo(Agenti::class, 'agent_id');
    }	
}
