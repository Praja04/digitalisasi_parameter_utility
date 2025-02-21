$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateLHTEMPValue() {
        $.ajax({
            url: BASE_URL + "/bbsteam", // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#bbsteam').text(response.bbsteam);
                $('#batubara').text(response.batubara);
                $('#steam').text(response.steam);
            }
        });
    }

    // Memanggil fungsi bbsteam setiap 1 detik
    setInterval(updateLHTEMPValue, 5000); // Interval setiap 1 detik (1000 ms)
});


//batubara = (speedstokerL + speedstokerR) * (tinggiGoulutineL +  tinggiGoulutineR) * FK

//steam = (waterpump1 + waterpump2) / 50 * 20 * FK

//bb/steam = batubara/steam