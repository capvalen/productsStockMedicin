<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT * FROM `proveedores` p where nombre<> 'Ninguno' and nombre<>  'Almacén principal' order by p.nombre ;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);