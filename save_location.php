<?php
include 'locations_repo.php';

$locations_repo = LocationsRepository::getInstance();
$locations_repo->addLocation($_POST["location"]);
?>

<html>
<body>Ubicacion recibida: <?php echo $_POST["location"] ?></body>
</html>