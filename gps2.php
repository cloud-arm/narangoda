<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>SPACE-O :: Get Visitor Location using HTML5</title>
    <style type="text/css">

    </style>

</head>

<body>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Your Location</h3>
        </div>

        <?php date_default_timezone_set("Asia/Colombo"); ?>
        <div class="box-body" id="location">
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(showLocation);

            } else {

                $('#location').html('Geolocation is not supported by this browser.');

            }

        });

        function showLocation(position) {

            var latitude = position.coords.latitude;

            var longitude = position.coords.longitude;



            $.ajax({

                type: 'POST',

                url: 'customer_gps_set.php',

                data: 'l=' + latitude + '&q=' + longitude,

                success: function(msg) {

                    if (msg) {

                        $("#location").html(msg);

                    } else {

                        $("#location").html('Not Available');

                    }

                }

            });

        }
    </script>
</body>

</html>