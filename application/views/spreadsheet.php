<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<title>PHPspreadsheet in CI3</title>
</head>

<body class="page-login">
	<div class="container mt-4">
		<h2 class="d-flex justify-content-between">PHPspreadsheet
			<span class="float-right">
				<a href="<?php echo base_url('excel/spreadsheet_format_download') ?>" target="_blank" class="btn btn-success">Download excel format</a>
				<a href="<?php echo base_url('excel/spreadsheet_export') ?>" target="_blank" class="btn btn-info text-white">Download excel data</a>
			</span>
		</h2>
		<?php
		if ($this->session->flashdata('message')) {
			echo $this->session->flashdata('message');
		}
		?>
		<form method="post" action="<?php echo base_url('excel/spreadsheet_import') ?>" enctype="multipart/form-data" class="mt-3">
			<div class="form-group">
				<input type="file" name="upload_file" class="form-control" placeholder="Enter Name" id="upload_file" required>
				<button type="submit" class="btn btn-primary mt-3 mb-3 col-3">Enviar</button>
				<a type="button" class="btn btn-outline-primary col-3" href="<?php echo base_url('welcome/index') ?>">Volver</a>
			</div>
		</form>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	</div>
</body>

</html>