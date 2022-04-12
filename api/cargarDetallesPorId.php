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


$sql= $db->prepare("SELECT d.*, m.descripcion, m.tipo, pro.nombre as nomProveedor, t.nombre as nomTopico FROM `detalles` d
inner join movimientos m on m.id = d.idMovimiento
inner join proveedores pro on pro.id = d.idProveedor
inner join topicos t on t.id = d.idTopico
where d.activo = 1 and idProducto = ? order by fecha desc, registro desc;");
if( $sql->execute([ $_POST['idProducto'] ])){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode(array($datos, $filas));