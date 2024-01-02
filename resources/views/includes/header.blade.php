
<nav id="custom-navbar" class="navbar navbar-expand-lg navbar-light" style="background-color: #777777 ">
 
<a class="navbar-brand" href="/auto/public/dashboard">
    <img src="https://www.niv.lv/images/banners/niv_00.jpg" width="100" height="60" alt="logo">
  </a>
 
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="navbar-brand dropdown-toggle " href="/auto/public/dashboard" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <span class="navbutton" >Īpašumi </span> <span class="navicon"><ion-icon name="home-outline"></ion-icon></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/auto/public/pardoti">Pārdoti</a>
          <a class="dropdown-item" href="/auto/public/rezervetipardosanai">Rezervēti pārdošanai</a>
          <a class="dropdown-item" href="/auto/public/noma">Iznomāti</a>
          <a class="dropdown-item" href="/auto/public/rezervetinoma">Rezervēti nomai</a>
          <a class="dropdown-item" href="/auto/public/rezervetlidz">Rezervēti līdz </a>
        </div>
</li>
        
        </div>
      
	
	

  <div>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="navbar-brand dropdown-toggle navbar-brand" href="/" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
         Esi sveicināts , {{ Auth::user()->name }} !
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('profile.edit') }}"> <ion-icon name="settings-outline"></ion-icon> Paroles maiņa</a>
          <a class="dropdown-item" href="/auto/public/darbibuvesture"><ion-icon name="footsteps-outline"></ion-icon> Darbību vēsture </a>
          @if(Auth::user()->loma == "admin")
        <a class="dropdown-item" href="/auto/public/iestatijumi"> <ion-icon name="pencil-outline"></ion-icon> Aģenti/ Lietotāji </a>
@endif
         
        </div>
        </div>
      </li>    
  
  <form method="POST" action="{{ route('logout') }}">
                    @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                       <img src="https://www.niv.lv/images/auto/icons8-logout-100.png" width="20" height="20" alt="logout"> </a>
                </form> 
</div>              
</nav>
