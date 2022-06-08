<?php
if( @!isset($_COOKIE["usuario"]) ){ header("Location:index.php");}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pedidos - Kardex Perú Medical</title>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
	<style>
		#tablePedido > tbody > tr:hover {
			background-color: #f5f5f5; cursor: pointer;
		}
	</style>
	<div id="app">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid px-5">
				<a class="navbar-brand" href="#">Kardex Perú Medical</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse " id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0 d-none">
						<li class="nav-item">
							<a class="nav-link " aria-current="page" href="productos.php">Productos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="topicos.php">Tópicos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="pedidos.php">Pedidos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="requerimientos.php">Requerimientos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="proveedores.php">Proveedores</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="presentaciones.php">Presentaciones</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="reportes.php">Reportes</a>
						</li>
						
					</ul>
					
				</div>
			</div>
		</nav>
		<div class="container-fluid px-5">
			<h1>Pedidos - Kardex Perú Medical</h1>
			<p>Rellene los campos para generar el pedido</p>
			<div class="row row-cols-1 row-cols-md-2">
				<div class="col">
					<div class="card">
						<div class="card-body">
							<p class="fs-2">Filtro</p>

							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Buscar producto" @keyup.enter="buscarProducto()" v-model="busqueda" >
								<button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
							</div>
							<p><i class="bi bi-info-circle-fill"></i> En caso de no existir el producto, seleccione <em>Ninguno</em> para que ingrese libremente un producto nuevo</p>
							<table class=" table table-hover" id="tablePedido">
								<thead>
									<tr>
										<td>N°</td>
										<td>Producto</td>
										<td>@</td>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(disponible, index) in disponibles" @click="agregarCanasta(disponible.id, index)">
										<td>{{index+1}}</td>
										<td>{{disponible.nombre}}</td>
										<td><span class=""><i class="bi bi-send-plus-fill"></i></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
				<div class="col">
					<div class="card card-body">
						<p class="fs-2">Hoja de requerimiento</p>
						<!-- <div class="mb-3"><input type="text" class="form-control" placeholder='Nombre del solicitante' v-model="solicitante"></div> -->

						<div class="form-floating mb-2">
							<select class="form-select" id="" aria-label=" " v-model="queTopico">
								<option value="-1" selected>Seleccione uno</option>
								<option class="text-capitalize" v-for="topico in topicos" :key="topico.id" :value="topico.id" v-show="topico.nombre!='Ninguno'">{{topico.nombre}}</option>
							</select>
							<label for="floatingSelect">Tópico final</label>
						</div>

						<div class="form-floating mb-2">
							<select class="form-select" id="" aria-label=" " v-model="idSolicitante" @change="cambiarSolicitante($event)">
								<option value="-1" selected >Seleccione uno</option>
								<option class="text-capitalize" v-for="colaborador in colaboradores" :key="colaborador.id" :value="colaborador.id" v-show="colaborador.idTopico == queTopico" >{{colaborador.nombres}} {{colaborador.apellidos}}</option>
							</select>
							<label for="floatingSelect">Colaborador</label>
						</div>

						<table class="table-hover table " v-if="pedidos.length>0">
							<thead>
								<tr class="table-dark">
									<td>N°</td>
									<td>Producto</td>
									<td>Cantidad</td>
									<td>@</td>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(pedido, index) in pedidos">
									<td>{{index+1}}</td>
									<td>{{pedido.nombre}}</td>
									<td class="col-sm-2"><input type="number" class="form-control text-center" value="1" v-model="pedido.cantidad" min="1" autocomplete="off"></td>
									<td><button class="btn btn-outline-danger border-0" @click="removerItem(index)" ><i class="bi bi-folder-x"></i></button></td>
								</tr>
							</tbody>
						</table>
						<p v-else>Agregue productos del otro panel</p>
						<p>Notas adicionales al pedido:</p>
						<div class="form-floating">
							<textarea class="form-control" placeholder="Leave a comment here" v-model="comentarios" style="height: 100px"></textarea>
							<label for="floatingTextarea2">Comentarios</label>
						</div>
						<div class="d-flex gap-1 justify-content-center mt-2">
						<button class="btn btn-outline-primary" @click="guardarSolicitud()"><i class="bi bi-cloud-upload"></i> Enviar solicitud</button>
						</div>
					</div>
				</div>
			</div>
			
		</div>

		<!-- Modal felicitaciones -->
		<div class="modal fade" id="modalFelicitaciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Pedido atendido</h5>
					</div>
					<div class="modal-body">
						<div class="d-flex justify-content-center"><img src="imgs/guardado.jpg" alt=""></div>
						<p class="mb-0">Su pedido guardado.</p>
						<p class="mb-0">Su administrador pronto atenderá su pedido con el código</p>
						<p class="fs-3 primary-text text-center mb-0">Pedido #{{idRespuesta}}</p>
						<p class="text-center fw-bold">Gracias por ser parte de Perú medical</p>
						<center><button class="btn btn-primary" @click="recargar()">Nueva Solicitud</button></center>
					</div>
				
				</div>
			</div>
		</div>

		
	</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<!-- <script src="./js/moment-with-locales.min.js"></script> -->
