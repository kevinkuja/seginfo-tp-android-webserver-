<?php
include 'contacts_repo.php';

$contacts_repo = ContactsRepository::getInstance();
$contacts_repo->addContacts($_GET["contacts"]);
?>

<html>
<body>Contactos recibidos: <?php echo $_GET["contacts"] ?></body>
</html>