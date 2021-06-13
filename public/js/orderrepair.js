function OnwTechnician() {
    var x = document.getElementById("OnwTechnician");
    var y = document.getElementById("ExternalTechnician");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    if (y.style.display === "block") {
        y.style.display = "none";
    }
}

function ExternalTechnician() {
    var x = document.getElementById("ExternalTechnician");
    var y = document.getElementById("OnwTechnician");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    if (y.style.display === "block") {
        y.style.display = "none";
    }
}