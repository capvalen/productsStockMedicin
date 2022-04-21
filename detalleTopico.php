<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tópicos</title>
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
			<h1>Detalle de tópico <small class="text-muted text-capitalize">{{principal.nombre.toLowerCase()}}</small></h1>
			
			<ul class="list-unstyled mb-3 mb-md-0">
				<li><strong>Valorizado en productos:</strong> S/ <span class="text-capitalize">{{parseFloat(principal.valorizado).toFixed(2)}}</span></li>
			</ul>

			<nav>
				<div class="nav nav-tabs mt-3" id="nav-tab" role="tablist">
					<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Productos</button>
					<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Inventario</button>
				</div>
			</nav>

			<div class="tab-content " id="nav-tabContent">
				<div class="tab-pane p-3 fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					<p class="my-3">Listado de productos</p>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>N°</th>
								<th>Fecha</th>
								<th>Producto</th>
								<th>Detalle</th>
								<th>Cantidad</th>
								<th>Origen</th>
								<th>Costo S/</th>
								<th>Obs.</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(detalle, index) in detalles" :key="detalle.id">
								<td>{{index+1}}</td>
								<td>{{fechaLatam(detalle.fecha)}}</td>
								<td class="text-capitalize">{{detalle.nombre.toLowerCase()}}</td>
								<td>
									<span v-if="detalle.descripcion=='Salida'">Entrada</span>
									<span v-else>{{detalle.descripcion}}</span>
								</td>
								<td>
									<span class="text-danger" v-if="detalle.tipo==1">-{{detalle.cantidad}}</span>
									<span class="text-primary" v-else>+{{detalle.cantidad}}</span>
								</td>
								<td>{{detalle.proveedor}}</td>
								<td>
									<span v-if="detalle.tipo==1">{{parseFloat(detalle.costo).toFixed(2)}}</span>
									<span v-else>{{parseFloat(detalle.costo * detalle.cantidad).toFixed(2)}}</span>
								</td>
								<td>{{detalle.observaciones}}</td>
							</tr>
						</tbody>
					</table>
						
				</div>
				<div class="tab-pane p-3 fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<div class="row col">
						<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalInventario"><i class="bi bi-plus-square"></i> Agregar</button>
						</div>
					</div>
					<p class="my-3">Listado de inventario en este tópico</p>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>N°</th>
								<th>Fecha</th>
								<th>Producto</th>
								<th>Detalle</th>
								<th>Cantidad</th>
								<th>Origen</th>
								<th>Costo S/</th>
								<th>Obs.</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(inventario, index) in inventarios" :key="inventario.id">
								<td>{{index+1}}</td>
								<td>{{fechaLatam(inventario.fecha)}}</td>
								<td class="text-capitalize">{{inventario.articulo.toLowerCase()}}</td>
								<td>
									<span v-if="inventario.descripcion=='Salida'">Entrada</span>
									<span v-else>{{inventario.descripcion}}</span>
								</td>
								<td>
									<span class="text-danger" v-if="inventario.tipo==1">-{{inventario.cantidad}}</span>
									<span class="text-primary" v-else>+{{inventario.cantidad}}</span>
								</td>
								<td>{{inventario.proveedor}}</td>
								<td>
									<span v-if="inventario.tipo==1">{{parseFloat(inventario.costo).toFixed(2)}}</span>
									<span v-else>{{parseFloat(inventario.costo * inventario.cantidad).toFixed(2)}}</span>
								</td>
								<td>{{inventario.observaciones}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			
			
		</div>
		
		<!-- Modal para agregar movimiento de compra -->
		<div class="modal fade" id="modalInventario" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between ">
							<h5 class="modal-title">Agregar al inventario</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<div class="my-3">
							<div class="mb-3">
								<label for="">Ingreso</label>
								<input type="date" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="ingreso">
							</div>
							<div class="mb-3">
								<label for="">Artículo</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="articulo">
							</div>
							<div class="mb-3">
								<label for="">Cantidad</label>
								<input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="cantidad">
							</div>

							<div class="mb-3">
								<label for="">Costo Und.</label>
								<input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="precio">
							</div>
							<div class="mb-3">
								<label for="">N° Documento</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="documento">
							</div>
							<div class="mb-3">
								<label for="">Observaciones</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="observacion">
							</div>

						</div>

						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							
							<button type="button" class="btn btn-primary" @click="guardarInventario()" >Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal para agregar movimiento de salidas -->
		<div class="modal fade" id="modalRetiros" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between ">
							<h5 class="modal-title">Realizar una distribución</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<div class="my-3">
							<div class="mb-3">
								<label for="">Egreso</label>
								<input type="date" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="ingreso">
							</div>
							<div class="mb-3">
								<label for="">Cantidad</label>
								<input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="cantidad">
							</div>

							<div class="mb-3">
								<label for="">Tópico destino</label>
								<select class="form-select" id="sltDestino" aria-label="¿Qué proveedor es?" v-model="destino">
									<option v-for="destino in destinos" :key="destino.id" :value="destino.id">{{destino.nombre}}</option>
								</select>
							</div>
							<div class="mb-3">
								<label for="">N° Documento</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="documento">
							</div>
							<div class="mb-3">
								<label for="">Observaciones</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" v-model="observacion">
							</div>

						</div>

						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							
							<button type="button" class="btn btn-primary" @click="guardarRetiro()" >Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1051">
			<div class="toast align-items-center text-white bg-danger border-0" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						<i class="bi bi-bug"></i> {{mensaje}}
					</div>
					<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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
	var modalInventario, modalRetiros, liveToast;
	var idUsuario =1;
	var app=Vue.createApp({
		data() {
			return {
				servidor: 'http://localhost/productosMedicina/api/', id:'',
				principal:[{nombre: '', valorizado:0}], detalles:[], inventarios:[],
				cantidad: 1, precio:0, proveedores:[], destinos:[],
				proveedor:2, destino: 2,  //  <-- ninguno
				articulo:'', lote:'', vencimiento:'', observacion:'', documento:'', ingreso:moment().format('YYYY-MM-DD'),
				mensaje:''
			}
		},
		created(){
			let uri = window.location.search.substring(1); 
			let params = new URLSearchParams(uri);
			//console.log(params.get('id'));
			this.id= params.get('id');
			this.pedirTopico();
			this.cargar();
			
		},
		mounted(){
			modalInventario = new bootstrap.Modal(document.getElementById('modalInventario'));
			modalRetiros = new bootstrap.Modal(document.getElementById('modalRetiros'));
			liveToast = new bootstrap.Toast(document.getElementById('liveToast'));
		},
		methods:{
			async pedirTopico(){
				let datos = new FormData();
				datos.append('id', this.id)
				const respTopicos = await fetch(this.servidor + 'pedirTopico.php',{
					method:'POST', body: datos
				});
				let datosTopicos = await respTopicos.json();
				//console.log( datosTopicos );
				this.principal.nombre = datosTopicos.nombre;
				this.principal.valorizado = datosTopicos.valorizado;
				
			},
			async cargar(){
				let datos = new FormData();
				datos.append('id', this.id)
				
				//Para detalles
				const respuesta = await fetch(this.servidor + 'cargarTopicoDetallesPorId.php',{
					method:'POST', body: datos
				})
				let datosFijos = await respuesta.json();
				this.detalles = datosFijos;

				//Para inventarios:
				const respuestaInv = await fetch(this.servidor + 'cargarInventarioPorId.php',{
					method:'POST', body: datos
				})
				let datosInv = await respuestaInv.json();
				this.inventarios = datosInv;
				//console.log( datosFijos );

				//console.log( this.principal );
			},
			fechaLarga(fechita){
				moment.locale('es');
				return moment(fechita, 'YYYY-MM-DD').format('dddd DD [de] MMMM [de] YYYY')
			},
			fechaLatam(fechita){
				moment.locale('es');
				return moment(fechita, 'YYYY-MM-DD').format('DD/MM/YYYY')
			},
			async guardarInventario(){
				if(this.nombre==''){
					this.mensaje="El artículo no puede estar vacío"; liveToast.show();
				}else{
					let datosEnviar = new FormData();
					datosEnviar.append('id', 1); //idProducto = ninguno
					datosEnviar.append('origen', this.id); //ID topico
					datosEnviar.append('destino', this.id); //ID topico
					datosEnviar.append('ingreso', this.ingreso);
					datosEnviar.append('cantidad', this.cantidad);
					datosEnviar.append('precio', this.precio);
					datosEnviar.append('lote', '');
					datosEnviar.append('vencimiento', '');
					datosEnviar.append('documento', this.documento);
					datosEnviar.append('observacion', this.observacion);
					datosEnviar.append('articulo', this.articulo);
					datosEnviar.append('movimiento', 5); //entrada de inventario
					datosEnviar.append('usuario', idUsuario);
	
					let queryGuardar = await fetch(this.servidor+'guardarTopicoDetalle.php',{
						method:'POST', body: datosEnviar
					})
					let respGuardar = await queryGuardar.text().then(response=>{
						//console.log( response );
						this.inventarios.unshift({
							id: response,
							idProducto: 1,
							idProveedor: this.id,
							idMovimiento: 5, //ingreso
							tipo: 1, //suma
							descripcion: 'Entrada de inventario',
							cantidad: this.cantidad,
							fecha: this.ingreso,
							registro: moment().format('YYYY-MM-DD HH:mm:ss'),
							idUsuario,
							activo:1,
							costo: this.precio,
							lote: this.lote,
							vencimiento: this.vencimiento,
							documento: this.documento,
							observaciones: this.observacion,
							articulo: this.articulo
						})
						modalInventario.hide()
					});
				}
			},
			async guardarRetiro(){
				if(this.cantidad=='' || this.cantidad==0){
					this.mensaje="La cantidad no puede ser 0"; liveToast.show();
				}else{
					let datosEnviar = new FormData();
					datosEnviar.append('id', this.id);
					datosEnviar.append('origen', 1);//almacen principal
					datosEnviar.append('destino', this.destino);
					datosEnviar.append('ingreso', this.ingreso);
					datosEnviar.append('cantidad', this.cantidad);
					datosEnviar.append('precio', this.principal.precio);
					datosEnviar.append('documento', this.documento);
					datosEnviar.append('observacion', this.observacion);
					datosEnviar.append('movimiento', 2); //ingreso
					datosEnviar.append('usuario', idUsuario); //ingreso
	
					let queryGuardar = await fetch(this.servidor+'guardarSalidaDetalle.php',{
						method:'POST', body: datosEnviar
					})
					let respGuardar = await queryGuardar.text().then(response=>{
						//console.log( response );
						this.detalles.unshift({
							id: response,
							idProducto:this.id,
							idProveedor: 1, //almacén principal
							idMovimiento: 2, //ingreso
							tipo: 0, //suma
							descripcion: 'Salida',
							cantidad: this.cantidad,
							fecha: this.ingreso,
							registro: moment().format('YYYY-MM-DD HH:mm:ss'),
							idUsuario,
							activo:1,
							costo: this.principal.precio,
							lote: '',
							vencimiento: '',
							documento: this.documento,
							observaciones: this.observacion,
							nomTopico: document.getElementById('sltDestino').options[document.getElementById('sltDestino').selectedIndex].text,
							nomProveedor: 'Almacén principal'
						})
						modalRetiros.hide()
					});
				}
			},
			

		},
		computed:{
			

		}
	}).mount('#app')
</script>
</body>
</html>