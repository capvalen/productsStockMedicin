<?php 
include ("conectkarl.php");

$sql =$db->prepare("INSERT INTO `productos`(`nombre`, `idPresentacion`) VALUES (?, ?);");
$resp = $sql->execute([ $_POST['nombre'], $_POST['presentacion'] ]);

if($resp){
	//echo 'ok';
	echo $db->lastInsertId();
}else{
	echo 'error';
}

?>