<?php 
include ("conectkarl.php");

$topicos =[];

$sqlNombre=$db->prepare("SELECT *, retornarValor(?) as valorizado FROM `topicos` where id = ? and  activo = 1 ; ");
if($sqlNombre->execute([ $_POST['id'], $_POST['id'] ])):
	$rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC);
	$topicos = $rowNombre;
	/* while(){
	
	} */
else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlNombre->errorinfo();
endif;


echo json_encode($topicos);