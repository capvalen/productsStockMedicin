<?php 
include ("conectkarl.php");

$sql =$db->prepare("INSERT INTO `detalles`(`idProducto`, `idProveedor`, `idTopico`, `idMovimiento`, `cantidad`,
 `fecha`, `registro`, `idUsuario`, `costo`, `lote`, `observaciones`, `documento`) 
VALUES (?, 1, ?, 4, ?,
now(), now(), 1, 0, '', ?, '')");
$resp = $sql->execute([ $_POST['idProducto'], $_POST['idTopico'], $_POST['cantidad'], $_POST['observaciones'] ]);

$sqlDevolver = $db->prepare("UPDATE `detalles` SET `cantidad` = `cantidad` - ? WHERE `detalles`.`id` = ? ;");
$respDevolver = $sqlDevolver->execute([ $_POST['cantidad'], $_POST['idRegistro'] ]);

if($resp){
	echo 'ok';
}else{
	echo 'error';
}

?>