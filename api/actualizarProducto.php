<?php 
include ("conectkarl.php");

$sql =$db->prepare("UPDATE `productos` SET `nombre`= ? WHERE id= ?;");
$resp = $sql->execute([ $_POST['nuevoNombre'], $_POST['id']]);

if($resp){
	echo 'ok';
}else{
	echo 'error';
}

?>