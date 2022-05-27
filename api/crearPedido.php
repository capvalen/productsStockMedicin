<?php 
include ("conectkarl.php");
$pedidos = json_decode($_POST['pedidos'], true);



$sql =$db->prepare("INSERT INTO `pedidos`(`idSolicitante`, `solicitante`, `idTopico`, `comentarios`) VALUES (?, ?, ?, ?);");
$resp = $sql->execute([ $_POST['idSolicitante'], $_POST['solicitante'], $_POST['idTopico'], $_POST['comentarios'] ]);

if($resp){
	//echo 'ok';
	$idPedido = $db->lastInsertId();
	$sqlPedidos='';

	foreach( $pedidos  as $pedido){
		$sqlPedidos .= "INSERT INTO `pedidos_detalle`( `idPedido`, `idProducto`, `nombre`, `cantidad`) VALUES ({$idPedido}, {$pedido['id']}, '{$pedido['nombre']}', ".$pedido['cantidad']." );";
	}
	$sqlDetalles = $db->prepare($sqlPedidos);
	$respDetalles = $sqlDetalles->execute();
	//die();

	echo $idPedido;
}else{
	echo 'error';
}

?>