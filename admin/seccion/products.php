<?php include ('../template/header.php') ?>
<?php include ('../config/db.php')?>
<?php
// print_r($_POST); 
// print_r($_FILES); 
//Lo de abajo se lee: si hay algo en txtid, asignale el valor de txtid: sino vacio
$txtid=(isset($_POST['txtid']))?$_POST['txtid']:'';
$txtnombre=(isset($_POST['txtnombre']))?$_POST['txtnombre']:'';
$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:'';
$accion=(isset($_POST['accion']))?$_POST['accion']:'';


// $ffecha = new DateTime();
// echo $ffecha->getTimestamp();
// print '  ';
// $fecha1 = date_create();
// echo date_timestamp_get($fecha1);
// $variable1 = "valor2"; 
// print "El valor de la variable1 es $variable1";

switch($accion){

  case 'agregar':
    $sentenciaSQL = $conexion->prepare("INSERT INTO productos (nombre,imagen) VALUES (:nombre, :imagen);");
    $sentenciaSQL->bindParam(':nombre',$txtnombre);

    $fecha = new DateTime();
  
    $nombreArchivo = ($txtimagen != '') ? $fecha->getTimestamp().'_'.$_FILES['txtimagen']['name']:'persona.png' ;
    $tmpimagen=$_FILES['txtimagen']['tmp_name']; //aqui desde $txtimagen, accedo a la propiedad ya preestabecidas por PHP llamada ['tmp_name']
    if($tmpimagen != ''){
      move_uploaded_file($tmpimagen,"../../img/".$nombreArchivo);
    }

    $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
    $sentenciaSQL->execute();    

    header('location:products.php');
    break;
  case 'modificar':
    $sentenciaSQL = $conexion->prepare("UPDATE productos SET nombre=:nombre  WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtid);
    $sentenciaSQL->bindParam(':nombre',$txtnombre);
    $sentenciaSQL->execute();

    if($txtimagen !=''){ // En caso a no modificar la imagen, no se utiliza el campo imgen, esto se lo hace para controlar.
      $fecha = new DateTime();
      $nombreArchivo = ($txtimagen != '') ? $fecha->getTimestamp().'_'.$_FILES['txtimagen']['name']:'persona.png' ;
      $tmpimagen = $_FILES['txtimagen']['tmp_name'];
      move_uploaded_file($tmpimagen,"../../img/".$nombreArchivo);
      
      $sentenciaSQL = $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtid);
      $sentenciaSQL->execute(); //(retorna 1). SI O SI EN ESTE LUGAR. 3ER LUGAR, sino No funca
      $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);//recupera un registro para almacenarlo en $libro y luego mostrarlo.

      if(isset($libro['imagen']) && ($libro['imagen'] != ['persona.png'])){
        if(file_exists("../../img/".$libro['imagen'])){
          unlink("../../img/".$libro['imagen']) ;
        }
      }
      
      $sentenciaSQL = $conexion->prepare("UPDATE productos SET imagen=:imagen  WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtid);
      $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
      $sentenciaSQL->execute();

    }
    header('location:products.php');
    break;
    
  case 'cancelar':
    header('location:products.php');
    echo 'diste en cancel';
    break;
  case 'seleccionar':
    $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtid);
    $sentenciaSQL->execute();
    $producId = $sentenciaSQL->fetch(PDO::FETCH_LAZY);//recupera un registro para almacenarlo en $productoId y luego mostrarlo.
    $txtnombre = $producId['nombre'];
    $txtimagen = $producId['imagen'];

    break;
  case 'borrar':
    
    $sentenciaSQL = $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtid);
    $sentenciaSQL->execute(); //(retorna 1). SI O SI EN ESTE LUGAR. 3ER LUGAR, sino No funca
    $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);//recupera un registro para almacenarlo en $libro y luego mostrarlo.
    
    if(isset($libro['imagen']) && ($libro['imagen'] != ['persona.png'])){
      if(file_exists("../../img/".$libro['imagen'])){
        unlink("../../img/".$libro['imagen']) ;
      }
    }
    
    $sentenciaSQL = $conexion->prepare("DELETE FROM productos WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtid);
    $sentenciaSQL->execute();

    header('location:products.php');
    break;
}


$sentenciaSQL = $conexion->prepare("SELECT * FROM  productos;");
$sentenciaSQL->execute();
$listaProduc = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);//recupera todos los registros para almacenarlos en $listaproductos y luego mostrarlos
?>

<div class="container" style="display: flex;">
  <div class="col-md-5">
  <div class="card">
    <h4 class="card-header">form de agregar libros(datos)</h4>
      <form class="col-md-12" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <!-- <label for="txtid" class="form-label" >Id</label>   -->
          <input type="hidden" class="form-control" id="txtid" name="txtid" value="<?php echo $txtid ?>">
        </div>
        <div class="mb-3">
          <label for="txtnombre" class="form-label" >Nombre:</label>
          <input required type="text" class="form-control" id="txtnombre" name="txtnombre" value="<?php echo $txtnombre?>">
        </div>
        <div class="mb-3">
          <label for="txttexto" class="form-label">Imagen:</label>
          <?php echo $txtimagen?>

          <?php if($txtimagen !=''){ ?>
            <img src="../../img/<?php echo $txtimagen ?>" width="50" alt="">
          <?php }?>

          <input  type="file" class="form-control" id="txttexto" name="txtimagen" >
        </div>
          
        <div class="btn-group" style="display: flex; justify-content:center; margin:10px;" role="group" aria-label="Basic example">
          <button <?php echo ($accion == 'seleccionar'?"disabled":'')  ?> type="submit" value="agregar" name="accion" class="btn btn-success">Agregar</button>
          <button <?php echo ($accion != 'seleccionar'?"disabled":'')  ?> type="submit" value="modificar" name="accion" class="btn btn-warning">Modificar</button>
          <button  type="submit" value="cancelar" name="accion" class="btn btn-primary">Cancelar</button>
        </div>
      </form>

  </div>
 </div>

<div class="col-md-7">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Imagen</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($listaProduc as $libro){?>
      <tr>
        <th scope="row"><?php echo $libro['id'] ?></th>
        <td><?php echo $libro['nombre'] ?></td>
        <td>
          <img src="../../img/<?php echo $libro['imagen'] ?>" width="50" alt="">
        </td>
        <td>
          <form method="post">
            <input type="hidden" name="txtid" value="<?php echo $libro['id']?>" >
            <button type="submit" name="accion" value="seleccionar" class="btn btn-success"><i class="bi bi-pencil"></i></button>
            <button type="submit" name="accion" value="borrar" class="btn btn-danger"><i class="bi bi-trash3"></i></i></button>
          </form>
        </td>
      </tr>
      <?php }?>
      
    </tbody>
</table>
</div>
    
</div>
<?php include ("../template/footer.php")?>



