<?php 
include ("conectkarl.php");

$cabecera = [];
$detalles =[];


$sql= $db->prepare("SELECT r.*, p.solicitante, date_format(p.registro, '%d/%m/%Y %h:%m %p ') as registro, p.atendido, tp.nombre, convert(date_format(p.registro, '%m'), int) as mes, LPAD( r.id, 4, 0) as codificado FROM `requerimientos` r
inner join pedidos p on r.idPedido = p.id
inner join topicos tp on tp.id = p.idTopico
where r.id= ? ;");
if( $sql->execute( [$_POST['idRequerimiento']] )){
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$cabecera = $row;
	/* while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$cabecera[] = $row;
	} */
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

$sqlNombre=$db->prepare("SELECT rd.*, p.nombre FROM `requerimientos_detalle` rd inner join productos p on p.id = rd.idProducto where idRequerimiento = ? ;");
if($sqlNombre->execute( [$_POST['idRequerimiento']] )):
	while($rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC)){
		$detalles[] = $rowNombre;
	}
else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlNombre->errorinfo();
endif;


echo json_encode(array( $cabecera, $detalles ));