<?php 
include ("conectkarl.php");

$sql =$db->prepare("UPDATE `detalles` SET `activo` = 0 WHERE id = ?;");
$resp = $sql->execute([ $_POST['id']]);

if($resp){
	echo 'ok';
}else{
	echo 'error';
}

?>