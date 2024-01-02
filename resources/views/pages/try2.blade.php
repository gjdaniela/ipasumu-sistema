@extends('layouts.default')
@section('content')
<h3>Izmēģinājums2</h3>
<table id="statusTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Datums </th>
            <th>Īpašuma apraksts</th>
            <th>Aģents</th>
            <th> Termiņš</th>
            <th> </th>
        </tr>
    </thead>
    <tbody>
         @foreach ($ipasums as $ipasums)
        <tr>
         <td > {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                <td ><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                <td  > {{$ipasums->agent->agent}}</td>
                <td >{{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                <td > {{$ipasums->loma}}</td>
        </tr>
            @endforeach
        
    </tbody>
</table>

          
     
     <script>
        new DataTable('#statusTable');
     $(document).ready( function () {
       
        
        $('#statusTable').DataTable( {
    buttons: [
        'copy', 'excel', 'pdf'
    ]
} );
} );

     </script>
@stop