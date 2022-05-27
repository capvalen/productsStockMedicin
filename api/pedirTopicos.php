<?php 
include ("conectkarl.php");

$topicos =[];
$proveedores = [];
$colaboradores = [];



$sql= $db->prepare("SELECT * FROM `proveedores` where activo = 1 order by nombre asc;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$proveedores[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

$sql->closeCursor();

$sqlNombre=$db->prepare("SELECT * FROM `topicos` where activo = 1 order by nombre asc;");
if($sqlNombre->execute()):
	while($rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC)){
		$topicos[] = $rowNombre;
	}
else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlNombre->errorinfo();
endif;

$sql->closeCursor();

$sqlColaborador=$db->prepare("SELECT * FROM `colaboradores` where activo = 1 order by apellidos asc;");
if($sqlColaborador->execute()):
	while($rowColaborador = $sqlColaborador->fetch(PDO::FETCH_ASSOC)){
		$colaboradores[] = $rowColaborador;
	}
else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlColaborador->errorinfo();
endif;


echo json_encode(array( $proveedores, $topicos, $colaboradores ));