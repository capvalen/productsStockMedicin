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
					<th>Tópico</th>
					<th>Fecha</th>
					<th>Obs.</th>
				</thead>
				<tbody>
					<tr v-for="(pedido, index) in pedidos" :key="pedido.id">
						<td>{{index+1}}</td>
						<td>
							<span class="text-danger" v-if="pedido.idProducto=='1'"><i class="bi bi-exclude"></i></span>
							<span class="text-primary" v-else><i class="bi bi-explicit-fill"></i></span>
						</td>
						<td class="text-capitalize">{{pedido.nombre}}</td>
						<td>{{fechaLatam(pedido.registro)}}</td>
						<td>{{pedido.comentarios}}</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>

<script src="js/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<!-- <script src="./js/moment-with-locales.min.js"></script> -->
<script>
	var modalCompras, modalRetiros, liveToast;
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
			this.pedirPedidos();
		},
		methods:{
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
			}
		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>