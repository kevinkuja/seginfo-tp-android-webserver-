<?php
include 'locations_repo.php';

$locations_repo = LocationsRepository::getInstance();
$locations_repo->addLocation($_GET["location"]);
?>

<html>
<body>Ubicacion recibida: <?php echo $_GET["location"] ?></body>
</html>