$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#pcv1').text(response.PCV1);
                $('#storage1').text(response.Storage);
                $('#flowrate').text(response.Flowrate);
                $('#cool').text(response.SuhuCooling);
                $('#precool').text(response.SuhuPrecooling);
                $('#pressurebt2').text(response.PressureBT2);
                $('#BT2').text(response.LevelBT2);
                $('#mode').text(response.Mode);
                $('#varian').text(response.Varian);
                $('#batch').text(response.Batch);
                $('#storage').text(response.Storage);
                $('#preheating').text(response.SuhuPreheating);
                $('#pump2').text(response.SpeedPumpBT2);
                $('#holding').text(response.SuhuHolding);
                $('#suheat').text(response.SuhuHeating);
                $('#TD1').text(response.TimeDivert);
                $('#TD2').text(response.TimeDivert);
                
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
