$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#preheating').text(response.SuhuPreheating);
                $('#heating').text(response.SuhuHeating);
                $('#holding').text(response.suhuHolding);
                $('#precooling').text(response.SuhuPrecooling);
                $('#cooling').text(response.SuhuCooling);
                $('#flowrate').text(response.Flowrate);
                $('#BT1').text(response.LevelBT1);
                $('#VD').text(response.LevelVD);
                $('#BT2').text(response.LevelBT2);
                $('#pumpBT1').text(response.SpeedPumpBT1);
                $('#pumpVD').text(response.SpeedPumpVD);
                $('#pumpBT2').text(response.SpeedPumpBT2);
                $('#pressureBT2').text(response.PressureBT2);
                $('#pumpmixing').text(response.SpeedPompaMixing);
                $('#MV1').text(response.MV1);
                $('#MV2').text(response.MV2);
               
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
