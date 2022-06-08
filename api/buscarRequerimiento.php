<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->prepare("SELECT pe.*, t.nombre FROM `pedidos` pe
inner join topicos t on pe.idTopico = t.id
inner join requerimientos r on r.idPedido = pe.id
where pe.activo = 1 and r.id = ?;



");
if( $sql->execute([ $_POST['textoId'] ]) ){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);