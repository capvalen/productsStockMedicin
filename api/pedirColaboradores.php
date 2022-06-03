<?php 
include ("conectkarl.php");

$colaboradores = [];



$sql= $db->prepare("SELECT id, nombres, apellidos FROM `colaboradores` where activo = 1 order by apellidos asc");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$colaboradores[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}
array_unshift($colaboradores,array('id'=>-1, 'nombres'=> 'Administrador', 'apellidos'=>''));

echo json_encode($colaboradores);