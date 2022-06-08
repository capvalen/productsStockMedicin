<?php 
include ("conectkarl.php");

switch( $_POST['idReporte']){
	case 'R1': reporteInventarios($db); break;
	case 'R2': reporteVenceran($db); break;
	case 'R3': movimientosPorTopico($db); break;
}

function reporteInventarios($db){
	$filas=[]; $i=0;
	$sql= $db->prepare("SELECT d.*, t.nombre as nomTopico, date_format(fecha, '%d/%m/%Y') as latFecha FROM `detalles` d inner join topicos t on t.id = d.idTopico where articulo<>'' and d.activo =1;");
	if( $sql->execute()){
		?> 
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Artículo</th>
					<th>Cantidad</th>
					<th>Tópico</th>
					<th>Fecha</th>
					<th>Cód. barra</th>
					<th>Obs.</th>
				</tr>
			</thead>
			<tbody>
				
		<?php
		if($sql->rowCount()==0){?> <tr> <td colspan="6">No hay registros</td></tr> <?php }
		while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
			$filas[] = $row; ?> 
			<tr>
				<td><?= $i+1;?></td>
				<td class="text-capitalize"><?= $row['articulo'];?></td>
				<td><?= $row['cantidad'];?></td>
				<td class="text-capitalize"><?= $row['nomTopico'];?></td>
				<td><?= $row['latFecha'];?></td>
				<td><?= $row['codPersonal'];?></td>
				<td><?= $row['observaciones'];?></td>
			</tr>
		<?php $i++;
		}
		?> </tbody> </table> <?php
		
	}else{
		//echo $sql->debugDumpParams();
		echo $sql->errorinfo();
	}
}

function reporteVenceran($db){
	$filas=[]; $i=0;
	$sql= $db->prepare("SELECT d.*, p.nombre , datediff( vencimiento, now()) as vence, date_format(vencimiento, '%d/%m/%Y') as latFecha FROM `detalles` d
	inner join productos p  on p.id = d.idProducto
	where vencimiento IS NOT NULL and vencimiento <> '0000-00-00' and p.stock>0;");
	if( $sql->execute()){
		?> 
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Artículo</th>
					<th>Cantidad</th>
					<th>Fecha</th>
					<th>En</th>
					<th>Obs.</th>
				</tr>
			</thead>
			<tbody>
				
		<?php
		if($sql->rowCount()==0){?> <tr> <td colspan="6">No hay registros</td></tr> <?php }
		while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
			$filas[] = $row; 
			if(intval($row['vence'])<=90  && intval($row['vence']>0 )){ ?> 
				<tr>
					<td><?= $i+1;?></td>
					<td class="text-capitalize"><?= $row['nombre'];?></td>
					<td><?= $row['cantidad'];?></td>
					<td><?= $row['latFecha'];?></td>
					<td><?= $row['vence']." días";?></td>
					<td><?= $row['observaciones'];?></td>
				</tr>
			<?php
			$i++;
			}
		}
		?> </tbody> </table> <?php
		
	}else{
		//echo $sql->debugDumpParams();
		echo $sql->errorinfo();
	}
}

function movimientosPorTopico($db){
	$filas=[]; $i=0; $filtro='';
	if($_POST['idProducto']!='-1'){
		$filtro = "and d.idProducto = ".$_POST['idProducto'];
	}
	$sql= $db->prepare("SELECT d.*, p.nombre, date_format(fecha, '%d/%m/%Y') as latFecha FROM `detalles` d
	inner join productos p  on p.id = d.idProducto
	where d.idMovimiento =2 and d.idTopico = ? and fecha between ? and ? {$filtro};");
	if( $sql->execute([ $_POST['idTopico'], $_POST['fecha1'], $_POST['fecha2'] ])){
		?> 
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Artículo</th>
					<th>Cantidad</th>
					<th>Fecha</th>
					<th>Obs.</th>
				</tr>
			</thead>
			<tbody>
				
		<?php
		if($sql->rowCount()==0){?> <tr> <td colspan="6">No hay registros</td></tr> <?php }
		while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
			$filas[] = $row; ?> 
				<tr>
					<td><?= $i+1;?></td>
					<td class="text-capitalize"><?= $row['nombre'];?></td>
					<td><?= $row['cantidad'];?></td>
					<td><?= $row['latFecha'];?></td>
					<td><?= $row['observaciones'];?></td>
				</tr>
			<?php
			$i++;
		}
		?> </tbody> </table> <?php
		
	}else{
		//echo $sql->debugDumpParams();
		echo $sql->errorinfo();
	}
}