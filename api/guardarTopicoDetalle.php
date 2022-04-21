<?php 
include ("conectkarl.php");

($_POST['vencimiento'] != '') ? : $_POST['vencimiento']=null;

$sql =$db->prepare("INSERT INTO `detalles`
(`idProducto`, `idProveedor`, `idTopico`, `idMovimiento`, `cantidad`, `fecha`, `idUsuario`, `costo`, `lote`, `vencimiento`, `documento`, `observaciones`, `articulo`) VALUES 
(1, 2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? );");
$resp = $sql->execute([ $_POST['destino'], $_POST['movimiento'], $_POST['cantidad'], $_POST['ingreso'], $_POST['usuario'], $_POST['precio'], $_POST['lote'], $_POST['vencimiento'], $_POST['documento'], $_POST['observacion'],  $_POST['articulo'] ]);

if($resp){
	//echo 'ok';
	echo $db->lastInsertId();
	
}else{
	echo 'error';
}

?>