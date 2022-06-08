<?php 
include ("conectkarl.php");

$sql =$db->prepare("UPDATE `pedidos` SET `activo`=0, atendido=2 WHERE id= ?;");
$resp = $sql->execute([ $_POST['id']]);

if($resp){
	echo 'ok';
}else{
	echo 'error';
}

?>