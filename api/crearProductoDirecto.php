<?php 
include ("conectkarl.php");

$sqlCheck=$db->prepare("SELECT * from productos where nombre like '{$_POST['nombre']}'  and activo = 1; ");
$respCheck = $sqlCheck -> execute();
//echo 'son '. $sqlCheck->rowCount();
if( $sqlCheck->rowCount() >= 1){
	$row = $sqlCheck->fetch(PDO::FETCH_ASSOC);
	echo $row['id'];
}else{

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
}


?>