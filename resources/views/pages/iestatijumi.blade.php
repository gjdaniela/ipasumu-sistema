@extends('layouts.default')
@section('content')




    
<!-- Page Content -->
<div class="container" id ="iestatijumi">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class=" h-100">
                <div class="card card-body agentcard" >
              
                        @if (session('success'))
                                  <div class="alert alert-success">
                                      {{ session('success') }}
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                  </div>
                         @endif
                    @if (count($agents) == 0)
                        <p > Nav pievienota neviena aģenta!</p>
                    @else
                            <h4> Aģentu pārskats </h4>
                            
                            @foreach ($agents as $agents)
                          <p> {{$agents->agent}} </p>
                          @endforeach
                       
                    @endif
                </div>
                
   
                <div id="addAgentUser"class="card card-body">
                 @error('Agentname')
                         <div class="alert alert-danger">Jau eksistē pievienots aģents ar šādu  vārdu!</div>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                             </button>
                  @enderror
                <button type="button" class="button agentcard" onclick="Agent()" >
               Jauna aģenta pievienošana 
                </button>
                
                            <div id="addAgent" style = "display:none;">
                                          <form method="POST" action="{{ route('agents.store') }}">
                                                  @csrf
                                                <label for="Agentname">Aģenta vārds:</label> <input type="text" id="Agentname" name="Agentname" value="">
                                               
                                                     <button  class="button  form-button agentcard" type="submit">
                                                            Pievienot  
                                                            </button>
                                          </form>
                             </div>
                
               
            
                 @error('email')
                                          <div class="alert alert-danger">Jau eksistē profils ar šo epasta adresi vai arī tika pievienots nepareizs domēns!</div>
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                      @enderror
                
   <button type="button" class="button" onclick="User()" >
                Jauna lietotāja pievienošana 
               </button>
                      <div id="addUser" style = "display:none;">
                  
                                   <form id="propertyForm" method="POST" action="{{ route('lietotajs.store') }}">
                           @csrf
                                   <label for="name">Vārds:</label>
                                   <input type="text" id="name" name="name" value =""><br>

                                   <label for="email">Epasts:</label>
                                   <input type="email" id="email" name="email" value =""><br>
                                   
                                   <label for="password">Parole:</label>
                                   <input type="password" id="password" name="password" value =""><br>


                                   <label for="loma">Izvēlies lietotāja lomu:</label>
                                   <select id="loma" name="loma" size="1">
                                    <option value="admin">admin</option>
                                    <option value="user">user</option>
                                    </select><br>
                                    <button type="button" class="button  form-button" id="openConfirmationModal">
                                                        Pievienot  
                                                        </button>
            
                          </form>
                    </div>
                
                
                    </div>
                
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
              
                <div class="card-body">
                   
                    

                    
          @if (count($lietotaji)==0)
            <p > Nav pievienota neviena lietotāja!</p>
             
            @else
            <h4 class="card-title"> Lietotāju pārskats</h4>
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

function User() {
    var x = document.getElementById("addUser");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
};

$(document).ready(function () {
    $('#openConfirmationModal').click(function () {
        // Validate the form
        var formIsValid = true;
        $('#propertyForm input[type="text"], #propertyForm input[type="url"], #propertyForm input[type="date"]').each(function () {
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

    $('#confirmAdd').click(function () {
        // Check for email error
        if ($('#propertyForm .alert-danger').length > 0) {
            // If there is an email error, show the addUser div
            $('#addUser').show();
        }

        // Submit the form
        $('#propertyForm').submit();
    });
});
</script>




@stop
