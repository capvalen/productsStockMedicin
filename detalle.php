<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detalle productos</title>
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
							<a class="nav-link" href="topicos.php">Tópicos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Reportes</a>
						</li>
						
					</ul>
					<div class="d-flex">
						<input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" v-model="txtBuscar" @keyup.enter="buscarProducto()" @change="cambioBuscador()">
						<button class="btn btn-outline-success" @click="buscarProducto()">Buscar</button>
					</div>
				</div>
			</div>
		</nav>
		<div class="container">
			<h1>Detalle de <small class="text-muted text-capitalize">{{principal.nombre.toLowerCase()}}</small></h1>
			<div class="row col">
				<div class="d-grid gap-2 d-md-flex justify-content-md-end">
					<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCompras"><i class="bi bi-plus-square"></i> Agregar</button>
					<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto"><i class="bi bi-dash-square"></i> Retirar</button>
				</div>
			</div>
			<ul class="list-unstyled mb-3 mb-md-0">
				<li><strong>Stock actual:</strong> <span class="text-capitalize">{{principal.stock}}</span></li>
				<li><strong>Presentación:</strong> <span class="text-capitalize">{{principal.presentacion}}</span></li>
				<li><strong>Creado el:</strong> <span class="text-capitalize">{{fechaLatam(principal.creado)}}</span></li>
				<li><strong>Estado:</strong> <span class="text-capitalize">{{principal.activo=='1' ? 'Activo' : 'Desactivado' }}</span></li>
			</ul>
			<p class="h3 my-3">Movimientos realizados:</p>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>N°</th>
						<th>Fecha</th>
						<th>Detalle</th>
						<th>Cantidad</th>
						<th>Origen</th>
						<th>Destino</th>
						<th>Costo S/</th>
						<th>Obs.</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>14/05/2022 6:00 pm</td>
						<td>Ingreso</td>
						<td><span class="text-primary">+20</span></td>
						<td>FarmaIndustria</td>
						<td>Almacen principal</td>
						<td>50.00</td>
						<td></td>
					</tr>
					<tr>
						<td>2</td>
						<td>13/04/2022 4:30 pm</td>
						<td>Salida</td>
						<td><span class="text-danger">-6</span></td>
						<td>Almacén principal</td>
						<td>Topico Colonial</td>
						<td>0.00</td>
						<td></td>
					</tr>
					<tr>
						<td>2</td>
						<td>11/08/2021 4:18 am</td>
						<td>Devolución</td>
						<td><span class="text-warning">+3</span></td>
						<td>Almacén principal</td>
						<td>Topico Colonial</td>
						<td>0.00</td>
						<td>Por fecha vencimiento</td>
					</tr>
				</tbody>
			</table>
			
		</div>
		
		<!-- Modal para agregar movimiento de compra -->
		<div class="modal fade" id="modalCompras" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between ">
							<h5 class="modal-title">Realizar una adquisición</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<div class="my-3">
							<div class="mb-3">
								<label for="">Ingreso</label>
								<input type="date" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="ingreso">
							</div>
							<div class="mb-3">
								<label for="">Cantidad</label>
								<input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="cantidad">
							</div>

							<div class="mb-3">
								<label for="">Proveedor</label>
								<select class="form-select" aria-label="¿Qué proveedor es?" v-model="proveedor">
									<option v-for="provider in proveedores" :key="provider.id" :value="provider.id">{{provider.nombre}}</option>
								</select>
							</div>
							<div class="mb-3">
								<label for="">Costo</label>
								<input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="precio">
							</div>
							<div class="mb-3">
								<label for="">Lote</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="lote">
							</div>
							<div class="mb-3">
								<label for="">Fecha de vencimiento</label>
								<input type="date" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="vencimiento">
							</div>
							<div class="mb-3">
								<label for="">N° Documento</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="documentos">
							</div>
							<div class="mb-3">
								<label for="">Observaciones</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="observaciones">
							</div>

						</div>

						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							
							<button type="button" class="btn btn-primary">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		

	</div>

<script src="js/moment.min.js"></script>
<script src="js/moment-with-locales.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<!-- <script src="./js/moment-with-locales.min.js"></script> -->
<script>
	var modalCompras;
	var app=Vue.createApp({
		data() {
			return {
				servidor: 'http://localhost/productosMedicina/api/', id:'',
				principal:[], detalles:[],
				cantidad:'', precio:0, proveedores:[], destinos:[],
				proveedor:2, destino: 2,  //  <-- ninguno
				lote:'', vencimiento:'', observaciones:'', documentos:'', ingreso:moment().format('YYYY-MM-DD')
			}
		},
		created(){
			let uri = window.location.search.substring(1); 
	    let params = new URLSearchParams(uri);
	    //console.log(params.get('id'));
			this.id= params.get('id');
			this.principal.nombre = ''
			this.pedirTopicos();
			this.cargar();
		},
		mounted(){
			modalCompras = new bootstrap.Modal(document.getElementById('modalCompras'));
		},
		methods:{
			async pedirTopicos(){
				const respTopicos = await fetch(this.servidor + 'pedirTopicos.php');
				let datosTopicos = await respTopicos.json();
				console.log( datosTopicos );
				this.proveedores = datosTopicos[0];
				this.destinos = datosTopicos[1];
			},
			async cargar(){
				let datos = new FormData();
				datos.append('idProducto', this.id)
				
				const respuesta = await fetch(this.servidor + 'cargarDetallesPorId.php',{
					method:'POST', body: datos
				})
				let datosFijos = await respuesta.json();
				this.principal = datosFijos[0];
				this.detalles = datosFijos[1];
				//console.log( this.principal );
				
				//modalNuevoProducto.show();
			},
			fechaLatam(fechita){
				moment.locale('es');
				return moment(fechita, 'YYYY-MM-DD').format('dddd DD [de] MMMM [de] YYYY')
			}
			

		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>