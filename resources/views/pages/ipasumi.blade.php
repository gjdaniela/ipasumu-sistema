
@extends('layouts.default')
@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::now();
@endphp

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
    <h2 class="printable" >Visi pievienotie īpašumi</h2>
    <div class="TableButton" >

     <button type="button" class="button"  onclick="Tabula()" >
                <span class = "button__text">Tabulas lietošanas  paskaidrojumi </span>
                <span class = "button__icon"><ion-icon name="receipt-outline"></ion-icon></span></button> 
    
    <div id="tabula" style = " display:none;">
    
    <p> Krāsu atšifrējums </p>
    <p>&nbsp; <span style='background-color:  #d9eff0'> Rezervēts nomai </span> &nbsp; <span style='background-color: #bbceb8'> Iznomāts </span>
    &nbsp; <span style='background-color: #9bc8c9'> Rezervēts pārdošanai </span> &nbsp;<span style='background-color: #9fbfab'> Pārdots </span> </span> &nbsp;<span style='background-color: #B0E0D5'> Rezervēts līdz </span> </p>
    
    <p> Ikonu/ pogu atšifrējums </p>
    <p> <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span>
    īpašuma ieraksta statusa maiņa ( rezervēts nomai -> iznomāts, rezervēts pārdošanai -> pārdots, rezervēts līdz -> rezervēts), kā arī ja rezervējums tiek atcelts var izdzēst īpašuma ierakstu </p>
    <p> <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></span> īpašuma ieraksta dzēšana no beigu stāvokļiem iznomāts, pārdots  </p>
    <p><span class= "button__icon"> Mainīt info </span> ieraksta rediģēšanas opcija, kas nodrošina ieraksta jebkuru datu izmaiņu </p>
    </div>
    </div>
    
    <div class="NewObjectButton" >

      @if(Auth::user()->loma == "admin")
                     

                <!-- Button to trigger the dialog -->
                @error('url')
                                <div class="alert alert-danger">Šī īpašuma URL adrese jau ir pievienota datu bāzē! </div>
                            @enderror
                <button type="button" class="button"  data-toggle="modal" data-target="#newobject">
                <span class = "button__text">Pievienot jaunu īpašumu </span>
                <span class = "button__icon"><ion-icon name="add-outline"></ion-icon></span></button>   
     @endif
     </div>
     <!-- Datubāzes datu attēlošana tabulas veidā -->                      
    @if (count($ipasums)==0)
            <p > Nav pievienota neviena īpašuma!</p>
            
    @else
            <span style="float: right;">
                        <button id="printButton" type="button" class="button printbutton" >
                        <span class = "button__text">Drukāt tabulu</span>
                        <span class = "button__icon"><ion-icon name="print-outline"></ion-icon></span></button> 
                    </span> 
             
            <table id="printTable" class="printable" style='width:100%'>
            <thead>
                    <tr style='background-color: #bfc1c2'>
                        <th class="print"> nr. </th>
                        <th class="print"> Datums    </th>
                        <th class="print"> Īpašuma apraksts </th>
                        <th class="print"> Aģents </th>
                        <th class="print"> Termiņš</th>
                        <th > </th>
                        <th > </th>
                        <th > </th>
                        
                        
                    </tr>
                </thead>
            <tbody>


            @foreach ($ipasums as $ipasums)
           @php
        $terminsDate = Carbon::parse($ipasums->Termins_majaslapai);
    @endphp


                        <!-- Ieraksts  par Rezervēts pārdošanai īpašumu-->       
                        @if ($ipasums->loma == 'Rezervēts pārdošanai')
                         @if ($terminsDate->isToday() || $terminsDate->isPast())
                            <tr id="termins" >
                        @else
                        <tr id="rezervetspardosanai">
                        @endif
                        <td class="print"> {{$numurs += 1}}.</td>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print" > {{$ipasums->agent->agent}}</td>
                            <td class="print">{{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            
                        <!-- Poga statusa nomaiņai-->       
                            <td class="no-print" style="float:right">
                              @if(Auth::user()->loma == "admin")
                            <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                            data-target="#statussSoldModal"  >
                            
                            <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button>
                            @elseif(Auth::user()->loma == "user")
                             <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button>
                            @endif
                            </td>

                           <td>
                            <button type="button" class="button updateform mainitinfo" data-toggle="modal" data-target="#updateModal" data-id="{{ $ipasums->id }}"data-datums="{{$ipasums->Datums}}"
                            data-status="{{$ipasums->loma}}" data-lidzdate="{{$ipasums->rezervetslidztermins}}"
                            data-nosaukums="{{$ipasums->ipasuma_nosaukums}}" data-url="{{$ipasums->URL_adrese}}"
                            data-datums1="{{$ipasums->Termins_majaslapai}}">
                             <span class="button__icon">Mainīt info</span>
                            </button>
                        </td>
                        </tr>       
                
            @elseif ($ipasums->loma == 'Rezervēts nomai')
                            <!-- Ieraksts  par Rezervēts nomai īpašumu-->
                              @if ($terminsDate->isToday() || $terminsDate->isPast())
                            <tr id="termins" >
                        @else
                        <tr id="rezervetsnomai">
                        @endif
                            <td class="print"> {{$numurs += 1}}.</td>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            <!-- Poga statusa nomaiņai--> 
                            <td class="no-print" style="float:right">
                             @if(Auth::user()->loma == "admin")
                            <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                            data-target="#statussSoldModal"  >
                            
                            <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button></td>
                             @elseif(Auth::user()->loma == "user")
                             <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button>
                            @endif
                            <td>
                            <button type="button" class="button updateform mainitinfo" data-toggle="modal" data-target="#updateModal" data-id="{{ $ipasums->id }}"data-datums="{{$ipasums->Datums}}"
                            data-status="{{$ipasums->loma}}" data-lidzdate="{{$ipasums->rezervetslidztermins}}"
                            data-nosaukums="{{$ipasums->ipasuma_nosaukums}}" data-url="{{$ipasums->URL_adrese}}"
                            data-datums1="{{$ipasums->Termins_majaslapai}}">
                             <span class="button__icon">Mainīt info</span>
                            </button>
                        </td>
                            </tr>
            @elseif ($ipasums->loma == 'Rezervēts līdz')
                        <!-- Ieraksts  par rezervēts līdz īpašumu-->
                          @if ($terminsDate->isToday() || $terminsDate->isPast())
                            <tr id="termins" >
                        @else
                        <tr id="rezervetslidz">
                        @endif
                           <td class="print"> {{$numurs += 1}}.</td>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }} </td>
                            <td class="print"> {{$ipasums->loma}} {{ date('d-m-Y', strtotime($ipasums->rezervetslidztermins)) }} </td>
                            <!-- Poga īpašumu dzēšanai no datubāzes--> 
                            <td class="no-print" style="float:right">
                            @if(Auth::user()->loma == "admin")
                            <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                            data-target="#statussSoldModal"  >
                            
                            <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button>
                             @elseif(Auth::user()->loma == "user")
                             <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button>
                            @endif
                            </td>
                           <td>
                            <button type="button" class="button updateform mainitinfo" data-toggle="modal" data-target="#updateModal" data-id="{{ $ipasums->id }}"data-datums="{{$ipasums->Datums}}"
                            data-status="{{$ipasums->loma}}" data-lidzdate="{{$ipasums->rezervetslidztermins}}"
                            data-nosaukums="{{$ipasums->ipasuma_nosaukums}}" data-url="{{$ipasums->URL_adrese}}"
                            data-datums1="{{$ipasums->Termins_majaslapai}}">
                             <span class="button__icon">Mainīt info</span>
                            </button>
                        </td>
                            </tr>
            @elseif ($ipasums->loma == 'Pārdots')
                               
                        @if ($terminsDate->isToday() || $terminsDate->isPast())
                            <tr id="termins" >
                        @else
                            <tr id="pardots">
                        @endif
                         
                                
                          
                        <!-- Ieraksts  par Pārdotu īpašumu-->       
                      
                           <td class="print"> {{$numurs += 1}}.</td>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            <!-- Poga īpašumu dzēšanai no datubāzes--> 
                            <td class="no-print" style="float:right">  <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button></td>
                            <td>
                             
                            <button type="button" class="button updateform mainitinfo" data-toggle="modal" data-target="#updateModal"
                            data-id="{{ $ipasums->id }}"data-datums="{{$ipasums->Datums}}"
                            data-status="{{$ipasums->loma}}" data-lidzdate="{{$ipasums->rezervetslidztermins}}"
                            data-nosaukums="{{$ipasums->ipasuma_nosaukums}}" data-url="{{$ipasums->URL_adrese}}"
                             data-datums1="{{$ipasums->Termins_majaslapai}}"
                            >
                             <span class="button__icon">Mainīt info   </span>
                            </button>
                        </td>
                            </tr>
                            
            @else

              @if ($terminsDate->isToday() || $terminsDate->isPast())
                            <tr id="termins" >
                        @else
                        <!-- Ieraksts  par Iznomātu īpašumu-->      
                        <tr id="iznomats" >
                        @endif
                            <td class="print"> {{$numurs += 1}}.</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                        <!-- Poga īpašumu dzēšanai no datubāzes--> 
                        <td class="no-print" style="float:right">  <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></span></button></td>
                           <td>
                            <button type="button" class="button updateform mainitinfo" data-toggle="modal" data-target="#updateModal" data-id="{{ $ipasums->id }}"data-datums="{{$ipasums->Datums}}"
                            data-status="{{$ipasums->loma}}" data-lidzdate="{{$ipasums->rezervetslidztermins}}"
                            data-nosaukums="{{$ipasums->ipasuma_nosaukums}}" data-url="{{$ipasums->URL_adrese}}"
                             data-datums1="{{$ipasums->Termins_majaslapai}}">
                             <span class="button__icon">Mainīt info</span>
                            </button>
                        </td>
                            </tr>
            @endif
            @endforeach
           
                        </tbody>
                        </table>


 <div class="modal" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Jauna īpašuma pievienošana</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body with Form -->
                <div class="modal-body">
                
                  @if (Auth::user()->loma == "admin")
                <form id="updateForm"  method="POST" action="{{ route('ipasums.updatedata') }}">
                @elseif (Auth::user()->loma == "user")
                 <form id="updateForm"  method="POST" action="{{ route('ipasums.updatedataEmail') }}">
                @endif

                @csrf
                        <input type="hidden" name="user_name"  id="user_name" value="{{ Auth::user()->name }}">
                      
                        <input type="hidden" name="ipasumsid"  id="ipasumsid" value="">
                         <input type="hidden" id="Date" name="Date" value ="<?php echo date('Y-m-d') ?>">
                        <label for="Datums">Datums:</label>
                        <input type="date" id="Datums" name="Datums" value =""><br>

                        <label for="status">Izvēlies īpašuma statusu:</label>
                        <select id="status" name="status" size="1">
                           
                            <option value="Rezervēts līdz">Rezervēts līdz</option>
                            <option value="Rezervēts pārdošanai">Rezervēts pārdošanai</option>
                            <option value="Rezervēts nomai">Rezervēts nomai</option>
                            <option value="Pārdots">Pārdots</option>
                            <option value="Iznomāts">Iznomāts</option>

                            </select><br>
                            <label for="lidzdate" >Rezervēts līdz termiņš</label>
                            <input type="date" id="lidzdate" name="lidzdate" value=" "><br>
                            
                            <label for="text">Īpašuma nosaukums:</label>
                        <input type="text" id="nosaukums" name="nosaukums" value=""><br>

                            <label for="url">Īpašuma URL adrese:</label>
                            <input type="url" id="url" name="url" value=""><br>
                            
                            
                        
                            <label for="agent">Aģents: </label>
                            
                        <select id="agent" name="agent" size="1" >
                        <option value=""> </option>

                
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->agent }}</option>
                        @endforeach
                            
                            </select> <br>

                            <label for="Datums1">Termiņš mājaslapai:</label>
                            <input type="date" id="Datums1" name="Datums1" min="{{ date('Y-m-d') }}" value=""><br>  
                        
                            <button type="button" class="button form" id="getapstiprinajumubutton">
                                <span class = "button__text">Mainīt info </span>
                               </button>  
                </form>
                </div>

            </div>
        </div>
    </div>
    
    
    <div id="getapstiprinajumu" class="modal ">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title"> Īpašuma ieraksta mainīšana</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p>Vai tiešām vēlies rediģet  īpašuma ierakstu?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmupdate">Mainīt info</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Atcelt</button>
                  
                </div>
              </div>
            </div>
          </div>
    
    <!-- Modāla saturs pievienot jaunu īpašumu -->
   
