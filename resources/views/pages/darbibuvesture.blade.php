@extends('layouts.default')
@section('content')

<h4>Darbību vēsture </h4>
<form  action="{{ route('vesture.filtred') }}" method="POST">
        @csrf
        <p> Izvēlies laika posmu no <span><input type="date" name="startDate" id="StartDate"></span> līdz
            <span><input type="date" name="endDate" id="EndDate" max="{{ date('Y-m-d') }}"></span> <span> </span> <span>
            <button type="submit" class="button"  role="button" >
                <span class = "button__text"> Parādīt </span>
                <span class = "button__icon"><ion-icon name="eye-outline"></ion-icon></span></button> 
           
        </span> </p>
    </form>



@if (count($vesture) == 0)
            <p > Nav pievienota neviena darbības vēstures ieraksta!</p>
    @else
   
   <table id="VestureTable" class="printable" style=' width:100%;'>
                <thead>
                        <tr style='background-color: #bfc1c2'>
                                <th class="print">Laika posms: {{ date('d-m-Y', strtotime($startDate)) }}  – {{ date('d-m-Y', strtotime($endDate)) }}  </th>
                                <th class="print"> </th>
                                <th class="print">  </th>
                                <th class="print"> </th>
                        </tr>
                        

                </thead>
                <tbody>
            @foreach ($vesture as $vesture)
            
                <tr >
                    <td class="print"> {{ date('d-m-Y', strtotime($vesture->date)) }} </td>
                     <td>Lietotājs <span>{{$vesture->user}} </span></td>
                    <td> <span> {{$vesture->action}} </span></td>
                      <td>  <span>{{$vesture->name}}</span></td>

                    
                </tr>
            @endforeach
            </tbody>
            </table>
    
   
  @endif

    <script>
        $(document).ready(function () {
            // Initialize DataTable
                 // Initialize DataTable
        var table = $('#VestureTable').DataTable({
            "paging": true, // Enable paging
            "pageLength": 10, // Set number of rows per page
        });

        // Hide the header after DataTable is initialized
        table.on('init.dt', function () {
            $('#VestureTable thead').css('display', 'none');
        });

        // Apply DataTable on the table
        table.draw();
    });
    </script>
@stop
