<?php 
include ("conectkarl.php");

$filas = [];
$requerimentos =[];

$sqlNombre=$db->prepare("SELECT p.nombre, d.*, m.descripcion, pro.nombre as proveedor, t.nombre as destino, m.tipo
FROM `detalles` d
inner join productos p on p.id = d.idProducto
inner join proveedores pro on pro.id = d.idProveedor
inner join topicos t on t.id = d.idTopico
inner join movimientos m on m.id = d.idMovimiento
where idTopico= ? and d.activo=1 and idMovimiento in (2,4,7)
order by d.registro desc;");
if($sqlNombre->execute([$_POST['id']])):
	
	while($rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $rowNombre;
	}
endif;


echo json_encode( $filas );