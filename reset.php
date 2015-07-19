<?php
include 'contacts_repo.php';
include 'locations_repo.php';

ContactsRepository::getInstance()->reset();
LocationsRepository::getInstance()->reset();

header("Location: ./index.php");
?>