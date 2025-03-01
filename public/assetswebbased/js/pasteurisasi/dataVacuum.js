

                $(document).ready(function() {
                    function updateSensorValues() {
                        $.ajax({
                            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
                            dataType: 'json',
                            success: function(response) {
                                $('#BT1').text(response.LevelBT1);
                                $('#pump1').text(response.SpeedPumpBT1);
                                $('#VD').text(response.LevelVD);
                                $('#pumpVD').text(response.SpeedPumpVD);
                                $('#BT1AM').text(response.BT1AM);
                                $('#VDAM').text(response.VDAM);
                                $('#VDHH').text(response.PressVDHH);
                                $('#VDLL').text(response.PressVDLL);
                                $('#press-pasteur').text(response.PressToPasteur);

                              
                            },
                            error: function(_xhr, status, error) {
                                console.error('AJAX Error: ' + status + error);
                            }
                        });
                    }
                
                    // Memanggil fungsi update setiap 5 detik
                    setInterval(updateSensorValues, 5000);
                });
                