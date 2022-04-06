<?php 
include ("conectkarl.php");

$topicos =[];
$proveedores = [];



$sql= $db->prepare("SELECT * FROM `proveedores` where activo = 1 order by nombre asc;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$proveedores[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

$sqlNombre=$db->prepare("SELECT * FROM `topicos` where activo = 1 order by nombre asc;");
if($sqlNombre->execute()):
	while($rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC)){
		$topicos[] = $rowNombre;
	}
else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlNombre->errorinfo();
endif;


echo json_encode(array( $proveedores, $topicos ));