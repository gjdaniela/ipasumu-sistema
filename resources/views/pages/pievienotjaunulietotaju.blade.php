@extends('layouts.default')
@section('content')

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title"> Lietotāju pārskats</h4>

                    <button onclick="User()">Pievienot lietotāju</button>
                      <br>
                      <div id="addUser" style = "display:none;">
                    <h3>Jauna lietotāja pievienošana</h3>
<!--<p> Atgādinājums!</p>
<p> admin lomai ir pieejas visām  user darbībām un vēl – īpašumu statusu rediģēšanai, dzēšanai un jauna lietotāja pievienošana</p>
<p> user lomai ir minimālas pieejas tikai tabulu apskatīšana un īpašumu rediģēšanas aicinājuma izteikšana, kā arī darbību vēstures un paziņojumu apskatīšana </p>
<p> Šī ir vienīgā iespēja šajā web lietotnē pievienot jaunu lietotāju, tāpēc jaunajam lietotāja pirmoreizi ielogojoties drošības apsvērumu dēļ ir aicināts nomainīt paroli pie profila iestatījumiem</p>
-->
<form id="propertyForm" method="POST" action="{{ route('lietotajs.store') }}">
   @csrf
           <label for="name">Vārds:</label>
           <input type="text" id="name" name="name" value =""><br>

           <label for="email">Epasts:</label>
           <input type="email" id="email" name="email" value =""><br>
           @error('email')
                  <div class="alert alert-danger">Jau eksistē profils ar šo epasta adresi!</div>
              @enderror
           <label for="password">Parole:</label>
           <input type="password" id="password" name="password" value =""><br>


           <label for="loma">Izvēlies lietotāja lomu:</label>
           <select id="loma" name="loma" size="1">
            <option value="admin">admin</option>
            <option value="user">user</option>
            </select><br>

            <button type="button" class="button" id="openConfirmationModal">
                <span class = "button__text">Pievienot  </span>
                <span class = "button__icon"><ion-icon name="add-outline"></ion-icon></span></button>  
  </form>

  <!-- Modāla saturs -->
      <div id="confirmationModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Jauna lietotāja pievienošana</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p>Vai tiešām vēlies pievienot jaunu lietotāju?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmAdd">Pievienot</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Atcelt</button>
                  
               </div>
              </div>
            </div>
          </div>
          </div>

          @if (count($lietotaji)==0)
            <p > Nav pievienota neviena lietotāja!</p>
             
            @else
            
            <table id="UserTable"  >
                      <thead>
                              <tr style='background-color: #bfc1c2'>
                                      <th >Vārds </th>
                                      <th > Epasts </th>
                                      <th > Loma</th>
                                    
                              </tr>
                      </thead>
                      <tbody>
                            @foreach ($lietotaji as $lietotajs)
                            
                                <tr>
                                    <td > {{$lietotajs->name}}</td>
                                    <td > {{$lietotajs->email}}</td>
                                    <td > {{ $lietotajs->loma }}</td>
                                    
                                </tr>
                            @endforeach
                  </tbody>
            </table>
            @endif
       
       </div>
      </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
              
                <div class="card-body">
                    <h4 class="card-title">

                    Aģenti
                    </h4>
                    <p class="card-text">
                      aģentu saraksts 
                    </p>
                    <p class="card-text">
                      aģentu pievienošana
                    </p>
                    <a href="/auto/public/iestatijumi/agenti"><button> Apskatīt </button></a>
                </div>
            </div>
        </div>
        
    </div>
    
<!-- /.container -->


          
  <script>
   
   function User() {
  var x = document.getElementById("addUser");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
};
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
   });
</script>     
  
@stop