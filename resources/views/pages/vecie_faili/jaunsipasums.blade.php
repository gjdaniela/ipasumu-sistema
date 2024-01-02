@extends('layouts.default')
@section('content')

<h3>Jauna īpašuma pievienošana</h3>
<form id="propertyForm" method="POST" action="{{ route('ipasums.store') }}">
   @csrf
           <label for="Datums">Datums:</label>
           <input type="date" id="Datums" name="Datums" value ="<?php echo date('Y-m-d') ?>"><br>

           <label for="status">Izvēlies īpašuma statusu:</label>
           <select id="status" name="status" size="1">
            <option value="Rezervēts pārdošanai">Rezervēts pārdošanai</option>
            <option value="Rezervēts nomai">Rezervēts nomai</option>
            <option value="Pārdots">Pārdots</option>
            <option value="Iznomāts">Iznomāts</option>
            </select><br>

            <label for="text">Īpašuma nosaukums:</label>
           <input type="text" id="nosaukums" name="nosaukums" value=""><br>

            <label for="url">Īpašuma URL adrese:</label>
           <!--<input type="url" id="url" name="url" value="">-->
           
              <input type="url" id="url" name="url" value="{{ old('url') }}"><br>
              @error('url')
                  <div class="alert alert-danger">Šī īpašuma URL adrese jau ir pievienota datu bāzē! </div>
              @enderror

           <label for="text">Aģents:</label>
           <input type="text" id="agents" name="agents" value=""><br>

            <label for="Datums1">Termiņš:</label>
            <input type="date" id="Datums1" name="Datums1" min="{{ date('Y-m-d') }}" value=""><br>  
           
            <button type="button" class="button" id="openConfirmationModal">
                <span class = "button__text">Pievienot  </span>
                <span class = "button__icon"><ion-icon name="add-outline"></ion-icon></span></button>  
  </form>
  <!-- Modāla saturs -->
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
  <script>
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