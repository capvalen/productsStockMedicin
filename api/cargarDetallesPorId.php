<?php 
include ("conectkarl.php");

$filas = [];
$datos =[];

$sqlNombre=$db->prepare("SELECT pro.*, p.nombre as presentacion FROM `productos` pro inner join presentaciones p on p.id = pro.idPresentacion  where pro.id = ?;");
if($sqlNombre->execute([$_POST['idProducto']])):
	$rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC);
	//while(){
		$datos = $rowNombre;
	//}
endif;


$sql= $db->prepare("SELECT d.*, m.descripcion, m.tipo FROM `detalles` d
inner join movimientos m on m.id = d.idMovimiento
where d.activo = 1 and idProducto = ?;");
if( $sql->execute([ $_POST['idProducto'] ])){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode(array($datos, $filas));