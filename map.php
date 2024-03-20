<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-yellow sidebar-mini">
  <?php
  include_once("auth.php");
  $r = $_SESSION['SESS_LAST_NAME'];
  $_SESSION['SESS_FORM'] = 'map';
  date_default_timezone_set("Asia/Colombo");

  if ($r == 'Cashier') {

    include_once("sidebar2.php");
  }
  if ($r == 'admin') {

    include_once("sidebar.php");
  }
  ?>
  <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">

    <div id="map" style="height: 800px;"></div>

    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php
  include("dounbr.php");
  ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 2.2.3 -->
  <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- SlimScroll 1.3.0 -->
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="../../plugins/iCheck/icheck.min.js"></script>
  <!-- FastClick -->
  <script src="../../plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Dark Theme Btn-->
  <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/DarkTheme.js"></script>
  <!-- Page script -->
  <script>

// Initialize Leaflet map with Sri Lanka coordinates and an appropriate zoom level
var map = L.map('map').setView([6.228372, 80.412602], 11); // Centered on Sri Lanka, zoom level 7

// Define bounds for cropping the map (example bounds)
var southWest = L.latLng(5.723733, 79.538727); // Bottom-left corner of Sri Lanka
var northEast = L.latLng(9.8354, 81.8862);   // Top-right corner of Sri Lanka
var bounds = L.latLngBounds(southWest, northEast);

// Add OpenStreetMap tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    minZoom: 7, // Minimum zoom level appropriate for Sri Lanka
    maxZoom: 18 // Maximum zoom level
}).addTo(map);

// Set bounds to restrict the visible area of the map to Sri Lanka
map.setMaxBounds(bounds);
map.on('drag', function () {
    map.panInsideBounds(bounds, { animate: false });
});
map.on('dragend', function () {
    map.panInsideBounds(bounds, { animate: false });
});

// Function to fetch GPS data from PHP
function fetchGPSData() {
    // Make an AJAX request to your PHP file
    // Replace 'your-php-script.php' with the actual path to your PHP script
    // Modify this according to your data retrieval mechanism (e.g., AJAX, WebSocket, etc.)
    var customIcon = L.icon({
        iconUrl: 'user_pic/lorry.png', // URL to the custom marker icon image
        iconSize: [65, 40], // Size of the icon
        iconAnchor: [20, 40], // Point of the icon which will correspond to marker's location
        popupAnchor: [0, -40], // Point from which the popup should open relative to the iconAnchor
        className: 'custom-marker' // Class name for styling the marker
    });
    fetch('map_data.php')
        .then(response => response.json())
        .then(data => {
            // Process the GPS data and add markers to the map
            // Remove existing markers from the map
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });
            data.forEach(entry => {
                var marker = L.marker([entry.lat, entry.lng], { icon: customIcon }).addTo(map);
                // You can customize the marker popup or icon here
                marker.bindPopup('<h3>'+entry.lorry_no+'<br>'+entry.rep+'</h3>');
            });
        })
        .catch(error => console.error('Error fetching GPS data:', error));
}

// Call the function to fetch and display GPS data
fetchGPSData();
setInterval(fetchGPSData, 20000); 



    $(function() {
      //Initialize Select2 Elements
      $(".select2").select2();

      //Date range picker
      $('#reservation').daterangepicker();
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'YYYY/MM/DD h:mm A'
      });
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
      );

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy/mm/dd '
      });
      $('#datepicker').datepicker({
        autoclose: true
      });

    });
  </script>
</body>

</html>