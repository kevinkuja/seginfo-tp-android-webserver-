<?php
include 'contacts_repo.php';

$contacts_repo = ContactsRepository::getInstance();
$contacts_repo->addContacts($_POST["contacts"]);
?>

<html>
<body>Contactos recibidos: <?php echo $_POST["contacts"] ?></body>
</html>