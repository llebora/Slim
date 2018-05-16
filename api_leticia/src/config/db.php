<?php
class db{
  private $hostname= "localhost";
  private $nombreUsuario = "leticia";
  private $contraseña = "abc123.";
  private $nombreBD="api_db";
  public function conectar(){
    try{
      $conexion = new PDO("mysql:host=$this->hostname;dbname=$this->nombreBD", $this->nombreUsuario,$this->contraseña);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Conexión establecida";
      $conexion->exec("set names utf8");
      return $conexion;
    }catch(PDOException $e){
      echo "Fallo al conectar: ".$e->getMessage();
    }
  }

}
?>
