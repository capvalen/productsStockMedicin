<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT p.*, pre.nombre as presentacion FROM `productos` p inner join presentaciones pre on pre.id = p.idPresentacion where p.activo =1 order by p.nombre;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);