document.getElementById('Sort').onchange = function () { sortOrders() };

function sortOrders(){

  document.getElementById("all").classList.add("hidden");
  document.getElementById("complete").classList.add("hidden");
  document.getElementById("progress").classList.add("hidden");
  document.getElementById("cancell").classList.add("hidden");

  var typeValue = document.getElementById('Sort').value
  //console.log("Value is "+typeValue);
  if (typeValue == "Complete"){
    var complete = document.getElementById('complete');
    complete.classList.remove("hidden");
    complete.classList.add("show");
  }
  else if (typeValue == "In-Progress"){
    var progress = document.getElementById('progress');
    progress.classList.remove("hidden");
    progress.classList.add("show");
  }
  else if (typeValue == "Cancel") {
    var cancel = document.getElementById('cancell');
    cancel.classList.remove("hidden");
    cancel.classList.add("show");
  }
  else if (typeValue == "All") {
    var all = document.getElementById('all');
    all.classList.remove("hidden");
    all.classList.add("show");
  }
}
