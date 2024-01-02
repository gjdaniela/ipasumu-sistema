
@extends('layouts.default')
@section('content')
<h3>Izmēģinājums</h3>

<table id="statusTable" class="table table-striped" style="width:100%">
           
                    <th class="print"> Datums </th>
                    <th class="print"> Īpašuma apraksts </th>
                    <th class="print"><div class="dropdown"> Aģents 
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      
                         
                         </th>
                    <th class="print" > Termiņš    </th>
                    <th class="print"></th>
                    
            </tr>

            @foreach ($ipasums as $ipasums)
            <tr >
            <td class="print"> {{ date('d-m-Y', strtotime($ipasums->Datums)) }}</td>
                <td class="print"><a href="{{$ipasums->URL_adrese}}" target="_blank">{{$ipasums->ipasuma_nosaukums}}</a></td>
                <td class="print" > {{$ipasums->agent->agent}}</td>
                <td class="print">{{ date('d-m-Y', strtotime($ipasums->Termins_majaslapai)) }}</td>
                <td class="print"> {{$ipasums->loma}}</td>
            @endforeach
            </table>
                
           
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>            
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js">
   
    $(document).ready(function () {
        var table = $('#statusTable').DataTable();
    });
</script>        
    
@stop