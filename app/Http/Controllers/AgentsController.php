<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenti;
use App\Models\Lietotaji;
use Illuminate\Support\Facades\DB;
class AgentsController extends Controller
{
    public function all()
    {
       $agents = Agenti::all();
       $lietotaji = Lietotaji::all();
       
       return view('pages.iestatijumi', compact('agents','lietotaji'));
    }
    public function newall()
    {
       $agents = Agenti::all();
       return view('pages.ipasumi', compact('agents'));
    }
    public function ipasumiall() 
    {
       $agents = Agenti::all();
       return view('pages.ipasumi', compact('agents'));
    }
    public function store(Request  $request)
    {

    // Validē datus, lai nav tukšs lauks un unikāls aģenta vārds
    $rules = [
        'Agentname' => 'required|unique:agenti,agent', // Check if URL is unique in the 'ipasums' table
        
    ];

    $validatedData = $request->validate($rules);

    // Validētos datus pievieno datubāzei
    $agents = new Agenti();
    $agents->agent = $validatedData['Agentname'];
    $agents->status = 'aktīvs';

       

    $agents->save();
    // Store a success message in the session
    $successMessage = "Aģents ar vārdu { $agents->agent} veiksmīgi pievienots";
    session()->flash('success', $successMessage);

    $agents = Agenti::all();
    return redirect()->route('agents.getall');
    }
        
}
