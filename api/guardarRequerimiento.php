<?php 
include ("conectkarl.php");
$pedidos = json_decode($_POST['contenido'], true);

$sql =$db->prepare("INSERT INTO `requerimientos`(`idPedido`) VALUES (?);");
$resp = $sql->execute([ $_POST['idPedido'] ]);

if($resp){
	//echo 'ok';
	$idRequerimiento = $db->lastInsertId();
	
	$sqlPedidos='';

	foreach( $pedidos  as $pedido){
		$sqlPedidos .= "INSERT INTO `requerimientos_detalle`( `idRequerimiento`, `idProducto`, `cantidad`) VALUES ({$idRequerimiento}, {$pedido['id']}, {$pedido['cantidad']} ); ";
	}
	$sqlDetalles = $db->prepare($sqlPedidos);
	$respDetalles = $sqlDetalles->execute();
	
	$sqlPedidos ='';
	$sqlDetalles->closeCursor();

	foreach( $pedidos  as $pedido){
		$sqlPedidos .= "INSERT INTO `requerimientos_detalle`( `idRequerimiento`, `idProducto`, `cantidad`) VALUES ({$idRequerimiento}, {$pedido['id']}, {$pedido['cantidad']} );
		INSERT INTO `detalles`(`idProducto`, `idProveedor`, `idTopico`, `idMovimiento`,
		 `cantidad`, `fecha`, `registro`, `idUsuario`,
		  `costo`, `lote`, `documento`, `observaciones`) VALUES (
			{$pedido['id']}, 1, {$_POST['idTopico']}, 2, 
			{$pedido['cantidad']}, now(), now(), 1, 
			0, '', '', 'Por requerimiento #{$idRequerimiento}');
			UPDATE `productos` SET `stock` = `stock` - {$pedido['cantidad']} WHERE `productos`.`id` = {$pedido['id']};
		";
	}
	$sqlDetalles = $db->prepare($sqlPedidos);
	$respDetalles = $sqlDetalles->execute();
	//echo $sqlDetalles->debugDumpParams();
	$sqlDetalles->closeCursor();

	$sql3=$db->prepare("UPDATE `pedidos` SET `atendido`=1 WHERE id= ?; ");
	$resp3 = $sql3->execute([ $_POST['idPedido'] ]);
	//die();

	echo $idRequerimiento;
}else{
	echo 'error';
}

?>