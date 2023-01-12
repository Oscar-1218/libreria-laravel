<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location:../principal/index.php');
}else{
    if($_SESSION['user'] == 'ok'){
        $nombreUsuario= $_SESSION['nombreUsuario'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Libreria</title>

    <!-- CSS only -->    
    <link rel="stylesheet" href="../../css/bootstrapAdmin.min.css">

</head>
<body>
    
    <?php  $url="http://".$_SERVER['HTTP_HOST']."/crud_libreria_mysql" ?>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin del sitio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url?>/admin/seccion/products.php">Libros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url ?>">Ver sitio web</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $url?>/admin/seccion/close.php">Cerrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h2>Modo administrador</h2>



    <div class="container">
       <div class="row">
            <div class="col-md-12">