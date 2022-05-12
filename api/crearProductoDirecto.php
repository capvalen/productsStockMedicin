<?php 
include ("conectkarl.php");

$sql =$db->prepare("INSERT INTO `productos`(`nombre`, `idPresentacion`) VALUES (?, ?);");
$resp = $sql->execute([ $_POST['nombre'], $_POST['presentacion'] ]);

if($resp){
	//echo 'ok';
	$idProducto =  $db->lastInsertId();
	$sql2 = $db->prepare("UPDATE `pedidos_detalle` SET `idProducto`= ? WHERE `id`= ?; ");
	$resp2 = $sql2->execute([ $idProducto, $_POST['idRegistro'] ]);
	
	echo $idProducto;
}else{
	echo 'error';
}

?>