<?php 
include ("conectkarl.php");

$topicos =[];
$colaboradores =[];

$sqlNombre=$db->prepare("SELECT *, ifnull(retornarValor(?),0) as valorizado FROM `topicos` where id = ? and  activo = 1 ; ");
	if($sqlNombre->execute([ $_POST['id'], $_POST['id'] ])):
		$rowNombre = $sqlNombre->fetch(PDO::FETCH_ASSOC);
		$topicos = $rowNombre;
		/* while(){
		
		} */
		$sqlNombre->closeCursor();

		$sqlColaborador=$db->prepare("SELECT * FROM `colaboradores` where activo = 1 and idTopico= ? order by apellidos asc;");
		if($sqlColaborador->execute([ $_POST['id'] ])):
			while($rowColaborador = $sqlColaborador->fetch(PDO::FETCH_ASSOC)){
				$colaboradores[] = $rowColaborador;
			}
		else:
			//echo $sqlNombre->debugDumpParams();
			echo $sqlColaborador->errorinfo();
		endif;

else:
	//echo $sqlNombre->debugDumpParams();
	echo $sqlNombre->errorinfo();
endif;


echo json_encode(array($topicos, $colaboradores));