<?php 
include ("conectkarl.php");
$pedidos = json_decode($_POST['contenido'], true);

$sql =$db->prepare("INSERT INTO `requerimientos`(`idPedido`) VALUES (?);");
$resp = $sql->execute([ $_POST['idPedido'] ]);

if($resp){
	//echo 'ok';
	$idRequerimiento = $db->lastInsertId();
	$sql->closeCursor();

	$sqlPedidos='';

	foreach( $pedidos  as $pedido){
		$sqlPedidos .= "INSERT INTO `requerimientos_detalle`( `idRequerimiento`, `idProducto`, `cantidad`) VALUES ({$idRequerimiento}, {$pedido['id']}, {$pedido['cantidad']} );";
	}
	$sqlDetalles = $db->prepare($sqlPedidos);
	$respDetalles = $sqlDetalles->execute();
	$sqlDetalles->closeCursor();

	$sql3=$db->prepare("UPDATE `pedidos` SET `atendido`=1 WHERE id= ?; ");
	$resp3 = $sql3->execute([ $_POST['idPedido'] ]);
	//die();

	echo $idRequerimiento;
}else{
	echo 'error';
}

?>