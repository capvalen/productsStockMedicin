<?php 
include ("conectkarl.php");

$cabecera =[];
$filas = [];

$sqlNombre=$db->prepare("SELECT pe.*,t.nombre FROM `pedidos` pe inner join topicos t on pe.idTopico = t.id where pe.id = ?;");
if($sqlNombre->execute([$_POST['id']])):
	$rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC);
	//while(){
		$cabecera = $rowNombre;
	//}
endif;


$sql= $db->prepare("SELECT * FROM `pedidos_detalle`
where idPedido = ? ;");
if( $sql->execute([ $_POST['id'] ])){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode(array($cabecera, $filas));