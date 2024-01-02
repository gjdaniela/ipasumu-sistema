
@extends('layouts.default')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <h2 class="printable" >Visi pievienotie īpašumi</h2>
    <button onclick="Tabula()">Tabulas lietošanas  paskaidrojumi</button>
    
    <div id="tabula" style = " background-color: #FFCCCB; display:none;">
    
    <p> Krāsu atšifrējums: 
    &nbsp; <span style='background-color:  #d9eff0'> Rezervēts nomai </span> &nbsp; <span style='background-color: #bbceb8'> Iznomāts </span>
    &nbsp; <span style='background-color: #9bc8c9'> Rezervēts pārdošanai </span> &nbsp;<span style='background-color: #9fbfab'> Pārdots </span> </span> &nbsp;<span style='background-color: #B0E0D5'> Rezervēts līdz </span> </p>
    <p> Ikonu atšifrējums: </p>
    <p> Ikonu atšifrējums: </p>
    <p> <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span> īpašumu statusa maiņa ( rezervēts nomai -> iznomāts, rezervēts pārdošanai -> pārdots, rezervēts līdz -> rezervēts), kā arī ja rezervējums tiek atcelts var izdzēst īpašuma ierakstu </p>
    <p> <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></span> īpašuma ieraksta dzēšana no beigu stāvokļiem iznomāts, pārdots  </p>
    </div>

           <!-- Datubāzes datu attēlošana tabulas veidā -->                      
    @if (count($ipasums)==0)
            <p > Nav pievienota neviena īpašuma!</p>
            <button type="button" class="button" onclick="AddObject()" >
                <span class = "button__text">Pievienot jaunu īpašumu </span>
                <span class = "button__icon"><ion-icon name="add-outline"></ion-icon></span></button> 
    @else
            <span style="float: right;">
                        <button id="printButton" type="button" class="button" >
                        <span class = "button__text">Drukāt tabulu</span>
                        <span class = "button__icon"><ion-icon name="print-outline"></ion-icon></span></button> 
                    </span> </p>
                    
            <table id="printTable" class="printable" style='width:100%'>
            <thead>
                    <tr style='background-color: #bfc1c2'>
                        <th class="print"> Datums    </th>
                        <th class="print"> Īpašuma apraksts </th>
                        <th class="print"> Aģents </th>
                        <th class="print"> Termiņš</th>
                        <th > </th>
                        <th > </th>
                    </tr>
                </thead>
            <tbody>


            @foreach ($ipasums as $ipasums)
                        <!-- Ieraksts  par Rezervēts pārdošanai īpašumu-->       
                        @if ($ipasums->loma == 'Rezervēts pārdošanai')
                        <tr style='background-color: #9bc8c9'>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print" > {{$ipasums->agent->agent}}</td>
                            <td class="print">{{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            
                        <!-- Poga statusa nomaiņai-->       
                            <td class="no-print" style="float:right">  <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                            data-target="#statussSoldModal"  >
                            
                            <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button></td>
                        </tr>       
                
            @elseif ($ipasums->loma == 'Rezervēts nomai')
                            <!-- Ieraksts  par Rezervēts nomai īpašumu-->       
                        <tr style='background-color: #d9eff0 '>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            <!-- Poga statusa nomaiņai--> 
                            <td class="no-print" style="float:right">  <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                            data-target="#statussSoldModal"  >
                            
                            <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button></td>
                        </tr>
            @elseif ($ipasums->loma == 'Rezervēts līdz')
                        <!-- Ieraksts  par rezervēts līdz īpašumu-->       
                        <tr style='background-color: #B0E0D5;'>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            <!-- Poga īpašumu dzēšanai no datubāzes--> 
                            <td class="no-print" style="float:right">  <button type="button" class="button sold" data-toggle="modal" data-type = "{{$ipasums->loma}}" data-product = " {{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"
                            data-target="#statussSoldModal"  >
                            
                            <span class = "button__icon"><ion-icon name="refresh-outline"></ion-icon></span></button></td>
                        </tr>
            @elseif ($ipasums->loma == 'Pārdots')
                        <!-- Ieraksts  par Pārdotu īpašumu-->       
                        <tr style='background-color:  #9fbfab'>
                        <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                            <!-- Poga īpašumu dzēšanai no datubāzes--> 
                            <td class="no-print" style="float:right">  <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></ion-icon></span></button></td>
                            </tr>
            @else

                        <!-- Ieraksts  par Iznomātu īpašumu-->      
                        <tr style='background-color: #bbceb8'>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                            <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                            <td class="print"> {{$ipasums->agent->agent}}</td>
                            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                            <td class="print"> {{$ipasums->loma}}</td>
                        <!-- Poga īpašumu dzēšanai no datubāzes--> 
                        <td class="no-print" style="float:right">  <button type="button" class="button delete" data-toggle="modal" data-product = "{{$ipasums->ipasuma_nosaukums}}" data-id="{{$ipasums->id}}"  data-target="#statusDeleteModal">
                            
                            <span class = "button__icon"><ion-icon name="trash-outline"></ion-icon></span></button></td>
                        </tr>
            @endif
            @endforeach
                        </tbody>
                        </table>
            

   
            
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
                                        <p>Ko Tu vēlies,lai  dara ar īpašumu: <span id="productInfo"></span> ?</p>
                                        <p>Ja vēlies,lai  rezervējums tiek atcelts spied Dzēst.</p>
                                        <p>Ja vēlies,lai statuss tiktu  mainīts  uz <span id="product"></span> spied <span id="product_b"></span></p>
                                        <p id="hiddenmodal" style = "display:none;" >Ja vēlies,lai statuss tiktu mainīts  uz Rezervēts nomai spied Nomai</p>
                                        <p>Ja nevēlies neko mainīt spied &times;</p>
                                        
                                <!-- Statusa maiņas/ dzēšanas forma -->
                                <form action="{{ route('ipasums.changeStatusAndDeleteEmail')  }}" method="POST">
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
                                <form action="{{ route('ipasums.changeStatusAndDeleteEmail')  }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d') ?>">
                                     <input type="hidden" name="user_name"  id="user_name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="ipasums_id"  id="ipasums_deleteid" value="ipasums_deleteid">
                                    <button type="submit" name="action" value="delete" class="btn btn-danger">Dzēst</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Nedzēst</button>
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
    scrollY: '70vh'
});
         $(document).ready(function() {
            

              $('#openConfirmationModal').click(function() {
                        // Validate the form
                        var formIsValid = true;
                        $('#propertyForm input[type="text"], #propertyForm input[type="url"], #propertyForm input[type="date"]').each(function() {
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
                        $('#propertyForm').submit();
                    });

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
          
          
        </script>
    
        

@stop

