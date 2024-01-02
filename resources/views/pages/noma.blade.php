@extends('layouts.default')
@section('content')
<h3 >Iznomāto īpašumu saraksts </h3>

            
           @if (count($rented)==0)
            <p > Nav pievienota neviena iznomāta īpašuma!</p>
             
            @else
            <div>
                    <span style="float: right;">
                        <button id="printButton" type="button" class="button printbutton" >
                        <span class = "button__text">Drukāt tabulu</span>
                        <span class = "button__icon"><ion-icon name="print-outline"></ion-icon></span></button> 
                    </span> 
            </div>
            <table id="NomaTable" class="printable" style=' width:100%;'>
                <thead>
                        <tr style='background-color: #bfc1c2'>
                                <th class="print"> Kārtas nr. </th>
                                <th class="print"> Datums </th>
                                <th class="print"> Īpašuma apraksts </th>
                                <th class="print"> Aģents </th>
                                <th class="print" > Termiņš    </th>
                                <th >  </th>
                                <th> </th>
                        </tr>
                </thead>
                <tbody>
            @foreach ($rented as $rent)
            
                <tr style = 'background-color: #bbceb8;'>
                     <td class="print"> {{$numurs += 1}}.</td>
                    <td class="print"> {{ date('d-m-Y', strtotime($rent->Datums)) }}</td>
                    <td class="print"><a href="{{$rent->URL_adrese}}" target="_blank">{{$rent->ipasuma_nosaukums}}</a></td>
                    <td class="print"> {{$rent->agent->agent}}</td>
                    <td class="print"> {{ date('d-m-Y', strtotime($rent->Termins_majaslapai)) }}</td>
                    <!-- Poga īpašumu dzēšanai no datubāzes--> 
                    <td class="no-print" style="float:right">  <button type="button" class="button delete" data-toggle="modal" data-product = "{{$rent->ipasuma_nosaukums}}" data-id="{{$rent->id}}"  data-target="#statusDeleteModal">
                             <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></span></button></td>
                             <td>
                            <button type="button" class="button updateform" data-toggle="modal" data-target="#updateModal" data-id="{{$rent->id }}"data-datums="{{$rent->Datums}}"
                            data-status="{{$rent->loma}}" data-lidzdate="{{$rent->rezervetslidztermins}}"
                            data-nosaukums="{{$rent->ipasuma_nosaukums}}" data-url="{{$rent->URL_adrese}}"
                            data-datums1="{{$rent->Termins_majaslapai}}">
                             <span class="button__icon">Mainīt info</span>
                            </button>
                        </td>
                </tr>
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
                
                <form id="updateForm"  method="POST" action="{{ route('ipasums.updatedata') }}">
                
                @csrf
                        <input type="hidden" name="user_name"  id="user_name" value="{{ Auth::user()->name }}">
                        <p> {{ Auth::user()->name }} </p>
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
                            <label for="lidzdate">Rezervēts līdz termiņš</label>
                            <input type="date" id="lidzdate" name="lidzdate" value=" "><br>
                            
                            <label for="text">Īpašuma nosaukums:</label>
                        <input type="text" id="nosaukums" name="nosaukums" value=""><br>

                            <label for="url">Īpašuma URL adrese:</label>
                            <input type="url" id="url" name="url" value=""><br>
                            
                            
                        
                            <label for="agent">Aģents: </label>
                            
                        <select id="agent" name="agent" size="1" >
                        <option value=""><span id= "AgentName"></span></option>
                
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->agent }}</option>
                        @endforeach
                            
                            </select> <br>

                            <label for="Datums1">Termiņš mājaslapai:</label>
                            <input type="date" id="Datums1" name="Datums1" min="{{ date('Y-m-d') }}" value=""><br>  
                        
                            <button type="button" class="button form" id="getapstiprinajumubutton">
                                <span class = "button__text">Mainīt info  </span>
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
    
            <!-- Modāla saturs pogai Dzēst īpāsumu Pārdots/Iznomāts īpašumiem --> 
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
                </div>
            
@endif
<script>
     new DataTable('#NomaTable');
    $(document).ready(function() {
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
                    $('.delete').on('click', function(event) {
                        event.preventDefault();

                        var productInfo = $(this).data('product');
                        var ipasumsdeleteId = $(this).data('id');

                        // Set the content of the modal elements
                        $('#productDelete').text(productInfo);
                        $('#ipasums_deleteid').val(ipasumsdeleteId);
                    });
                });
        document.getElementById('printButton').addEventListener('click', function() {
                 const printTable = document.getElementById('NomaTable').cloneNode(true);
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
                printWindow.document.write('<html><head><title>Visi iznomāti īpašumi uz ' + formattedDate + '</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h4>Visi iznomātie īpašumi uz ' + formattedDate + '</h4>');
                printWindow.document.write(printTable.outerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });

    
            
</script>
@stop
