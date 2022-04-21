<?php 
include ("conectkarl.php");

$sql =$db->prepare("INSERT INTO `detalles`
(`idProducto`, `idProveedor`, `idTopico`, `idMovimiento`, `cantidad`, `fecha`, `idUsuario`, `costo`, `documento`, `observaciones`) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ? );");
$resp = $sql->execute([ $_POST['id'], $_POST['origen'], $_POST['destino'], $_POST['movimiento'], $_POST['cantidad'], $_POST['ingreso'], $_POST['usuario'], $_POST['precio'], $_POST['documento'], $_POST['observacion'] ]);

if($resp){
	//echo 'ok';
	echo $db->lastInsertId();
	
	$sqlSuma = $db->prepare("UPDATE `productos` SET `stock`= `stock` - ? WHERE `id`= ?; ");
	$sqlSuma->execute([ $_POST['cantidad'], $_POST['id']]);

}else{
	echo 'error';
}

?>