$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#C1').text(response.C1);
                $('#C2').text(response.C2);
                $('#C3').text(response.C3);
                $('#C4').text(response.C4);
                $('#C5').text(response.C5);
             
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
