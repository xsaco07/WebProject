let mounts = [0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00];
let favCountries = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Represents the stars state (0 -> off, 1 -> on)


function convert() {

  // console.log("converting...");
  var mountInput = document.getElementById("mountInput").value;

  // If user did not introduce anything
  if (mountInput == null) {
    mountInput = 0;
  }

  for (var i = 0; i < mounts.length; i++) {
    mounts[i] = (Math.random()*mountInput).toPrecision(3);
  }

  setMountsList(false, true);
}

function cleanMounts() {
  // console.log("cleanning mounts...");
  for (var i = 0; i < mounts.length; i++) {
    mounts[i] = 0.00;
  }
  setMountsList(false, false);
}

function cleanStars() {
  // console.log("cleanning stars...");
  var stars = document.getElementsByClassName("fav");
  for (var i = 0; i < favCountries.length; i++) {
    stars[i].setAttribute("src", "./Imagenes/starno.png");
    favCountries[i] = 0;
  }
}

function starPressed(starObject, starId) {
  if(favCountries[starId] == 0) {
    favCountries[starId] = 1;
    starObject.setAttribute("src", "./Imagenes/star.png");
  }
  else {
    favCountries[starId] = 0;
    starObject.setAttribute("src", "./Imagenes/starno.png");
  }
}

function setMountsList(firstTimeFlag, onlyFavs) {

  var paragraph;
  var mount;

  for (var i = 0; i < 10; i++) {

    var currentCountryFigure = document.getElementById("pais" + i);

    if (firstTimeFlag) { // Create paragraph node with mount text and append it to DOM

      // console.log("first time...");

      paragraph = document.createElement("p");
      mount = document.createTextNode(mounts[i]);
      paragraph.appendChild(mount);
      paragraph.id = "currentMount" + i;
      paragraph.style.color = "red";
      currentCountryFigure.appendChild(paragraph);

    }else { // Look for the paragraph and set the new mount

      // console.log("not first time...");

      // do I hace to set only stars-on values?
      // do I have to set all values without exception?
      if ((onlyFavs && favCountries[i] == 1) || !onlyFavs) {

        paragraph = document.getElementById("currentMount" + i);
        mount = mounts[i];
        paragraph.textContent = mount;

      }
    }
  }
}

function initializeComponents() {
  setMountsList(true, false);
}

window.onload = initializeComponents();
