$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#pressuremixing').text(response.PressureMixing);
                $('#pumpmixing').text(response.SpeedPompaMixing);
                $('#mode').text(response.MixingAM);
                
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