<div class="modal" id="newobject">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Jauna īpašuma pievienošana</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
               
            <!-- Modal Body with Form -->
            <div class="modal-body">
            
            <button type="button" class="button"  onclick="RezervetsLidz()" >
                <span class = "button__text">Rezervēts līdz statuss </span> </button>
                <button type="button" class="button"  onclick="CitiStatusi()" >
                <span class = "button__text">Cits īpašuma statuss </span> </button>

                <div id = "RezervetsLidzStatuss" style = " display:none;">
                <h3> Rezervēts līdz statuss - datu ievade </h3>
                <form id="RezervetsLidz" method="POST" action="{{ route('ipasums.store') }}">
                    @csrf
                    <input type="hidden" name="user_name" id="user_name" value="{{ Auth::user()->name }}">
                    <label for="Datums">Datums:</label>
                    <input type="date" id="Datums" name="Datums" value="<?php echo date('Y-m-d') ?>"><br>

                   
                    
                    <input type="hidden" name="status" id="status" value="Rezervēts līdz">

                    <!-- Container for fields related to "Rezervēts līdz" -->
                   
                        <label for="lidzdate">Rezervēts līdz termiņš</label>
                        <input type="date" id="lidzdate" name="lidzdate" value=" "  required><br>
                    
                    <label for="text">Īpašuma nosaukums:</label>
                    <input type="text" id="nosaukums" name="nosaukums" value=""  required><br>

                    <label for="url">Īpašuma URL adrese:</label>
                    <input type="url" id="url" name="url" value="{{ old('url') }}"  required><br>

                    <label for="agent">Aģents: </label>
                    <select id="agent" name="agent" size="1"  required>
                        <option value=" "> --izvēlies atbilstošo aģentu-- </option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->agent }}</option>
                        @endforeach
                    </select> <br>

                    <label for="Datums1">Termiņš mājaslapai:</label>
                    <input type="date" id="Datums1" name="Datums1" min="{{ date('Y-m-d') }}" value=""  required><br>

                    <button type="button" class="button form" id="openConfirmationModal">
                        <span class="button__text">Pievienot</span>
                    </button>
                </form>
                </div>
                

                <div id = "CitiStatusiDiv" style = " display:none;">
                <h3> Citi statusi - datu ievade </h3>
                <form id="CitiStatusi" method="POST" action="{{ route('ipasums.store') }}">
                    @csrf
                    <input type="hidden" name="user_name" id="user_name" value="{{ Auth::user()->name }}">
                    <label for="Datums">Datums:</label>
                    <input type="date" id="Datums" name="Datums" value="<?php echo date('Y-m-d') ?>"><br>

                    <label for="status"> Izvēlies atbilstošo īpašuma statusu</label>
                    <select id="status" name="status" size="1"  >
                        <option value=" "> --izvēlies atbilstošo statusu-- </option>
                        <option value="Rezervēts pārdošanai">Rezervēts pārdošanai</option>
                        <option value="Rezervēts nomai">Rezervēts nomai</option>
                        <option value="Pārdots">Pārdots</option>
                        <option value="Iznomāts">Iznomāts</option>
                    </select><br>
                   
                   
                    <label for="text">Īpašuma nosaukums:</label>
                    <input type="text" id="nosaukums" name="nosaukums" value=""  required><br>

                    <label for="url">Īpašuma URL adrese:</label>
                    <input type="url" id="url" name="url" value="{{ old('url') }}"  required><br>

                    <label for="agent">Aģents: </label>
                    <select id="agent" name="agent" size="1"  required>
                        <option value=" "> --izvēlies atbilstošo aģentu-- </option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->agent }}</option>
                        @endforeach
                    </select> <br>

                    <label for="Datums1">Termiņš mājaslapai:</label>
                    <input type="date" id="Datums1" name="Datums1" min="{{ date('Y-m-d') }}" value=""  required><br>

                    <button type="button" class="button form" id="openConfirmationModal2">
                        <span class="button__text">Pievienot</span>
                    </button>
                </form>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
    <!-- modāla saturs jauna objekta pievienošanas apstiprināšanai -->
    <div id="confirmationModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Jauna īpašuma pievienošana</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p>Vai tiešām vēlies pievienot jaunu īpašumu?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmAdd">Pievienot</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Atcelt</button>
                  
                </div>
              </div>
            </div>
          </div>
          <div id="confirmationModal2" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Jauna īpašuma pievienošana</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p>Vai tiešām vēlies pievienot jaunu īpašumu?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmAdd2">Pievienot</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Atcelt</button>
                  
                </div>
              </div>
            </div>
          </div>
          
            
            <!-- Modāla saturs pogai Statusa maiņa --> 
            <div class="modal fade" id="statussSoldModal" tabindex="-1" role="dialog" aria-labelledby="statussSoldModalLabel" aria-hidden="true">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statussSoldModalLabel"> <span id="statusInfo"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Template Statusa maiņas modāla saturam -->
                                        <p>Ko Tu vēlies darīt ar īpašumu: <span id="productInfo"></span> ?</p>
                                        <p>Ja vēlies atcelt rezervējumu spied Dzēst.</p>
                                        <p>Ja vēlies mainīt statusu uz <span id="product"></span> spied <span id="product_b"></span></p>
                                        <p id="hiddenmodal" style = "display:none;" >Ja vēlies mainīt statusu uz Rezervēts nomai spied Nomai</p>
                                        <p>Ja nevēlies neko mainīt spied &times;</p>
                                        
                                <!-- Statusa maiņas/ dzēšanas forma -->
                                @if (Auth::user()->loma == "admin")
                                    <form id="propertyForm" method="POST"  action="{{ route('ipasums.changeStatusAndDelete') }}">

                               @elseif (Auth::user()->loma == "user")
                                    <form id="propertyForm" method="POST" class = "exceptform" action="{{ route('ipasums.changeStatusAndDeleteEmail') }}">
                               @endif
                                    @csrf
                                    <input type="hidden" name="user_name"  id="user_name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="ipasums_id"  id="ipasums_id" value="ipasums_id">
                                    <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d') ?>">
                                    <div class="row">
                                    <div class="col-sm-4">
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-block">Dzēst</button>
                                    </div>
                                    <div class="col-sm-4">
                                    <button type="submit" name="action" id= "statusaMaina" value="statusaMaina" class="btn btn-info btn-block text-truncate"><span id="productB" class="button-modal"></span></button>
                                    </div>
                                    <div class="col-sm-4">
                                    <button type="submit" name="action" id= "hiddenmodalbutton" value="reznomai" class="btn btn-info btn-block text-truncate" style="display:none"><span class="button-modal"> Nomai</span></button>
                                    </div>
                                </div>
                                </form>
                               
                            </div>
                        </div>
                    </div>
                </div>
             <!-- Modāla saturs pogai Dzēst īpāsumu Pārdots/Iznomāts īpašumiem --> 
             <div class="modal fade" id="statusDeleteModal" tabindex="-1" role="dialog" aria-labelledby="statusDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusDeleteModalLabel">Īpašuma dzēšana</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Template Statusa maiņas modāla saturam -->
                                        <p>Vai tiešām vēlies dzēst īpašumu: <span id="productDelete"></span> ?</p>        
                                <!-- Statusa maiņas/ dzēšanas forma -->
                                @if (Auth::user()->loma == "admin")
                                    <form id="propertyForm" method="POST" class = "exceptform" action="{{ route('ipasums.changeStatusAndDelete') }}">
                                @elseif (Auth::user()->loma == "user")
                                    <form id="propertyForm" method="POST" class = "exceptform" action="{{ route('ipasums.changeStatusAndDeleteEmail') }}">
                                @endif
                                
                                    @csrf
                                    <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d') ?>">
                                     <input type="hidden" name="user_name"  id="user_name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="ipasums_id"  id="ipasums_deleteid" value="ipasums_deleteid">
                                   
                                    <button type="submit" name="action" value="delete" class="btn btn-danger ">Dzēst</button>
                                   
                                  
                                    <button type="button" class="btn btn-secondary " data-dismiss="modal" aria-label="Close">Nedzēst</button>
                                    
                                    
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>


