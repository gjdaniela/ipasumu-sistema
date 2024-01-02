
@extends('layouts.default')
@section('content')

    <h2 class="printable" >Visi pievienotie īpašumi</h2>
    <p> Krāsu atšifrējums: 
    &nbsp; <span style='background-color:  #d9eff0'> Rezervēts nomai </span> &nbsp; <span style='background-color: #bbceb8'> Iznomāts </span>
    &nbsp; <span style='background-color: #9bc8c9'> Rezervēts pārdošanai </span> &nbsp;<span style='background-color: #9fbfab'> Pārdots</span> 
    
    <span style="float: right;">
                <button id="printButton" type="button" class="button" >
                <span class = "button__text">Drukāt tabulu</span>
                <span class = "button__icon"><ion-icon name="print-outline"></ion-icon></span></button> 
            </span> </p>
            
     <!-- Datubāzes datu attēlošana tabulas veidā -->                      
    @if (count($ipasums)==0)
            <p > Nav pievienota neviena īpašuma!</p>
    @else
            
           <table id="printTable" class="printable" style='width:100%'>
           <tbody>
            <tr  style='background-color: #d9eff0'>
                    <th class="print"> Datums </th>
                    <th class="print"> Īpašuma apraksts </th>
                    <th class="print"> Aģents </th>
                    <th class="print" > Termiņš    </th>
                    <th class="print"></th>
                    @if(Auth::user()->loma == "admin")
                    <th class="no-print" style="float:right"> <button type="button" class="button" onclick="AddObject()" >
                <span class = "button__text">Pievienot jaunu īpašumu </span>
                <span class = "button__icon"><ion-icon name="add-outline"></ion-icon></span></button>  </th>
                @else <th></th>
                @endif
            </tr>

            @foreach ($ipasums as $ipasums)
             <!-- Ieraksts  par Rezervēts pārdošanai īpašumu-->       
            @if ($ipasums->loma == 'Rezervēts pārdošanai')
            <tr style='background-color: #9bc8c9'>
            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                <td class="print" > {{$ipasums->Agents}}</td>
                <td class="print">{{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                <td class="print"> {{$ipasums->loma}}</td>
                
             <!-- Poga statusa nomaiņai-->       
                <td class="no-print" style="float:right">  <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                 data-target="#statussSoldModal"  >
                <span class = "button__text">Mainīt statusu </span>
                <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button></td>
                
                
            @elseif ($ipasums->loma == 'Rezervēts nomai')
                 <!-- Ieraksts  par Rezervēts nomai īpašumu-->       
            <tr style='background-color: #d9eff0 '>
            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                <td class="print"> {{$ipasums->Agents}}</td>
                <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                <td class="print"> {{$ipasums->loma}}</td>
                 <!-- Poga statusa nomaiņai--> 
                <td class="no-print" style="float:right">  <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                 data-target="#statussSoldModal"  >
                <span class = "button__text">Mainīt statusu </span>
                <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button></td>
                
            @elseif ($ipasums->loma == 'Pārdots')
             <!-- Ieraksts  par Pārdotu īpašumu-->       
            <tr style='background-color:  #9fbfab'>
            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                <td class="print"> {{$ipasums->Agents}}</td>
                <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                <td class="print"> {{$ipasums->loma}}</td>
                   <!-- Poga īpašumu dzēšanai no datubāzes--> 
                <td class="no-print" style="float:right">  <button type="button" class="button delete" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                <span class = "button__text">Dzēst īpašumu</span>
                <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button></td>
            @else

             <!-- Ieraksts  par Iznomātu īpašumu-->      
            <tr style='background-color: #bbceb8'>
                <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                <td class="print"> {{$ipasums->Agents}}</td>
                <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                <td class="print"> {{$ipasums->loma}}</td>
              <!-- Poga īpašumu dzēšanai no datubāzes--> 
              <td class="no-print" style="float:right">  <button type="button" class="button delete" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                <span class = "button__text">Dzēst īpašumu</span>
                <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button></td>
            </tr>
            @endif
            @endforeach
            </tbody>
            </table>
            <!-- Modāla saturs pogai Statusa maiņa --> 
            <div class="modal fade" id="statussSoldModal" tabindex="-1" role="dialog" aria-labelledby="statussSoldModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statussSoldModalLabel">Īpašuma statusa mainīšana / dzēšana</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Template Statusa maiņas modāla saturam -->
                                        <p>Ko Tu vēlies darīt ar īpašumu: <span id="productInfo"></span> ?</p>
                                        <p>Ja vēlies atcelt rezervējumu spied Dzēst.</p>
                                        <p>Ja vēlies mainīt statusu uz <span id="product"></span> spied <span id="product_b"></span></p>
                                        <p>Ja nevēlies neko mainīt spied &times;</p>
                                <!-- Statusa maiņas/ dzēšanas forma -->
                                <form action="{{ route('ipasums.changeStatusAndDelete')  }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="ipasums_id"  id="ipasums_id" value="ipasums_id">
                                    <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d') ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-danger">Dzēst</button>
                                    <button type="submit" name="action" id= "statusaMaina" value="statusaMaina" class="btn btn-success"><span id="productB"></span></button>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">Neko</button>
                                </form>
                               
                            </div>
                        </div>
                    </div>
                </div>
             <!-- Modāla saturs pogai Dzēst īpāsumu Pārdots/Iznomāts īpašumiem --> 
             <div class="modal fade" id="statusDeleteModal" tabindex="-1" role="dialog" aria-labelledby="statusDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document1">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusDeleteModalLabel">Īpašuma statusa mainīšana / dzēšana</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Template Statusa maiņas modāla saturam -->
                                        <p>Vai tiešām vēlies dzēst īpašumu: <span id="productInfo"></span> ?</p>
                                        
                                <!-- Statusa maiņas/ dzēšanas forma -->
                                <form action="{{ route('ipasums.changeStatusAndDelete')  }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="ipasums_id"  id="ipasums_id" value="ipasums_id">
                                    <button type="submit" name="action" value="delete" class="btn btn-danger">Dzēst</button>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">Nedzēst</button>
                             </form>
                               
                            </div>
                        </div>
                    </div>
                </div>


@endif


         <script>  
         $(document).ready(function() {
                    $('.sold').on('click', function(event) {
                    
                        event.preventDefault();

                        var productData = $(this).data('product');
                        var ipasumsId = $(this).data('id');
                        var productType =  $(this).data('type');
                        var pardots = 'pardots'
                        var iznomats = 'iznomats';

                        $('#productInfo').text(productData); // piešķir modāla saturam info par īpašuma aprakstu
                        $('#ipasums_id').val(ipasumsId); // piešķir vērtību hidden input par īpašuma ID
                    
                        //Modāla saturs REZERVĒTS PĀRDOŠANAI
                        if (productType == 'Rezervēts pārdošanai') {
                            $('#product').text('pārdots');
                            $('#product_b').text('pārdots');
                            $('#productB').text('pārdots');
                            $('#statusaMaina').val(pardots);
                            }
                        //Modāla saturs REZERVĒTS NOMAI
                        else if(productType == 'Rezervēts nomai') {
                            $('#product').text('iznomāts');
                            $('#product_b').text('iznomāts');
                            $('#productB').text('iznomāts');
                            $('#statusaMaina').val(iznomats);
                            }
                    });
                }); 
        /* $(document1).ready(function() {
                    $('.delete').on('click', function(event1) {
                    
                    event1.preventDefault();

                    var productData = $(this).data('product');
                    var ipasumsId = $(this).data('id');

                    $('#productInfo').text(productData); // piešķir modāla saturam info par īpašuma aprakstu
                    $('#ipasums_id').val(ipasumsId); // piešķir vērtību hidden input par īpašuma ID
                });
            }); */
            // funkcija, kas nodrošina tabulas drukāšanu          
            document.getElementById('printButton').addEventListener('click', function() {
                 const printTable = document.getElementById('printTable').cloneNode(true);
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
                printWindow.document.write('<html><head><title>Visi īpašumi uz ' + formattedDate + '</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h4>Visi īpašumi uz ' + formattedDate + '</h4>');
                printWindow.document.write(printTable.outerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });

            function AddObject() {window.location.href="/auto/public/jaunsipasums";}
          
  
          
        </script>
    

@stop

