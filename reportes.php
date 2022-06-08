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
	<title>Productos Panel</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
<style>
	#divResultadoProductos tbody>tr, #limpiarFiltro{
		cursor:pointer;
	}
</style>
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
						<a class="nav-link" aria-current="page" href="productos.php">Productos</a>
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
						<a class="nav-link active" href="reportes.php">Reportes</a>
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

		<h1>Reportes</h1>
		
		<p>Seleccione que reporte desea:</p>
		<div class="row row g-3">
			<div class="col">
				<select class="form-select" id="sltReporte" @change="cambiarTipoReporte()">
					<option value="-1" selected>Tipo de reporte</option>
					<option value="R3">Entrega a tópicos</option>
					<option value="R2">Pronto a vencer</option>
					<option value="R1">Todos los inventarios</option>
				</select>
			</div>
			<div class="col">
				<button class="btn btn-primary" @click="pedirReporte()"><i class="bi bi-search"></i></button>
				<span class="ps-2 fw-light fst-italic">{{instrucciones}}</span>
			</div>
		</div>
		<div class="py-3" id="divFiltros" v-if="filtros">
			<div class="row row-cols-1 row-cols-md-4">
				<div class="col my-1">
					<select class="form-select" id="" class="text-capitalize" v-model="idTopico">
						<option class="text-capitalize" v-for="topico in topicos" :key="topico.id" :value="topico.id">{{topico.nombre}}</option>
					</select>
				</div>
				<div class="col my-1">
					<input type="date" class="form-control" v-model="fecha1">
				</div>
				<div class="col my-1">
					<input type="date" class="form-control" v-model="fecha2">
				</div>
				<div class="col my-1">
					<select class="form-select" id="sltTipoProducto" @change="cambiarTipoProducto()">
						<option value="T">Todos los productos</option>
						<option value="P">Por producto específico</option>
					</select>
					<span v-if="instrucciones2!=''"> <span id="limpiarFiltro" class="text-danger" @click="limpiarFiltro"><i class="bi bi-x-circle-fill"></i></span> {{instrucciones2}}</span>
				</div>
				
			</div>
		</div>
		<div class="py-3" id="divResultados"></div>
		
		

		<!-- Modal -->
		<div class="modal fade" id="modalBuscarProducto" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between mb-3">
							<h5 class="modal-title" id="exampleModalLabel">Buscar un producto</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="input-group mb-3">
						  <input type="text" class="form-control" placeholder="Buscar por nombre" v-model="texto" @keyup.enter="buscarProducto()">
						  <button class="btn btn-outline-secondary" @click="buscarProducto()" type="button" ><i class="bi bi-search"></i></button>
						</div>

						<div id="divResultadoProductos">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>N°</th>
										<th>Producto</th>
										<th>@</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(producto, index) in productos" :key="producto.id" data-bs-dismiss="modal" @click="cambiarContenidoProductos(producto.id, producto.nombre)">
										<td>{{index+1}}</td>
										<td>{{producto.nombre}}</td>
										<td><i class="bi bi-check2-square"></i></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
					
				</div>
			</div>
		</div>

	</div>

	</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<script src="js/moment.min.js"></script>
	
<script>
	var modalBuscarProducto;
	var app=Vue.createApp({
		data() {
			return {
				servidor: 'http://localhost/productosMedicina/api/',
				//servidor: 'http://perumedical.infocatsoluciones.com/api/',
				instrucciones:'', instrucciones2:'', filtros:false,
				fecha1: moment().format('YYYY-MM-'+'01'), fecha2: moment().format('YYYY-MM-DD'),
				topicos:[], idTopico:-1, texto:'', productos:[], idProducto:-1, nomProducto:''
			
			}
		},
		mounted(){
			this.cargar();
			modalBuscarProducto = new bootstrap.Modal(document.getElementById('modalBuscarProducto'));
		},
		methods:{
			async cargar(){
				var resptopicos = await fetch(this.servidor + 'cargarTopicos.php')
				this.topicos = await resptopicos.json();
				
			},
			cambiarTipoReporte(){
				this.filtros=false;
				this.instrucciones2='';
				switch (document.getElementById('sltReporte').value) {
					case 'R2': this.instrucciones = 'Se muestran productos que vencerán en 3 meses'; break;
					case 'R3': this.instrucciones = 'Entre 2 fechas, opcional elegimos un producto'; this.filtros=true; break;
					default:
						break;
				}
			},
			async pedirReporte(){
				let datos = new FormData();
				datos.append('idReporte', document.getElementById('sltReporte').value )
				datos.append('fecha1', this.fecha1 )
				datos.append('fecha2', this.fecha2 )
				datos.append('idTopico', this.idTopico )
				datos.append('idProducto', this.idProducto )
				
				
				let respServ = await fetch(this.servidor+ 'pedirReportes.php',{
					method:'POST', body: datos
				});
				//console.log( await respServ.text() );
				divResultados.innerHTML=await respServ.text();
			},
			cambiarTipoProducto(){
				this.instrucciones2='';
				switch (document.getElementById('sltTipoProducto').value) {
					case 'T': this.idProducto=-1; this.instrucciones=''; break;
					case 'P': modalBuscarProducto.show(); break;
					default: break;
				}
			},
			async buscarProducto(){
				if(this.texto!=''){
					let datos = new FormData();
					datos.append('texto', this.texto );
					let respServ = await fetch(this.servidor+ 'buscarProductos.php',{
						method:'POST', body: datos
					});
					this.productos = await respServ.json() ;
				}
			},
			cambiarContenidoProductos(id, nombre){
				this.idProducto = id;
				this.nomProducto= nombre;
				this.instrucciones2 ="Por: " + nombre;
			},
			limpiarFiltro(){
				this.idProducto=-1; this.instrucciones2='';
				document.getElementById('sltTipoProducto').selectedIndex ='T'
			}

		}
	}).mount('#app')
</script>
</body>
</html>