<?php


$host = 'localhost';
$bd = 'libreria';
$user = 'root';
$pass = '';
try {
  $conexion = new PDO("mysql:host=$host,port:3307;dbname=$bd",$user,$pass); //PDO es la coneccion en si a la b.datos
  if($conexion){
  }
} catch (PDOException $error) {
  echo($error)->getMessage();
}





?>