@extends('layouts.default')
@section('content')

<!-- Page Content -->
<div class="container">
 

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
              
                <div class="card-body">
                <h4>Aģentu pārskats un pievienošana  </h4>
                      @if (session('success'))
                          <div class="alert alert-success">
                              {{ session('success') }}
                          </div>
                      @endif

                      <button onclick="Agent()">Pievienot aģentu</button>
                      <br>
                      <div id="addAgent" style = "display:none;">
                          <form method="POST" action="{{ route('agents.store') }}">
                                  @csrf
                                <label for="Agentname">Aģenta vārds:</label> <input type="text" id="Agentname" name="Agentname" value="">
                                <input type="submit" value="Submit">
                          </form>
                      </div>

     
     <!-- Datubāzes datu attēlošana tabulas veidā -->                      
     @if (count($agents) == 0)
            <p > Nav pievienota neviena aģenta!</p>
    @else
    <h4>Pievienotie aģenti </h4>
    <dl>
    @foreach ($agents as $agents)
  <dt><ion-icon name="person-circle-outline"></ion-icon> {{$agents->agent}} </dt>
  @endforeach
  
</dl>
@endif
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
              
                <div class="card-body">
                    <h4 class="card-title">

                        Jauns lietotājs <ion-icon name="people-circle-outline"></ion-icon>
                    </h4>
                    <p class="card-text">
                      lietotāju saraksts 
                    </p>
                    <p class="card-text">
                      lietotāju pievienošana
                    </p>
                   <a href="/auto/public/iestatijumi/lietotaji"> <button> Apskatīt </button></a>
                </div>
            </div>
        </div>
        
    </div>
    
<!-- /.container -->


<script>
function Agent() {
  var x = document.getElementById("addAgent");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

@stop