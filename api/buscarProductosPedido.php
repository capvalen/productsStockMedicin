<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->prepare("SELECT id, nombre FROM `productos` where (activo = 1 and nombre like ?) or (id=1) order by case when id=1 then -1 else nombre end asc;");
if( $sql->execute([ '%' .$_POST['texto']. '%'])){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);