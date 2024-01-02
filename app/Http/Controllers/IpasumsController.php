<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ipasums;
use App\Models\Agenti;
use App\Models\Vesture;
use App\Models\Lietotaji;
use App\Mail\SendUpdatedData;
use App\Mail\StatusaMainaAdmin;
use App\Mail\StatusaMaina;
use App\Mail\PievienotsIeraksts;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;

class IpasumsController extends Controller
{
    
    public function GetAll2()
    {
     $agents = Agenti::all();

    
    $ipasumsTodayOrPast = Ipasums::with('agent')
        ->where(function ($query) {
            $query->whereDate('Termins_majaslapai', '<=', now());
        })
        ->orderBy('Termins_majaslapai', 'asc')
        ->get();

    
    $ipasumsFuture = Ipasums::with('agent')
        ->where(function ($query) {
            $query->whereDate('Termins_majaslapai', '>', now());
        })
        ->orderBy('created_at', 'desc')
        ->get();

    $ipasums = $ipasumsTodayOrPast->merge($ipasumsFuture);

    $numurs = 0;

    return view('pages.ipasumi', compact('ipasums', 'agents', 'numurs'));
    }
   
    public function  GetAllForUser()
    {
      $ipasums = Ipasums::with('agent')
        ->orderBy('created_at', 'desc')
        ->get();
      $agents= Agenti::all();
       return view('pages.ipasumiUser', compact('ipasums', 'agents' ));
    }
    public function GetReservedRent ()
    {
        $rerented = Ipasums::where('loma', 'Rezervēts nomai')
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();
         $agents= Agenti::all();
         $numurs = 0;
        return view('pages.rezervetinomai', compact('rerented','agents','numurs'));
    }
    public function GetReservedSold ()
    {
         $resold = Ipasums::where('loma', 'Rezervēts pārdošanai')
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();
         $agents= Agenti::all();
         $numurs = 0;
        return view('pages.rezervetipardosanai', compact('resold','agents','numurs'));
    }
    public function GetSold ()
    {
        $sold = Ipasums::where('loma', 'Pārdots')
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();
         $agents= Agenti::all();
         $numurs = 0;
        return view('pages.pardoti', compact('sold','agents','numurs'));
    }
    public function GetRented ()
    {
        $rented = Ipasums::where('loma', 'Iznomāts')
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();
         $agents= Agenti::all();
         $numurs = 0;
        return view('pages.noma', compact('rented','agents','numurs'));
    }
    public function Getlidz ()
    {
        
        $lidz = Ipasums::where('loma', 'Rezervēts līdz')
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();
         $agents= Agenti::all();
         $numurs = 0;
        return view('pages.rezervetslidz', compact('lidz','agents','numurs'));
    }
    public function create()
    {
         return view('pages.ipasumi');
    }
    public function storeVesture ($date, $user, $name, $action)
    {
        $vesture = new Vesture();
        
        $vesture->date = $date;
        $vesture->user = $user;
        $vesture->action = $action;
        $vesture->name = $name;
        $vesture->save();

    }
    public function store(Request  $request)
    {

    // Validē datus, lai nav tukšs lauks un unikāla URL adrese
    $rules = [
        'Datums' => 'required|date',
        'status' => 'required',
        'nosaukums' => 'required',
        'url' => 'required|url| unique:ipasumi,URL_adrese', // Check if URL is unique in the 'ipasums' table
        'agent' => 'required',
        'Datums1' => 'required|date|after_or_equal:Datums',
    ];

    $validatedData = $request->validate($rules);
    $lastRow = Ipasums::orderBy('created_at', 'desc')->first();
    $kartasNr = $lastRow ? $lastRow->Kartas_nr + 1 : 1;
    // Validētos datus pievieno datubāzei
    $ipasumi = new Ipasums();
    $ipasumi->Datums = $validatedData['Datums'];
        $ipasumi->loma = $validatedData['status'];
        $ipasumi->ipasuma_nosaukums = $validatedData['nosaukums'];
        $ipasumi->URL_adrese = $validatedData['url'];
        $ipasumi->Termins_majaslapai = $validatedData['Datums1'];	
        $ipasumi->agent_id = $validatedData['agent'];
        $ipasumi-> rezervetslidztermins = $request->input('lidzdate');
         $ipasumi->Kartas_nr = $kartasNr;

    $ipasumi->save();
    $agentId = $validatedData['agent'];
    $agentName = Agenti::find($agentId);
   $name = $agentName->agent;

    $username = $request->input('user_name');
    $this->storeVesture( $validatedData['Datums'],$username, $validatedData['nosaukums'],'pievienoja');
    // Store a success message in the session
    
    $data = [
                'nosaukums' =>$validatedData['nosaukums'],
                'datums' => $validatedData['Datums'],
                'url' => $validatedData['url'],
                'agent' => $name,
                
                'loma' => $validatedData['status'],
                'rezlidzdatums'=> $request->input('lidzdate'),
                'termins'=> $validatedData['Datums1'],
    ];
    $users= Lietotaji::all();
        foreach ($users as $user) {
       
            Mail::to($user->email)->send(new PievienotsIeraksts($data));
        }
    $successMessage = "Īpašums {$ipasumi->ipasuma_nosaukums} veiksmīgi pievienots";
     session()->flash('success', $successMessage);

    return redirect()->route('ipasums.getall');
    }

