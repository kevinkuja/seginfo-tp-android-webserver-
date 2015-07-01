<?php
include 'locations_repo.php';

$locations_repo = LocationsRepository::getInstance();
$locations_repo->addLocation($_POST["lat"], $_POST['lng']);
?>

<html>
<body>Ubicacion recibida: <?php echo $_POST["lat"]+","+$_POST['lng'] ?></body>
</html>