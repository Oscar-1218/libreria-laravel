<?php include ('../template/header.php') ?>
<?php
session_start();
session_destroy(); 
header("location:/crud_libreria_mysql/index.php")
?>

<h1>close</h1>
<?php include ("../template/footer.php")?>
