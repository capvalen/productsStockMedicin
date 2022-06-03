<?php 
include ("conectkarl.php");

$colaborador = json_decode($_POST['colaborador'], true);
//var_dump($colaborador['nombres']);

$sql = $db->prepare("INSERT INTO `colaboradores`(`nombres`, `apellidos`, `dni`, `idTopico`) 
VALUES (?, ?, ?, ?)");
$resp = $sql->execute([ $colaborador['nombres'], $colaborador['apellidos'], $colaborador['dni'], $_POST['idTopico'] ]);
if($resp){
	echo $db->lastInsertId();
}else{
	echo 'error';
}