$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#D1').text(response.D1);
                $('#D2').text(response.D2);
                $('#D3').text(response.D3);
                $('#D4').text(response.D4);
                $('#D5').text(response.D5);
             
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
