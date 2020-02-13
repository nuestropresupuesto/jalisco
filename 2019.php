<?php 
require_once('estandares/includes.php');
$title="Reporte 2019";
$descripcion="Se muestran las observaciones realizadas por más de 70 voluntarias y voluntarios al Proyecto de Presupuesto 2020 antes de su aprobación por el Congreso de Jalisco.";
$thumb="https://www.nuestropresupuesto.mx/imgs/thumb_app.jpg";
$tags=array();
pageHead($title,$descripcion,$thumb,$tags);
	 ?>
		<h1>Edición 2019</h1>
		<h4>Reporte final</h4>
		<div class="row">
			<div class="col s12 m6">
				<a target="_blank" href="https://docs.google.com/document/d/1uRJvxcOKXc-tZfADl9OU6sQ-rco8ejv4y4cDYzMLEPA/edit?usp=sharing" class="btn waves-effect waves-light gris"><i class="fas fa-file-alt"></i> Ver documento</a>
			</div>
			<div class="col s12 m6">
				<a target="_blank" href="https://docs.google.com/presentation/d/13WLTFuJxLCE0LrN_I6Uq1mwCabbgNZ36UFOUlN_vs4k/edit?usp=sharing" class="btn waves-effect waves-light verde"><i class="fas fa-chalkboard-teacher"></i> Ver presentación</a>
			</div>
		</div>

		<h4>Observaciones</h4>
		<div class="row">
			<div class="col s12 m6">
				<a target="_blank" href="https://docs.google.com/document/d/1-louAPVFZ_TjdvP8a0YPz-0gNBCcraOrCcRyvSEt5pE/edit?usp=sharing" class="btn waves-effect waves-light gris"><i class="fas fa-file-alt"></i> Ver documento</a>
			</div>
			<div class="col s12 m6">
				<a target="_blank" href="https://docs.google.com/presentation/d/16wwLojAGuGpUDX-FIQ0NKAgkm3K_4kpavrBSrqJ6b1g/edit?usp=sharing" class="btn waves-effect waves-light verde"><i class="fas fa-chalkboard-teacher"></i> Ver presentación</a>
			</div>
		</div>


<?php
pageFooter();