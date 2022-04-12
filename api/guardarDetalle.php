<?php 
include ("conectkarl.php");

($_POST['vencimiento'] != '') ? : $_POST['vencimiento']=null;

$sql =$db->prepare("INSERT INTO `detalles`
(`idProducto`, `idProveedor`, `idTopico`, `idMovimiento`, `cantidad`, `fecha`, `idUsuario`, `costo`, `lote`, `vencimiento`, `documento`, `observaciones`) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? );");
$resp = $sql->execute([ $_POST['id'], $_POST['origen'], $_POST['destino'], $_POST['movimiento'], $_POST['cantidad'], $_POST['ingreso'], $_POST['usuario'], $_POST['precio'], $_POST['lote'], $_POST['vencimiento'], $_POST['documento'], $_POST['observacion'] ]);

if($resp){
	//echo 'ok';
	echo $db->lastInsertId();
	if($_POST['precio']>0){
		$sqlJunto = $db->prepare("UPDATE `productos` SET `precio`= ? / ? WHERE `id`= ?;");
		$sqlJunto->execute([ $_POST['precio'], $_POST['cantidad'], $_POST['id']]);
	}
	
	$sqlSuma = $db->prepare("UPDATE `productos` SET `stock`= `stock` + ? WHERE `id`= ?; ");
	$sqlSuma->execute([ $_POST['cantidad'], $_POST['id']]);

}else{
	echo 'error';
}

?>