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
							<a class="nav-link" href="#">Reportes</a>
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
							<span class="text-danger miToolTip" data-bs-placement="top" title="No existe" v-if="pedido.idProducto=='1'" @click="crearInexistente(index, pedido.id)"><i class="bi bi-exclude"></i></span>
							<span class="text-success miToolTip" data-bs-placement="top" title="Existe producto" v-else><i class="bi bi-explicit-fill"></i></span>
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
			<div class="row">
				<div class="col d-flex justify-content-end">
					<button class="btn btn-primary" @click="generarFormato()">Entregar y generar formato</button>
				</div>
			</div>
		</div>

	</div>

<script src="js/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<!-- <script src="./js/moment-with-locales.min.js"></script> -->
<script>
	var modalCompras, modalRetiros, liveToast, toolTips;
	var idUsuario =1;
	var app=Vue.createApp({
		data() {
			return {
				servidor: 'http://localhost/productosMedicina/api/',
				//servidor: 'http://perumedical.infocatsoluciones.com/api/',
				busqueda:'', disponibles:[], pedidos:[], topicos:[], cabecera:[],
				solicitante:'', idTopico:-1, comentarios:''
			}
		},
		created(){
			let uri = window.location.search.substring(1); 
			let params = new URLSearchParams(uri);
			//console.log(params.get('id'));
			this.id= params.get('id');
		},
		mounted(){
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
			async crearInexistente(item, queRegistro){
				if(confirm(`¿Desea crear el producto "${this.pedidos[item].nombre.toUpperCase()}"?`)){
					let datas = new FormData();
					datas.append('nombre', this.pedidos[item].nombre.toUpperCase() )
					datas.append('presentacion', 1 )
					datas.append('idRegistro', queRegistro )
					let respServ = await fetch(this.servidor+'crearProductoDirecto.php',{
						method: 'POST', body:datas
					})
					let idNuevo = await respServ.text();
					if(parseInt(idNuevo)>0){
						this.pedidos[item].idProducto=idNuevo;
					}
				}
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
				
				if(confirm(`Esta por generar el formato de ${indexElegidos.length} productos para el tópico: ${this.cabecera.nombre.toUpperCase()} `)){
					let dCabecera = new FormData();
					dCabecera.append('idPedido', this.id)
					dCabecera.append('contenido', JSON.stringify(itemContenido))
					let respuesta = await fetch(this.servidor + 'guardarRequerimiento.php',{
						method:'POST', body: dCabecera
					});
					console.log( await respuesta.text() );
					
				}
			}
		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>