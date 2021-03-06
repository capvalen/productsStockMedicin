<?php
if( @!isset($_COOKIE["usuario"]) ){ header("Location:index.php");}
if($_COOKIE['usuario']=='colaborador'){ header("Location:index.php");}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Requerimientos - Kardex Perú Medical</title>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
</head>
<body>
	<style>
		table > tbody > tr:hover {
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
					<ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
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
		<div class="container">
			<h1>Detalle del requerimiento</h1>
			<ul class="list-unstyled mb-3 mb-md-0">
				<li><strong>Solicitante:</strong> <span class="text-capitalize">{{cabecera.solicitante}}</span></li>
				<li><strong>Tópico:</strong> <span class="text-capitalize">{{cabecera.nombre}}</span></li>
				<li><strong>Fecha:</strong> <span class="text-capitalize">{{fechaLatam(cabecera.registro)}}</span></li>
			</ul>
			<p class="mt-4">Puede agregar sumar y crear productos o simplemente cargar la data registrada</p>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-floating mb-3">
						<input type="email" class="form-control"placeholder="Búsqueda de un producto ya existente" autocomplete="off">
						<label for="floatingInput">Búsqueda de un producto ya existente</label>
					</div>
				</div>
			</div>
			<div class="row" >
				<div class="col d-flex justify-content-end" >
					<button v-if="cabecera.atendido=='0'" class="btn btn-danger" @click="anularFormato()"><i class="bi bi-envelope-paper"></i> Anular pedido</button>
				</div>
			</div>
			<table class="table table-hover">
				<thead>
					<th>N°</th>
					<th>Existe</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Entregar</th>
				</thead>
				<tbody>
					<tr v-for="(pedido, index) in pedidos" :key="pedido.id">
						<td>{{index+1}}</td>
						<td>
							<div v-if="cabecera.atendido=='0'">
								<span class="text-danger miToolTip" data-bs-placement="top" title="No existe" v-if="pedido.idProducto=='1'" @click="llamarModalNuevoProducto(index, pedido.id)"><i class="bi bi-exclude"></i></span>
								<span class="text-success miToolTip" data-bs-placement="top" title="Existe producto" v-else><i class="bi bi-explicit-fill"></i></span>
							</div>
						</td>
						<td class="text-capitalize">{{pedido.nombre}}</td>
						<td class="col-sm-1"><input type="number" class="form-control text-center" value="1" v-model="pedido.cantidad" min="1" autocomplete="off"></td>
						<td class="d-flex justify-content-center">
							<div class="form-check">
								<span v-if="pedido.idProducto=='1'"></span>
								<span v-else>
							  	<input class="form-check-input" type="checkbox" :data-id="pedido.id" :data-index="index" >
								</span>
							</div>
							
						</td>
					</tr>
				</tbody>
			</table>
			<div class="row" >
				<div class="col d-flex justify-content-end" v-if="cabecera.activo=='1'">
					<button v-if="cabecera.atendido=='0'" class="btn btn-primary" @click="generarFormato()"><i class="bi bi-envelope-paper"></i> Entregar  formato</button>
					<a v-if="cabecera.atendido=='1'" class="btn btn-success" :href="'impresion.php?idTopico='+id" ><i class="bi bi-paperclip"></i> Ver formato generado</a>
				</div>
			</div>
		</div>

		<!-- Modal para crear nuevo producto -->
		<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Crear nuevo producto</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p>Esta por crear el producto:</p>
						<input type="text" class="form-control" v-model="nuevoNombre">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" @click="crearInexistente()">Crear producto</button>
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
						<p class="mb-0">Su pedido fue atentido y guardado:</p>
						<p class="mb-0">Puede ver su pedido en el siguiente link:</p>
						<p class="fs-3 primary-text text-center"><a :href="'impresion.php?id='+idRespuesta">Requerimiento #{{idRespuesta}}</a></p>
					</div>
				
				</div>
			</div>
		</div>
	</div>

	</div>

<script src="js/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<!-- <script src="./js/moment-with-locales.min.js"></script> -->
<script>
	var modalCompras, modalRetiros, liveToast, toolTips, modalNuevoProducto, modalFelicitaciones;
	var idUsuario =1;
	var app=Vue.createApp({
		data() {
			return {
				//servidor: 'http://localhost/productosMedicina/api/',
				servidor: 'https://perumedical.infocatsoluciones.com/api/',
				busqueda:'', disponibles:[], pedidos:[], topicos:[], cabecera:[],
				solicitante:'', idTopico:-1, comentarios:'', nuevoNombre:'', queRegistro:-1, queItem:-1, idRespuesta:-1
			}
		},
		created(){
			let uri = window.location.search.substring(1); 
			let params = new URLSearchParams(uri);
			//console.log(params.get('id'));
			this.id= params.get('id');
		},
		mounted(){
			modalNuevoProducto = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
			modalFelicitaciones = new bootstrap.Modal(document.getElementById('modalFelicitaciones'));
			this.pedirPedidos().then(()=> this.cargarTools() );
		},
		methods:{
			cargarTools(){
				var listaToolTips = [].slice.call(document.querySelectorAll('.miToolTip'))
				//var tooltipList =
				listaToolTips.map(function (tooltip) {
					return new bootstrap.Tooltip(tooltip)
				})
			},
			async pedirPedidos(){
				let datas = new FormData();
				datas.append('id', this.id);
				const respTopicos = await fetch(this.servidor + 'pedirRequerimientoPorId.php', {
					method:'POST', body:datas
				});
				let datos = await respTopicos.json();
				console.log( datos );
				this.cabecera= datos[0];
				this.pedidos = datos[1];
				
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
			fechaLatam(fecha=''){
				if(fecha!=''){
					return moment(fecha).format('DD/MM/YYYY h:mm a');
				}else{return '';}
			},
			llamarModalNuevoProducto(item, queRegistro){
				this.queItem = item;
				this.queRegistro = queRegistro;
				this.nuevoNombre = this.pedidos[item].nombre.toUpperCase()
				modalNuevoProducto.show();
			},
			async crearInexistente(){		
				if(this.nuevoNombre!=''){
					let datas = new FormData();
					datas.append('nombre', this.nuevoNombre )
					datas.append('presentacion', 1 )
					datas.append('idRegistro', this.queRegistro )
					let respServ = await fetch(this.servidor+'crearProductoDirecto.php',{
						method: 'POST', body:datas
					})
					let idNuevo = await respServ.text();
					console.log(idNuevo);
					if(parseInt(idNuevo)>0){
						this.pedidos[this.queItem].idProducto=idNuevo;
						this.pedidos[this.queItem].nombre=this.nuevoNombre;
					}
					modalNuevoProducto.hide();

				}
				//if(confirm(`¿Desea crear el producto "${this.pedidos[item].nombre.toUpperCase()}"?`)){
				//}
			},
			async generarFormato(){
				//Obtener los items seleccionados
				var indexElegidos = [];
				var itemContenido = [];
				let lista = [].slice.call(document.querySelectorAll('.form-check-input'))
				lista.map(cajas=>{
					if(cajas.checked){
						let miniIndex = cajas.getAttribute('data-index');
						indexElegidos.push(miniIndex);
						itemContenido.push({id: this.pedidos[miniIndex].idProducto, cantidad: this.pedidos[miniIndex].cantidad })
					}
				});
				
				if(confirm(`Esta por generar para el tópico: ${this.cabecera.nombre.toUpperCase()}, un formato de ${indexElegidos.length} productos.\n ¿Es correcto?`)){
					let dCabecera = new FormData();
					dCabecera.append('idPedido', this.id)
					dCabecera.append('idTopico', this.cabecera.idTopico)
					dCabecera.append('contenido', JSON.stringify(itemContenido))
					let respuesta = await fetch(this.servidor + 'guardarRequerimiento.php',{
						method:'POST', body: dCabecera
					});
					//console.log( );
					let numPedido = await respuesta.text();
					if(parseInt(numPedido)>=1){
						this.idRespuesta = numPedido;
						//window.location.href="detalleTopico.php?id="+this.cabecera.idTopico;
						
						//window.open("detalleTopico.php?id="+this.cabecera.idTopico, "_blank");
						//alert('Se realizó el envío de los productos al tópico.')
						//window.open("impresion.php?idPedido="+this.id, "_blank");
						modalFelicitaciones.show();
					}else{
						alert('Hubo un error');
					}		
				}
			},
			async anularFormato(){
				if(confirm('¿Desea anular el pedido?')){
					let datas = new FormData();
					datas.append('id', this.id )
					let respServ = await fetch(this.servidor+'anularFormato.php',{
						method: 'POST', body:datas
					})
					if(await respServ.text()=='ok'){
						alert('Pedido anulado con éxito')
						this.cabecera.atendido=2;
					}
				}
			}
		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>