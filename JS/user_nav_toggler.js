

var nav_toggled = true;



function ToggleNav(){
    
    var nav = document.getElementById('nav-toggler-id');
    var nav_cont = document.getElementById('nav-user-cont-id');

    if (nav_toggled){
        nav_toggled = false;
        nav.style.backgroundImage = " url(CSS/Resources/Icons/icon-hamburger-undocked.svg)";
        nav_cont.style.display = "flex";
    }
    else{
        nav_toggled = true;
        
        nav.style.backgroundImage = " url(CSS/Resources/Icons/icon-hamburger-docked.svg)";
        nav_cont.style.display = "none";
    }
  
  
    
}