@endif


            <script>  
          new DataTable('#printTable', {
    paging: false,
    scrollCollapse: true,
    scrollY: '70vh',
     columns: [
         
         null, 
        { width: '100px' }, 
        null, 
        { width: '120px' },
        { width: '100px' }, 
        { width: '100px' }, 
        null, 
        null, 
        
    ]
});
    
         $(document).ready(function() {
         
               $('#openConfirmationModal').click(function() {
                        // Validate the form
                        var formIsValid = true;
                        $('#RezervetsLidz input[type="text"], #RezervetsLidz input[type="url"], #RezervetsLidz input[type="date"]').each(function() {
                            if ($(this).val() === "") {
                            formIsValid = false;
                            return false; // Exit the loop on the first empty field
                            }
                        });

                        if (formIsValid) {
                            $('#confirmationModal').modal('show');
                        } else {
                            alert('Visi lauki ir jāaizpilda pirms turpini!');
                        }
                });

             $('#confirmAdd').click(function() {
                        $('#RezervetsLidz').submit();
                    });

                     $('#openConfirmationModal2').click(function() {
                        // Validate the form
                        var formIsValid = true;
                        $('#CitiStatusi input[type="text"], #CitiStatusi input[type="url"], #CitiStatusi input[type="date"]').each(function() {
                            if ($(this).val() === "") {
                            formIsValid = false;
                            return false; // Exit the loop on the first empty field
                            }
                        });

                        if (formIsValid) {
                            $('#confirmationModal2').modal('show');
                        } else {
                            alert('Visi lauki ir jāaizpilda pirms turpini!');
                        }
                });

             $('#confirmAdd2').click(function() {
                        $('#CitiStatusi').submit();
                    });



                    
                $('.updateform').click(function () {
            // Get the values from the button's data attributes
            var data = $(this).data();
            
            // Set the values in the form
             $('#ipasumsid').val(data.id);
            $('#Datums').val(data.datums);
            $('#status').val(data.status);
            $('#lidzdate').val(data.lidzdate);
            $('#nosaukums').val(data.nosaukums);
            $('#url').val(data.url);
           
            $('#Datums1').val(data.datums1);
            
            
           
           
        });
         $('#getapstiprinajumubutton').click(function() {
                        // Validate the form
                        
                            $('#getapstiprinajumu').modal('show');
                        
                });

             $('#confirmupdate').click(function() {
                        $('#updateForm').submit();
                    });
           /*$('#openConfirmationModal').click(function() {
                        // Validate the form
                        var formIsValid = true;
                        $(' #propertyForm input[type="url"]').each(function() {
                            if ($(this).val() === "") {
                            formIsValid = true;
                            return false; // Exit the loop on the first empty field
                            }
                        });

                        if (formIsValid) {
                            $('#confirmationModal').modal('show');
                        } else {
                            alert('Visi lauki ir jāaizpilda pirms turpini!');
                        }
                });

             $('#confirmAdd').click(function() {
                        $('#propertyForm').submit();
                    });*/

            $('.sold').on('click', function(event) {
                    
                        event.preventDefault();

                        var productData = $(this).data('product');
                        var ipasumsId = $(this).data('id');
                        var productType =  $(this).data('type');
                        var pardots = 'pardots'
                        var iznomats = 'iznomats';
                        var reznoma = 'reznoma';
                        var rezpardots = 'rezpardots';

                        $('#productInfo').text(productData); // piešķir modāla saturam info par īpašuma aprakstu
                        $('#ipasums_id').val(ipasumsId); // piešķir vērtību hidden input par īpašuma ID
                    
                       
                                    
                        //Modāla saturs REZERVĒTS PĀRDOŠANAI
                        if (productType == 'Rezervēts pārdošanai') {
                            $('#statusInfo').text('Īpašuma statusa mainīšana / dzēšana');
                            $('#product').text('pārdots');
                            $('#product_b').text('pārdots');
                            $('#productB').text('pārdots');
                            $('#statusaMaina').val(pardots);
                            var x = document.getElementById("hiddenmodal");
                
                             x.style.display = "none";
                             var x = document.getElementById("hiddenmodalbutton");
                
                             x.style.display = "none";
                            }
                        //Modāla saturs REZERVĒTS NOMAI
                        else if(productType == 'Rezervēts nomai') {
                            $('#statusInfo').text('Īpašuma statusa mainīšana / dzēšana');
                            $('#product').text('iznomāts');
                            $('#product_b').text('iznomāts');
                            $('#productB').text('iznomāts');
                            $('#statusaMaina').val(iznomats);
                            var x = document.getElementById("hiddenmodal");
                
                             x.style.display = "none";
                             var x = document.getElementById("hiddenmodalbutton");
                
                             x.style.display = "none";
                            }
                        //Modāla saturs REZERVĒTS LĪDZ
                        else if(productType == 'Rezervēts līdz') {
                            var x = document.getElementById("hiddenmodal");
                
                             x.style.display = "block";
                             var x = document.getElementById("hiddenmodalbutton");
                
                             x.style.display = "block";
               
                            $('#statusInfo').text('Īpašuma Rezervēts līdz statusa mainīšana / dzēšana');
                            
                            $('#product').text('Rezervēts pārdošanai');
                            $('#product_b').text('Pārdošanai');

                            $('#productB').text(' Pārdošanai');
                            $('#statusaMaina').val(rezpardots);
                            }
                        
            });
             $('.delete').on('click', function(event) {
                        event.preventDefault();

                        var productInfo = $(this).data('product');
                        var ipasumsdeleteId = $(this).data('id');

                        // Set the content of the modal elements
                        $('#productDelete').text(productInfo);
                        $('#ipasums_deleteid').val(ipasumsdeleteId);
                    });
                });
                
                
            // funkcija, kas nodrošina tabulas drukāšanu          
            document.getElementById('printButton').addEventListener('click', function() {
                 

                 $('#printTable').DataTable().destroy();

    const printTable = document.getElementById('printTable').cloneNode(true);

    // Reinitialize DataTable after cloning
    $('#printTable').DataTable({
        paging: false,
        scrollCollapse: true,
        scrollY: '70vh'
    });
                // Apply inline styles for borders and spacing
                 printTable.style.borderSpacing = '10px'; // Add space between columns
                 printTable.style.borderCollapse = 'collapse'; // Collapse borders for rows
                // Apply styles to cells
                const rows = printTable.querySelectorAll('tr');
                rows.forEach(row => {
                    row.style.border = '1px solid #000'; // You can adjust the border style and color for rows
                    row.style.fontSize = "18px";
                });
                // Apply font size to all table text
                const links = printTable.querySelectorAll('a');
                links.forEach(link => {
                    link.style.color = '#000'; // Set link text color to black
                    link.style.textDecoration = 'none'; // Remove underlines
                });

                printTable.querySelectorAll('th:not(.print)').forEach(el => el.remove());
                printTable.querySelectorAll('td:not(.print)').forEach(el => el.remove());

                const currentDate = new Date();
                const formattedDate = currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();

                const printWindow = window.open('', '', 'width=1000,height=1000');
                printWindow.document.open();
                printWindow.document.write('<html><head><title>Visi pārdotie īpašumi uz ' + formattedDate + '</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h4>Visi pārdotie īpašumi uz ' + formattedDate + '</h4>');
                printWindow.document.write(printTable.outerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });



      
            function Tabula() {
                var x = document.getElementById("tabula");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
                }
                 function CitiStatusi() {
                var x = document.getElementById("CitiStatusiDiv");
                 var y = document.getElementById("RezervetsLidzStatuss");

                if (x.style.display === "none") {
                    x.style.display = "block";
                     y.style.display = "none";
                } else {
                    x.style.display = "none";
                }
                }
                 function RezervetsLidz() {
                var x = document.getElementById("RezervetsLidzStatuss");
                 var y = document.getElementById("CitiStatusiDiv");
                if (x.style.display === "none") {
                    x.style.display = "block";
                    y.style.display = "none";
                } else {
                    x.style.display = "none";
                }
                }
         
          
        </script>
    
    

@stop

