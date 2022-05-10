<?php 
include ("conectkarl.php");

$topicos =[];

$sqlNombre=$db->prepare("SELECT pe.*, t.nombre FROM `pedidos` pe
inner join topicos t on pe.idTopico = t.id
where pe.activo = 1 and atendido = 0; ");
if($sqlNombre->execute()):
	while($rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC)){
		$topicos[] = $rowNombre;
	}
else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlNombre->errorinfo();
endif;


echo json_encode($topicos);