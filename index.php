<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

require('config/config.php');
require('config/db.php');

?>
<?php include('inc/header.php'); ?>



<?php include('inc/footer.php'); ?>

