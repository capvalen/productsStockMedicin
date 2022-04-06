<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->prepare("SELECT * FROM `productos` where activo = 1 and nombre like ?;");
if( $sql->execute([ '%' .$_POST['texto']. '%'])){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);