<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bienvenido a Kardex Perú Medical</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
	<style>
		#logo{
			width: 250px;
		}
	</style>
	<div id="app" class="container p-5  ">
		<div class="row mt-5 rounded border p-3" >
			<div class="col d-flex justify-content-center">
				<img src="./imgs/cuadradito.png">
			</div>
			<div class="col px-5 py-5" >
				<div class="d-flex justify-content-center">
					<img src="./imgs/logo.png" alt="" id="logo">
				</div>
				<h1 class="text-center text-primary fs-2 my-4">Bienvenido al sistema de Kardex Perú Médical</h1>
				<p>Ingrese sus credenciales para acceder</p>
				<select name="" class="form-select text-capitalize" v-model="usuario">
					<!-- <option class="text-capitalize" v-for="colaborador in colaboradores" :key="colaborador.id" :value="colaborador.id">{{colaborador.nombres}} {{colaborador.apellidos}}</option> -->
					<option value="-1">Administrador</option>
					<option value="1">Colaborador</option>
				</select>
				<p class="mt-2 mb-0">Clave:</p>
				<input type="password" class="form-control" autocomplete="off" v-model="clave">
				<div class="d-grid gap-2 d-flex justify-content-center mt-2">
					<button type="button" class="btn btn-outline-primary" @click="acceder()"><i class="bi bi-postcard"></i> Acceder al sistema</button>
				</div>
				<p class="mt-5">Versión: 1.11.5 - Build: 22.0627</p>
			</div>
		</div>
	</div>
	<script src="https://unpkg.com/vue@3"></script>
	
<script>
	var modalNuevoProducto;
	var app=Vue.createApp({
		data() {
			return {
				//servidor: 'http://localhost/productosMedicina/api/',
				servidor: 'https://perumedical.infocatsoluciones.com/api/',
				colaboradores:[], usuario:-1, clave:''
			}
		},
		mounted(){
			this.cargar();
		},
		methods:{
			async cargar(){
				var resptopicos = await fetch(this.servidor + 'pedirColaboradores.php')
				this.colaboradores = await resptopicos.json();
				//console.log( this.colaboradores);
				
				//modalNuevoProducto.show();
			},
			async acceder(){
				let datos = new FormData();
				datos.append('clave', this.clave)
				datos.append('usuario', this.usuario);
				let respServ = await fetch(this.servidor+'acceder.php',{
					method:'POST', body:datos
				});
				//console.log( await respServ.text() );
				switch (await respServ.text()) {
					case 'admin': window.location.href = "productos.php"; break;
					case 'colaborador': window.location.href = "pedidos.php"; break;
					case 'nada': alert('Clave errónea'); break;
				
					default:
						break;
				}
				
			}
			

		}
	}).mount('#app')
</script>
</body>
</html>