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
	<title>Proveedor Panel</title>
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
						<a class="nav-link"  href="productos.php" aria-current="page">Productos</a>
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
						<a class="nav-link active" href="proveedores.php">Proveedores</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="presentaciones.php">Presentaciones</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="reportes.php">Reportes</a>
					</li>
					
				</ul>
				<!-- <div class="d-flex">
					<input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" v-model="txtBuscar" @keyup.enter="buscarProducto()" @change="cambioBuscador()">
					<button class="btn btn-outline-success" @click="buscarProducto()">Buscar</button>
				</div> -->
			</div>
		</div>
	</nav>
	<div class="container">

		<h1>Proveedores</h1>
		<div class="row col">
			<div class="d-grid gap-1 col-3 ms-auto">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">Crear proveedor</button>
			</div>

		</div>
		<p>Lista de proveedores:</p>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Nombre</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(proveedor, index) in proveedores">
					<td>{{index+1}}</td>
					<td class="text-capitalize">{{proveedor.nombre}}</td>
					<td><button type="button" class="btn btn-outline-danger btn-sm border-0" @click="borrarProveedor(proveedor.id, proveedor.nombre, index)"><i class="bi bi-x-circle-fill"></i></button></td>
				</tr>
			</tbody>

		</table>

		<!-- Modal -->
		<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between mb-3">
							<h5 class="modal-title" id="exampleModalLabel">Nuevo proveedor</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="form-floating mb-3">
							<input type="email" class="form-control" id="floatingInput" placeholder=" " autocomplete="off" v-model="nombre">
							<label for="floatingInput">Nombre de proveedor</label>
						</div>
					
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" @click="crearProveedor" data-bs-dismiss="modal">Crear proveedor</button>
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
				servidor: 'http://localhost/productosMedicina/api/',
				//servidor: 'http://perumedical.infocatsoluciones.com/api/',
				proveedores:[], topicos:[], presentaciones:[],
				nombre:'', presentacion:'1', txtBuscar:''
			}
		},
		mounted(){
			this.cargar();
			modalNuevoProducto = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
		},
		methods:{
			async cargar(){
				const respuesta = await fetch(this.servidor + 'cargarTopicos.php')
				this.topicos = await respuesta.json();
				const respuesta2 = await fetch(this.servidor + 'cargarPresentaciones.php')
				this.presentaciones = await respuesta2.json();
				//console.log( this.presentaciones );

				var respproveedores = await fetch(this.servidor + 'cargarProveedores.php')
				this.proveedores = await respproveedores.json();
				console.log( this.proveedores );
				
				//modalNuevoProducto.show();
			},
			async crearProveedor(){
				var datos = new FormData();
				datos.append('nombre', this.nombre)
				const respuesta = await fetch(this.servidor + 'crearProveedor.php', {
					method: 'POST', body: datos
				});
				var idProveedor = await respuesta.text();
				if(!isNaN(idProveedor)){
					this.proveedores.unshift({id:idProveedor, nombre: this.nombre })
				}
			},
			async borrarProveedor(queProveedor, name, queIndex){
				if(confirm('¿Desea eliminar el proveedor: '+name.toUpperCase()+'?')){
					var datos = new FormData();
					datos.append('id', queProveedor);
					const respEliminar = await fetch(this.servidor+'eliminarProveedor.php',{ method:'POST', body:datos })
					var quePaso = await respEliminar.text();
					if( quePaso=='ok' ){
						this.proveedores.splice(queIndex,1)
					}
				}
			},
			async buscarProducto(){
				var datos = new FormData();
				datos.append('texto', this.txtBuscar );
				let respuesta = await fetch(this.servidor + 'buscarproveedores.php', {
					method:'POST', body:datos
				})
				var carga = await respuesta.json();
				this.proveedores = carga;
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