// Get current date and time
var now = new Date();
var tanggal = now.toLocaleDateString('id-ID', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
});


// Insert date and time into HTML
document.getElementById("datetime").innerHTML = tanggal;
