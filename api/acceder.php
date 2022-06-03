<?php 
include ("conectkarl.php");

if($_POST['usuario']=='-1'){

	$sql=$db->prepare("SELECT * FROM `usuarios` where clave = md5(?);");
	$resp = $sql->execute([ $_POST['clave'] ]);
	//echo $sql->debugDumpParams();
	if( $sql->rowCount()==1){
		echo 'admin';
		setcookie("usuario", 'admin', time()+(60*60*24*30), '/');
	}else{
		echo 'nada';
	}
}else{
	$sql=$db->prepare("SELECT * FROM `colaboradores` where dni = ?;");
	$resp = $sql->execute([ $_POST['clave'] ]);
	//echo $sql->debugDumpParams();
	if( $sql->rowCount()==1){
		echo 'colaborador';
		setcookie("usuario", 'colaborador', time()+(60*60*24*30), '/');
	}else{
		echo 'nada';
	}
}