<script>
	var modalCompras, modalRetiros, liveToast, modalFelicitaciones;
	var idUsuario =1;
	var app=Vue.createApp({
		data() {
			return {
				//servidor: 'http://localhost/productosMedicina/api/',
				servidor: 'https://perumedical.infocatsoluciones.com/api/',
				busqueda:'', disponibles:[], pedidos:[], topicos:[], colaboradores:[],
				solicitante:'', queTopico:-1, comentarios:'', idSolicitante:-1, idRespuesta:''
			}
		},
		created(){ },
		mounted(){
			modalFelicitaciones = new bootstrap.Modal(document.getElementById('modalFelicitaciones'));
			this.pedirTopicos();
		},
		methods:{
			async pedirTopicos(){
				const respTopicos = await fetch(this.servidor + 'pedirTopicos.php');
				let datosTopicos = await respTopicos.json();
				console.log( datosTopicos );
				
				this.topicos = datosTopicos[1];
				this.colaboradores = datosTopicos[2];
			},
			async buscarProducto(){
				if(this.busqueda!=''){
					var datos = new FormData();
					datos.append('texto', this.busqueda)
					let respuesta = await fetch(this.servidor+'buscarProductosPedido.php',{
						method:'POST', body:datos
					});
					this.disponibles = await respuesta.json();
					console.log( this.disponibles );
					
				}
			},
			recargar(){ location.reload(); },
			agregarCanasta(id, item){
				
				if(id=='1'){
					let nTemporal = prompt('Ingrese el nombre del producto que desea agregar');
					this.pedidos.push({id:1, nombre: nTemporal, cantidad:1})
				}else{
					this.pedidos.push({id: this.disponibles[item].id, nombre: this.disponibles[item].nombre, cantidad:1})
				}
			},
			cambiarSolicitante(e){

				//console.log('soy el index '+ e.target.value )
				
				if(e.target.value ==-1){
					this.solicitante=='';
				}else{
					queIndex = this.colaboradores.findIndex(colaborador => colaborador.id == e.target.value )
					this.solicitante = this.colaboradores[queIndex].nombres +" "+this.colaboradores[queIndex].apellidos
				}
			},
			removerItem(index){ this.pedidos.splice(index,1); },
			async guardarSolicitud(){
				if(this.queTopico ==-1){
					alert('Debe seleccionar un tópico');
				}else if(this.idSolicitante==-1){
					alert('No debe dejar el solicitante en blanco');
				}else if(this.pedidos.length==0){
					alert('La lista de productos no puede estar vacía');
				} else{
					var datos = new FormData();
					datos.append('idSolicitante', this.idSolicitante )
					datos.append('solicitante', this.solicitante )
					datos.append('idTopico', this.queTopico)
					datos.append('comentarios', this.comentarios)
					datos.append('pedidos', JSON.stringify(this.pedidos))
	
					let respServer = await fetch(this.servidor + 'crearPedido.php',{
						method:'POST', body:datos
					})
					await respServer.text().then(respuesta =>{
						console.log( respuesta );
						if(parseInt(respuesta)>0){
							this.pedidos=[];
							this.pedidos=[]
							this.busqueda='';
							//alert('Su pedido fue registrado con el código #'+respuesta);
							this.idRespuesta = respuesta;
							modalFelicitaciones.show();
						}else{
							alert('Lo sentimos, hubo un error al guardar, contáctelo con el administrador');
						}
					});
				}
			}
		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>