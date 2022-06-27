<?php 
include './api/conectkarl.php';
$id='';
if(isset($_GET['idPedido'])){
	$sql = $db->prepare("SELECT * FROM `requerimientos` where idPedido = ? ;");
	if($sql->execute([ $_GET['idPedido'] ])){
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		//var_dump( $row['id'] );
		if( $sql->rowCount()==1){ $id = $row['id']; }
	}
}
if(isset($_GET['id'])){ $id = $_GET['id']; }
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Impresión - Kardex Perú Medical</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
</head>
<body>
	<style>
		p, td{font-size: 0.8rem;}
		.trDatos>th, #tableDatosIzq{font-size: 0.6rem;}
		td{padding:0.2rem!important}
	</style>
	<nav class="navbar navbar-expand-lg navbar-light bg-light d-print-none">
		<div class="container-fluid px-5">
			<a class="navbar-brand" href="#">Kardex Perú Medical</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse " id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="productos.php"><i class="bi bi-backspace"></i> Ir al inicio</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-fluid container-lg my-3" id="app">
		<table class="table mb-0">
			<tbody class="border-none" style="border: transparent;">
				<tr>
					<td class="col-3 p-0 ">
						<img src="./imgs/logo.png" alt="" class="img-fluid">
					</td>
					<td>
						<h1 class="fs-4 text-center">Acta de entrega de medicamentos y otros</h1>
						<h2 class="fs-4 text-danger text-center mb-0">N° R-{{cabecera.codificado}}</h2>
					</td>
					<td class="col-4 p-0 ">
						<table class="table table-bordered border-secondary">
							<tbody id="tableDatosIzq">
								<tr> <td class="py-0 ps-0 pe-2 text-end"><strong>Mes:</strong></td> <td class="col-7 p-1"> <span>{{retornarMes(cabecera.mes-1)}}</span></td> </tr>
								<tr> <td class="py-0 ps-0 pe-2 text-end"><strong>Aprobado:</strong></td> <td class="col-7 p-0 ps-1"> <span>Elver Mateo</span></td> </tr>
								<tr> <td class="py-0 ps-0 pe-2 text-end"><strong>Elaborado:</strong></td> <td class="col-7 p-1"><span class="text-capitalize">{{cabecera.solicitante}}</span></td> </tr>
								<tr> <td class="py-0 ps-0 pe-2 text-end"><strong>Fecha:</strong></td> <td class="col-7 p-0 ps-1"> <span>{{cabecera.registro}}</span></td> </tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered border-secondary">
			<tbody>
				<tr class="trDatos ">
					<th class="text-center">Razón Social</th>
					<th class="text-center">RUC</th>
					<th class="text-center">Domicilio fiscal</th>
					<th class="text-center">Actividad económica</th>
					<th class="text-center">Tópico</th>
				</tr>
				<tr class="trDatos">
					<th class="text-center">Corporación Perú Medical Assistance S.A.C.</th>
					<th class="text-center">20563249847</th>
					<th class="text-center">Av. Universitaria Mz. O Lte. 47 Urb. Pacífico - SMP</th>
					<th class="text-center">Servicios Pre - Hospitalarios de Urgencias</th>
					<th class="text-center text-capitalize">{{cabecera.nombre}}</th>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered border-secondary">
			<thead>
				<tr>
					<th>N°</th>
					<th>Descripción</th>
					<th>Cantidad</th>
					<th>Obs.</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(pedido, index) in pedidos" :key="pedido.id">
					<td>{{index+1}}</td>
					<td>{{pedido.nombre}}</td>
					<td>{{pedido.cantidad}}</td>
					<td></td>
				</tr>
				

			</tbody>
		</table>

		<div class="row">
			<div class="col-4 ms-2 border border-1 border-secondary">
				<p><strong>Recibí Conforme</strong></p>
				<p class="text-end">___________________________</p>
				<p class="text-end">Lic. (a) ________________________</p>
			</div>
			<div class="col-2"></div>
			<div class="col">
				<div class="col me-2 border border-1 border-secondary">
					<p></p>
					<p class="text-end">_______________________________________</p>
					<p class="text-end">Entregado por: ___________________________</p>
				</div>
			</div>
		</div>

	</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<script>
	var modalCompras, modalRetiros, liveToast, toolTips;
	var idUsuario =1;
	var app=Vue.createApp({
		data() {
			return {
				//servidor: 'http://localhost/productosMedicina/api/',
				servidor: 'https://perumedical.infocatsoluciones.com/api/',
				busqueda:'', disponibles:[], pedidos:[], topicos:[], cabecera:[],
				solicitante:'', idTopico:-1, comentarios:'',
				meses:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
			}
		},
		created(){
			//let uri = window.location.search.substring(1); 
			//let params = new URLSearchParams(uri);
			//console.log(params.get('id'));
			this.id= '<?= $id; ?>';//params.get('id')
		},
		mounted(){
			this.llamarDatos();
		},
		methods:{
			async llamarDatos(){
				let datos = new FormData();
				datos.append('idRequerimiento', this.id)
				let respServ = await fetch(this.servidor + 'cargarRequerimientosPorId.php',{
					method:'POST', body:datos
				})
				let generales = await respServ.json();
				this.cabecera =  generales[0];
				this.pedidos =  generales[1];
			},
			retornarMes(mes){
				return this.meses[mes];
			}
			
		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>