<?php
include 'contacts_repo.php';
include 'locations_repo.php';

$contacts_repo = ContactsRepository::getInstance();
$locations_repo = LocationsRepository::getInstance();
?>
<html>

<body>

<div id="contacts">
	<h1>Contactos recibidos</h1>
	<?php echo $contacts_repo->getContacts(); ?>
</div>
</div id="locations">
	<h1>Ubicaciones recibidas</h1>
	<?php echo $locations_repo->getLocations(); ?>
</div>
</body>
</html>