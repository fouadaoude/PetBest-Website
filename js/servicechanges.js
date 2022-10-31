document.getElementById("category").onchange = function () { dropDown() };

document.getElementById("appointmentdate").onfocus = function () { mindate() };


function mindate() {
  date = new Date();
  year = +date.getFullYear().toString();
  month = "0" + (date.getMonth() + 1).toString();
  day = (date.getDate() + 5).toString();
  fullDate = year + "-" + month + "-" + day;

  maxyear = "'" + (date.getFullYear() + 1).toString();
  maxfullDate = maxyear + "-" + month + "-" + day;

  document.getElementById("appointmentdate").min = fullDate
  document.getElementById("appointmentdate").max = maxfullDate
}

function dropDown() {

  document.getElementById("type").classList.remove("active");
  document.getElementById("type").nextElementSibling.classList.remove("active");
  document.getElementById("type1").classList.remove("active");
  document.getElementById("type1").nextElementSibling.classList.remove("active");
  document.getElementById("type2").classList.remove("active");
  document.getElementById("type2").nextElementSibling.classList.remove("active");
  document.getElementById("type3").classList.remove("active");
  document.getElementById("type3").nextElementSibling.classList.remove("active");
  document.getElementById("type4").classList.remove("active");
  document.getElementById("type4").nextElementSibling.classList.remove("active");
  document.getElementById("type5").classList.remove("active");
  document.getElementById("type5").nextElementSibling.classList.remove("active");

  var typeValue = document.getElementById("category").value;
   //console.log(typeValue);

  if (typeValue === "1") {
    var classA = document.getElementsByClassName("dogclean");
    classA[0].classList.add("active");
    classA[1].classList.add("active");
  }
  else if (typeValue === "2") {
    var classA = document.getElementsByClassName("catclean");
    classA[0].classList.add("active");
    classA[1].classList.add("active");
  }
  else if (typeValue === "3") {
    var classA = document.getElementsByClassName("smallclean");
    classA[0].classList.add("active");
    classA[1].classList.add("active");
  }
  else if (typeValue === "4") {
    var classA = document.getElementsByClassName("transport");
    classA[0].classList.add("active");
    classA[1].classList.add("active");
  }
  else if (typeValue === "5") {
    var classA = document.getElementsByClassName("dogcare");
    classA[0].classList.add("active");
    classA[1].classList.add("active");
  }
  else if (typeValue === "6") {
    var classA = document.getElementsByClassName("catcare");
    classA[0].classList.add("active");
    classA[1].classList.add("active");
  }
}
