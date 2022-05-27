<?php 
include ("conectkarl.php");

$sql =$db->prepare("INSERT INTO `detalles`(`idProducto`, `idProveedor`, `idTopico`, `idMovimiento`, `cantidad`,
 `fecha`, `registro`, `idUsuario`, `costo`, `lote`, `observaciones`, `documento`) 
VALUES (?, 1, ?, 7, ?,
now(), now(), 1, 0, '', ?, '')");
$resp = $sql->execute([ $_POST['idProducto'], $_POST['idTopico'], $_POST['cantidad'], $_POST['observaciones'] ]);

if($resp){
	echo 'ok';
}else{
	echo 'error';
}

?>