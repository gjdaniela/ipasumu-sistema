<!doctype html>
<html>
<head>
   @include('includes.head')
   <style>
    
    body{
        background-image: ("https://niv.lv/images/auto/DJI_0946.jpg"); 
        background-repeat: no-repeat;
        background-size: 300px 100px; 
        background-attachment: fixed; 
        background-size: 100% 100%;  
    }
    
    .button{
        display:inline-flex;
        height:45px;
        padding:0;
        background: #bfc1c2;
        border: none;
        outline:none;
        border-radius:15px;
        overflow: hidden;
        font-family: 'Quicsand', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor:pointer;
        opacity: 0.8;
    }
    .button__text,
    .button__icon{
        display: inline-flex;
        align-items: center;
        padding: 0 16px;
        height: 100%;
    }
    .button__text{
        color:  black;
    }
    .button__icon{
        color:black;
        background: #bfc1c2;
        font-size: 1.5em;
    } 
    table{
        border: 1px solid black;
        
    }
    tr{
       border: 1px solid black;
    }
    tbody{
        font-size: 18px;
        
    }
    a{
        color: black;
    }
    
    

#tabula {
    font-family: 'Arial', sans-serif; /* Replace with your preferred font */
    position: relative;
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9; /* Light background color */
    border: 1px solid #ddd; /* Light border color */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    overflow: hidden; /* Hide overflowing content */
}

#tabula p {
    font-size: 16px; /* Different font size for the p element */
    color: #333; /* Dark text color */
    line-height: 1.6;
}

#tabula:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    border-top: 25px solid #ffd700; /* Light gold torn page color */
    border-left: 25px solid transparent;
    width: 0;
    height: 0;
}

#tabula span {
    font-size: 16px; /* Different font size for the span elements */
    color: #555; /* Slightly darker text color */
    padding: 8px 12px;
    margin-right: 10px;
    border-radius: 4px;
    display: inline-block;
}

.TableButton  {
    margin-bottom: 10px; 
}
.printbutton {
     margin-bottom: 10px; 
}
.agentcard{
     margin-bottom: 20px;

}
#iestatijumi {
    font-family: 'Arial', sans-serif; /* Replace with your preferred font */
    position: relative;
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9; /* Light background color */
    border: 1px solid #ddd; /* Light border color */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    overflow: hidden; /* Hide overflowing content */
}

#iestatijumi p {
    font-size: 16px; /* Different font size for the p element */
    color: #333; /* Dark text color */
    line-height: 1.6;
}



#iestatijumi span {
    font-size: 16px; /* Different font size for the span elements */
    color: #555; /* Slightly darker text color */
    padding: 8px 12px;
    margin-right: 10px;
    border-radius: 4px;
    display: inline-block;
}



.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;

}
.card:before{
     content: '';
    position: absolute;
    top: 0;
    right: 0;
    border-top: 25px solid #ffd700; /* Light gold torn page color */
    border-left: 25px solid transparent;
    width: 0;
    height: 0;
}
.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-title {
    color: #333;
}

.alert {
    margin-bottom: 20px;
}

/* mainīt info poga */
.mainitinfo {  
   display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    height: 40px !important; /* Adjust the height as needed */
    white-space: nowrap !important; /* Prevent text from wrapping */
    overflow: hidden !important; /* Hide overflow if text is longer than the button */
    text-overflow: ellipsis !important;
}


#addAgent,
#addUser {
    display: none;
    margin-top: 20px;
}

#propertyForm label {
    margin-right: 5px;
}

#UserTable {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    margin-bottom: 10px;
}

#UserTable th,
#UserTable td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

#UserTable th {
    background-color: #bfc1c2;
}



.container {
    margin-top: 20px;
}

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-title {
    color: #333;
}

.alert {
    margin-bottom: 20px;
}

form{
    display: flex;
    flex-direction: column;
}
.exceptform{
    flex-direction: initial;
}
/* Style for the buttons in the modal */
#statusDeleteModal .btn-danger, #statusDeleteModal .btn-secondary {
    display: inline-block;
    width: auto;
    margin-right: 10px; /* Adjust the margin as needed for spacing */
}

/* Optional: If you want the last button to have no right margin */
#statusDeleteModal .btn-secondary:last-child {
    margin-right: 0;
}


label {
    margin-bottom: 5px;
    color: #495057; /* Dark gray text color */
}

input,
select {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ced4da; /* Light gray border */
    border-radius: 5px;
}

/* Success message style */
.alert-success {
    background-color: #d4edda; /* Bootstrap success background color */
    color: #155724; /* Bootstrap success text color */
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb; /* Bootstrap success border color */
    border-radius: 5px;
}

/* Error message style */
.alert-danger {
    background-color: #f8d7da; /* Bootstrap danger background color */
    color: #721c24; /* Bootstrap danger text color */
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb; /* Bootstrap danger border color */
    border-radius: 5px;
}
.card h4 {
    /* Dark text color */
    margin-bottom: 20px;
}

.form-button {
    background-color: #ffd700; /* Bootstrap warning color (golden) */
    color: #fff; /* White text color */
    text-align: center;
}
 #addAgentUser button{
    color: #fff;
    font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
 }
 .form {
      font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
 }

 /* Add this to your existing CSS file or create a new one */

/* Section styling */
#password-reset-section {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 8px;
     display: flex;
    flex-direction: column;
}


/* Header styling */
#password-reset-section header {
    text-align: center;
    margin-bottom: 20px;
}

.multiline-column {
    white-space: normal !important;
}



/* Text input styling */
.x-text-input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}
.password
{

     color: #fff;
    font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}


/* Success message styling */
.text-success {
    font-size: 14px;
    color: #28a745;
    margin-top: 10px;
}

  #reservedlidzizvele {
    transform: scale(1.5); /* Adjust the scale value to change the size of the checkbox */
    margin-right: 5px; /* Adjust the margin as needed */
    margin-bottom: 20px;
}

label[for="reservedlidzizvele"] {
    font-size: 18px; /* Adjust the font size as needed */
    
}

    
#rezervetspardosanai{
   background-color: #9bc8c9 !important;
}
#rezervetsnomai{
 background-color: #d9eff0 !important;
}
#rezervetslidz
{
    background-color: #B0E0D5 !important;
}
#pardots{
   background-color:  #9fbfab !important;
}
#termins{
   background-color:  #ff6961 !important;
}
#iznomats{
    background-color: #bbceb8 !important; 
}

    
   </style>
</head>
<body>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

   <header >
       @include('includes.header')
   </header>
   <div class="w-90 p-3" >
           @yield('content')
           
    </div>

   <footer >
       @include('includes.footer')
   </footer>

</body>
</html>
