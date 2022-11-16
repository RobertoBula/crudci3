<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD C I 3</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
	<!-- Titulo -->
	<div class="container">
		<div class="row">
			<h2 class="text-center mb-5">CRUD CI-3</h2>
		</div>
		<!-- formulario -->
		<div class="mb-4">
			<?php echo form_open('welcome/agregar', ['id' => 'form_personas']); ?>
			<div class="row">
				<div class=" form-group col-6 mb-3">
					<label>Nombres</label>
					<input type="text" name="nombre" class="form-control" placeholder="Nombres" id="nombre">
				</div>
				<div class=" form-group col-6 mb-3">
					<label>Apellidos</label>
					<input type="text" name="apellidos" class="form-control" placeholder="Apellidos" id="apellidos">
				</div>
				<div class=" form-group col-6 mb-3">
					<label>Fecha de nacimiento</label>
					<input type="date" name="fecha_nac" class="form-control" id="fecha_nac">
				</div>
				<div class=" form-group col-6 mb-3">
					<label>Genero</label>
					<input type="text" name="genero" class="form-control" placeholder="M o F" id="genero">
				</div>
			</div>
			<button type="submit" class="btn btn-primary col-12 mb-3">Guardar</button>
			<?php form_close(); ?>
		</div>
		<?php
		// if ($this->session->flashdata('message')) {
		// 	echo $this->session->flashdata('message');
		// }
		?>
		<!-- libreria xlsx -->
		<form method="post" action="<?php echo base_url('welcome/spreadsheet_import'); ?>" enctype="multipart/form-data">
			<div class="d-flex justify-content-between">
				<a href="<?php echo base_url('welcome/spreadsheet_download_format') ?>" target="_blank" class="btn btn-success col-5">Download excel format</a>
				<button class="btn btn-info text-white col-5">Download excel data</button>
			</div>
			<div class="mt-3">
				<input type="file" name="upload_file" class="form-control" placeholder="Enter Name" id="upload_file" required>
				<button type="submit" class="btn btn-primary col-3 mt-3 mb-3">submit</button>
			</div>
		</form>

		<!-- tabla de datos -->
		<div class="row">
			<div class="card">
				<div class="card-header">
					<h4 class="text-center">TABLA DE DATOS</h4>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nombre</th>
								<th scope="col">Apellidos</th>
								<th scope="col">Fecha de nacimiento</th>
								<th scope="col">Genero</th>
								<th scope="col">Editar</th>
								<th scope="col">Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 0;
							foreach ($personas as $persona) {
								echo '
									<tr>
									<td>' . ++$count . '</td>
									<td>' . $persona->nombre . '</td>
									<td>' . $persona->apellidos . '</td>
									<td>' . $persona->fecha_nac . '</td>
									<td>' . $persona->genero . '</td>
									<td> <button type="button" class="btn btn-info text-white" onclick="llenar_datos(' . $persona->id . ',`' . $persona->nombre . '`,`' . $persona->apellidos . '`,`' . $persona->fecha_nac . '`,`' . $persona->genero . '`)">Editar</button></td>
									<td><a href="' . base_url('welcome/eliminar/' . $persona->id) . '" type="button" class="btn btn-danger">Eliminar</a></td>
									</tr>
								';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
	<script>
		let url = "<?php echo base_url('welcome/editar') ?>"
		const llenar_datos = (id, nombre, apellidos, fecha_nac, genero) => {
			let edit = url + "/" + id;
			document.getElementById('form_personas').setAttribute('action', edit);
			document.getElementById('nombre').value = nombre;
			document.getElementById('apellidos').value = apellidos;
			document.getElementById('fecha_nac').value = fecha_nac;
			document.getElementById('genero').value = genero;
		}
	</script>
</body>

</html>