<script>
var mySidebar = document.getElementById("mySidebar");
var main = document.getElementById("main");
var area = document.getElementById("area");
var openNav = document.getElementById("openNav");
var openNavM = document.getElementById("openNavM");

function w3_open() {
  if (x.matches) { // If media query matches
    mySidebar.style.display = "block";

    main.style.filter = "blur(5px)";
    main.style.WebkitFilter = "blur(5px)";
    area.style.display = "inline-block";
    openNavM.style.display = "none";
  }
  else{
    mySidebar.style.display = "block";
    main.style.marginLeft = "25%";
    openNav.style.display = "none";
  }
}

function w3_close() {
  if (x.matches) { // If media query matches
    main.style.filter = "none";
    main.style.filter = "unset";
    main.style.WebkitFilter = "none";
    main.style.WebkitFilter = "unset";

    area.style.display = "none";
    openNav.style.display = "none";
    openNavM.style.display = "block";
  }
  else{
    main.style.marginLeft = "0%";
    openNav.style.display = "block";
    openNavM.style.display = "none";
  }
  mySidebar.style.display = "none";
}

function mclose(){
  if (x.matches) { // If media query matches
    main.style.filter = "none";
    main.style.filter = "unset";
    main.style.WebkitFilter = "none";
    main.style.WebkitFilter = "unset";

    area.style.display = "none";
    openNav.style.display = "none";
    openNavM.style.display = "block";

    mySidebar.style.display = "none";
  }
}

function myFunction(x) {

}

var x = window.matchMedia("(max-width: 768px)");
myFunction(x); // Call listener function at run time
x.addListener(myFunction); // Attach listener function on state changes

</script>

<script>
                //three dot menu button drop down list 
                function changeLanguage(language) {
                    var element = document.getElementById("url");
                    element.value = language;
                    element.innerHTML = language;
                }

                function showDropdown() {
                    document.getElementById("myDropdown").classList.toggle("show");
                }

                // Close the dropdown if the user clicks outside of it
                window.onclick = function(event) {
                    if (!event.target.matches('.dropbtn')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
</script>

<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("btnCls");
var btns = header.getElementsByClassName(" btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}
</script>