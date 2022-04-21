<?php 
include ("conectkarl.php");

$sql =$db->prepare("INSERT INTO `topicos`(`nombre`) VALUES (?);");
$resp = $sql->execute([ $_POST['nombre'] ]);

if($resp){
	//echo 'ok';
	echo $db->lastInsertId();
}else{
	echo 'error';
}

?>