    public function changeStatusAndDelete(Request $request)
    {
        $ipasumsId = $request->input('ipasums_id');
        $date = $request->input('date');
        $action = $request->input('action');
        $user = $request->input('user_name');
       
    
        $ipasums = Ipasums::find($ipasumsId);
        $nosaukums = $ipasums->ipasuma_nosaukums;
        $loma = $ipasums ->loma;
          
        if ($action == 'delete') {
            if($loma == "Iznomāts" || $loma == "Pārdots")
            $epasts= "Maina";
             $nak_loma = 'Izdzēsts';
            $successMessage = "Īpašums {$ipasums->ipasuma_nosaukums} veiksmīgi izdzēsts";
            session()->flash('success', $successMessage);
             $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma, ];
            // Delete the record
            $ipasums->delete();
             $this->storeVesture( $date,$user, $nosaukums,'izdzēsa īpašumu  –');
             else {
             $epasts= "Atcelts";
             $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma,
                'rezervetslidz'=> $ipasums->rezervetslidztermins,
             ];
            // Delete the record
            $ipasums->delete();
             $successMessage = "Īpašumam {$ipasums->ipasuma_nosaukums} rezervācija veiksmīgi atcelta!";
            session()->flash('success', $successMessage);
             $this->storeVesture( $date,$user, $nosaukums,'atcēla rezervāciju īpašumam  –');
	
}

        } 
        elseif ($action == 'pardots') {
             $epasts= "Maina";
            $ipasums->Datums = $date;
            $ipasums->loma = 'Pārdots';
             $nak_loma = 'Pārdots';
            $successMessage = "Īpašumam {$ipasums->ipasuma_nosaukums} veiksmīgi nomainīts statuss uz pārdots";
            session()->flash('success', $successMessage);
             $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma, ];
            $ipasums->save();
            $this->storeVesture( $date,$user, $nosaukums,'mainīja statusu uz pārdots īpašumam –');
        }
        elseif ($action == 'iznomats') {
             $epasts= "Maina";
            $ipasums->loma = 'Iznomāts';
             $nak_loma = 'Iznomāts';
            $ipasums->Datums = $date;
            $successMessage = "Īpašumam {$ipasums->ipasuma_nosaukums} veiksmīgi nomainīts statuss uz iznomāts";
            session()->flash('success', $successMessage);
             $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma, ];
            $ipasums->save();
             $this->storeVesture( $date,$user, $nosaukums,'mainīja statusu uz iznomāts īpašumam –');
        }
        elseif ($action == 'reznomai') {
             $epasts= "Maina";
            $ipasums->loma = 'Rezervēts nomai';
             $nak_loma = 'Rezervēts nomai';
            $ipasums->Datums = $date;
            $successMessage = "Īpašumam {$ipasums->ipasuma_nosaukums} veiksmīgi nomainīts statuss uz Rezervēts nomai";
            session()->flash('success', $successMessage);
             $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma, ];
            $ipasums->save();
            $this->storeVesture( $date,$user, $nosaukums,'mainīja statusu uz rezervēts nomai īpašumam –');
        }
        elseif ($action == 'rezpardots') {
             $epasts= "Maina";
            $ipasums->loma = 'Rezervēts pārdošanai';
             $nak_loma = 'Rezervēts pārdošanai';
            $ipasums->Datums = $date;
            $successMessage = "Īpašumam {$ipasums->ipasuma_nosaukums} veiksmīgi nomainīts statuss uz Rezervēts pārdošanai";
            session()->flash('success', $successMessage);
             $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma, ];
            $ipasums->save();
            $this->storeVesture( $date,$user, $nosaukums,'mainīja statusu uz rezzervēts pārdošanai īpašumam –');
        }
        
        $users= Lietotaji::all();
        if ( $epasts == "Maina")
        {
            foreach ($users as $user) {
       
            Mail::to($user->email)->send(new StatusaMainaAdmin($data));
        }
        elseif($epasts == "Atcelts")
        {
            foreach ($users as $user) {
       
            Mail::to($user->email)->send(new AtceltsRezervejums($data));
        }
	
}

      
         
        return redirect()->route('ipasums.getall');
       
    }
        public function changeStatusAndDeleteEmail(Request $request)
    {
        $ipasumsId = $request->input('ipasums_id');
        $date = $request->input('date');
        $action = $request->input('action');
        $user = $request->input('user_name');

         if ($action == 'delete') {
             $nak_loma = "Izdzēsts";
           
        } 
        elseif ($action == 'pardots') {
             $nak_loma = "Pārdots";

        }
        elseif ($action == 'iznomats') {
             $nak_loma = "Iznomāts";
            
        }
        elseif ($action == 'reznomai') {
             $nak_loma = "Rezervēts nomai";
          
        }
        elseif ($action == 'rezpardots') {
            $nak_loma = "Rezervēts pārdošanai";
           
        }
    
        $ipasums = Ipasums::find($ipasumsId);
     
        $adminUsers = Lietotaji::where('loma', 'admin')->get();
        $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'loma' => $nak_loma, ];
        $this->storeVesture( $date,$user, $data['nosaukums'],'velas izdzēst');
        foreach ($adminUsers as $adminUser) {
       
            Mail::to($adminUser->email)->send(new StatusaMaina($data));
        }
         $successMessage = "Īpašuma {$ipasums->ipasuma_nosaukums} rediģēšanas pieprasījums veiksmīgi nosūtīts";
         session()->flash('success', $successMessage);
        return redirect()->route('ipasums.getall');
    }
     public function updatedata(Request $request)
    {
        $user_name = $request->input('user_name');
        $ipasumsId = $request->input('ipasumsid');
        $date = $request->input('Date');
        $datums = $request->input('Datums');
        $status = $request->input('status');
        $nosaukums =  $request->input('nosaukums');
        $nosaukumshistory =  $request->input('nosaukums');
        $url =  $request->input('url');
        $datums1 = $request->input('Datums1');
        $agent =  $request->input('agent');
        $lidzdate = $request->input('lidzdate');
        if ($agent)
        {
            $agentId = $agent;
                $agentName = Agenti::find($agentId);
               $name = $agentName->agent;

        }
        
         

                  
        $ipasums = Ipasums::find($ipasumsId);
        if (!$agent)
        {
            $name = $ipasums->agent->agent;
        }
         $newdata = [
                'nosaukums' => $nosaukums,
                'datums' => $datums,
                'url' => $url,
                'agent' => $name,
                'iepr_loma' => $status,
                'termins'=> $datums1,
                'rezervetslidz'=>$lidzdate,
                 ];
        $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'termins'=> $ipasums->Termins_majaslapai,
                'rezervetslidz'=>$ipasums->rezervetslidztermins,
                
                 ];

         if ( ($ipasums->Termins_majaslapai) != $datums1)
        {
             $ipasums->Termins_majaslapai = $datums1;
        }
        if($agent) 

       {

           if ($ipasums->agent_id != $agent)
           {
               
                $ipasums->agent_id = $agent;
           }
          

       }
        if ( ($ipasums->Datums) !=  $datums)
        {
            $ipasums->Datums = $datums;
        }
        if ( ($ipasums->loma) != $status )
        {
            $ipasums->loma = $status;
        }
        if(  ($ipasums->ipasuma_nosaukums) != $nosaukums)
        {
            $nosaukumshistory =  $ipasums->ipasuma_nosaukums;
             $ipasums->ipasuma_nosaukums = $nosaukums;
        }
        if(  ($ipasums->URL_adrese) != $url)
        {
              $ipasums->URL_adrese = $url;
        }
       
       if ( ($ipasums-> rezervetslidztermins) != $lidzdate)
       {
           $ipasums-> rezervetslidztermins = $lidzdate;
       }
    
        $ipasums->save();
         $temats =[
            'nosaukums1' => 'Iepriekšējais ieraksta saturs',
               'nosaukums2' => 'Tagadējais ieraksta saturs',
               'temats'=> 'Lietotājs ',
               'temats1'=> $user_name,
               'temats2'=> 'veica izmaiņas',
                'temats3'=> ' .',

        ];
         $users= Lietotaji::all();
        foreach ($users as $user) {
       
       
            Mail::to($user->email)->send(new SendUpdatedData($data,$newdata,$temats));
        }
        $this->storeVesture( $date,$user_name, $nosaukumshistory,'rediģēja informāciju');
        $successMessage = "Īpašums  $nosaukums veiksmīgi rediģēts";
        session()->flash('success', $successMessage);
     return redirect()->route('ipasums.getall');
    }
     public function updatedataEmail(Request $request)
    {
        $user_name = $request->input('user_name');
        $ipasumsId = $request->input('ipasumsid');
        $date = $request->input('Date');
        $datums = $request->input('Datums');
        $status = $request->input('status');
        $nosaukums =  $request->input('nosaukums');
        $nosaukumshistory =  $request->input('nosaukums');
        $url =  $request->input('url');
        $datums1 = $request->input('Datums1');
        $agent =  $request->input('agent');
        $lidzdate = $request->input('lidzdate');
        if ($agent)
        {
            $agentId = $agent;
                $agentName = Agenti::find($agentId);
               $name = $agentName->agent;

        }
            
        $ipasums = Ipasums::find($ipasumsId);
        if (!$agent)
        {
            $name = $ipasums->agent->agent;
        }
         $newdata = [
                'nosaukums' => $nosaukums,
                'datums' => $datums,
                'url' => $url,
                'agent' => $name,
                'iepr_loma' => $status,
                'rezervetslidz'=>$lidzdate,
                'termins'=> $datums1,
                 ];
        $data = [
                'nosaukums' => $ipasums->ipasuma_nosaukums,
                'datums' => $ipasums->Datums,
                'url' => $ipasums->URL_adrese,
                'agent' => $ipasums->agent->agent,
                'iepr_loma' => $ipasums->loma,
                'rezervetslidz'=>$ipasums-> rezervetslidztermins,
                'termins'=> $ipasums->Termins_majaslapai,

                 ];

        $temats =[
            'nosaukums1' => 'Tagadējais ieraksta saturs',
               'nosaukums2' => 'Vēlamais ieraksta saturs',
               'temats'=> 'Lietotājs ',
               'temats1'=> $user_name,
               'temats2'=> 'vēlas, lai īpašums',
                'temats3'=> 'tiktu rediģēts',

        ];
         $adminUsers = Lietotaji::where('loma', 'admin')->get();
        foreach ($adminUsers  as $user) {
       
       
            Mail::to($user->email)->send(new SendUpdatedData($data,$newdata,$temats));
        }
        $this->storeVesture( $date,$user_name, $nosaukumshistory,'vēlas, lai tiktu rediģēta informācija');
        $successMessage = "Īpašuma $nosaukums rediģēšanas pieprasījums veiksmīgi nosūtīts";
        session()->flash('success', $successMessage);
     return redirect()->route('ipasums.getall');
    }
}
    
 

