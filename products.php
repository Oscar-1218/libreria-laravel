<?php include ('template/header.php')?>

<style>
.products{
    margin-top: 30px;
}
</style>

<div class="container">
    <div class="row">
  
<?php 
include ("../crud_libreria_mysql/admin/config/db.php"); 
$sentenciaSQL = $conexion->prepare("SELECT * FROM  productos;");
$sentenciaSQL->execute();
$listaProduc = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);//recupera todos los registros para almacenarlos en $lis
 
?>
<?php foreach ($listaProduc as $valor => $value) {
    ?>
  <div class="col-3">
  <div class="card">
        <img src="./img/<?php echo $value['imagen']?>" height="195" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?php echo $value['nombre']?></h5>
            <a href="#" class="btn btn-primary">Ver</a>
        </div>
    </div>
    </div>

  <?php } ?>
    
</div>
</div>

    
<?php include ('template/footer.php')?> 