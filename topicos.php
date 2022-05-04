<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tópicos Panel</title>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
<div id="app">

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid px-5">
			<a class="navbar-brand" href="#">Kardex Perú Medical</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="productos.php">Productos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="topicos.php">Tópicos</a>
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
				<div class="d-flex">
					<input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" v-model="txtBuscar" @keyup.enter="buscarTopico()" @change="cambioBuscador()">
					<button class="btn btn-outline-success" @click="buscarTopico()">Buscar</button>
				</div>
			</div>
		</div>
	</nav>
	<div class="container">

		<h1>Tópicos</h1>
		<div class="row col">
			<div class="d-grid gap-1 col-3 ms-auto">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">Crear producto</button>
			</div>

		</div>
		<p>Lista de tópicos actualmente activos:</p>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Tópico</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(topico, index) in topicos">
					<td>{{index+1}}</td>
					<td class="text-capitalize"><a class="text-decoration-none" :href="'detalleTopico.php?id='+topico.id">{{topico.nombre}}</a></td>
					<td><button type="button" v-if="topico.nombre!='Ninguno'" class="btn btn-outline-danger btn-sm border-0" @click="borrarTopicos(topico.id, topico.nombre, index)"><i class="bi bi-x-circle-fill"></i></button></td>
				</tr>
			</tbody>

		</table>

		<!-- Modal -->
		<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between mb-3">
							<h5 class="modal-title" id="exampleModalLabel">Nuevo tópico</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="form-floating mb-3">
							<input type="email" class="form-control" id="floatingInput" placeholder=" " autocomplete="off" v-model="nombre">
							<label for="floatingInput">Nombre del tópico</label>
						</div>
					
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" @click="crearTopico" data-bs-dismiss="modal">Crear tópico</button>
					</div>
				</div>
			</div>
		</div>
	</div>







	</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
	
<script>
	var modalNuevoProducto;
	var app=Vue.createApp({
		data() {
			return {
				//servidor: 'http://localhost/productosMedicina/api/',
				servidor: 'http://perumedical.infocatsoluciones.com/api/',
				topicos:[], presentaciones:[],
				nombre:'', presentacion:'1', txtBuscar:''
			}
		},
		mounted(){
			this.cargar();
			modalNuevoProducto = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
		},
		methods:{
			async cargar(){
				var resptopicos = await fetch(this.servidor + 'cargarTopicos.php')
				this.topicos = await resptopicos.json();
				console.log( this.topicos );
				
				//modalNuevoProducto.show();
			},
			async crearTopico(){
				var datos = new FormData();
				datos.append('nombre', this.nombre)
				const respuesta = await fetch(this.servidor + 'crearTopico.php', {
					method: 'POST', body: datos
				});
				var idTopico = await respuesta.text();
				if(!isNaN(idTopico)){
					this.topicos.unshift({id:idTopico, nombre: this.nombre })
				}
			},
			async borrarTopicos(queTopico, name, queIndex){
				if(confirm('¿Desea eliminar el tópico: '+name+'?')){
					var datos = new FormData();
					datos.append('id', queTopico);
					const respEliminar = await fetch(this.servidor+'eliminarTopico.php',{ method:'POST', body:datos })
					var quePaso = await respEliminar.text();
					if( quePaso=='ok' ){
						this.topicos.splice(queIndex,1)
					}
				}
			},
			async buscarTopico(){
				var datos = new FormData();
				datos.append('texto', this.txtBuscar );
				let respuesta = await fetch(this.servidor + 'buscarTopicos.php', {
					method:'POST', body:datos
				})
				var carga = await respuesta.json();
				this.topicos = carga;
				console.log( carga );
			},
			cambioBuscador(){
				if(this.txtBuscar==''){
					this.cargar();
				}
			}

		}
	}).mount('#app')
</script>
</body>
</html>