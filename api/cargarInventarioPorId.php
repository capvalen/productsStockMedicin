<?php 
include ("conectkarl.php");

$filas = [];
$datos =[];

$sqlNombre=$db->prepare("SELECT p.nombre, d.*, m.descripcion 
FROM `detalles` d
inner join productos p on p.id = d.idProducto
inner join movimientos m on m.id = d.idMovimiento
where idTopico= ? and d.activo=1 and idMovimiento in (5,6);");
if($sqlNombre->execute([$_POST['id']])):
	
	while($rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $rowNombre;
	}
endif;


echo json_encode( $filas );