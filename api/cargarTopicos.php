<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT * FROM `topicos` WHERE `activo` = 1 order by nombre;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);