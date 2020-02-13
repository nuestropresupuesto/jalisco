<?php 
require_once('estandares/includes.php');
$title="";
$descripcion="#NuestroPresupuesto es un ejercicio que desde el 2016 facilita herramientas a la Sociedad Civil para que realice observaciones sobre omisiones o insuficiencias al Proyecto de Presupuesto del Estado de Jalisco antes de su aprobación por el Congreso del Estado";
$thumb="";
$tags=array();
pageHead($title,$descripcion,$thumb,$tags);
	 ?>
	 <div class="row">
		 <img src="imgs/photo_asamblea.jpg" id="hero">
		 <div class="col s12 verde white-text">
			<h3>Informe final edición 2019</h3>
			<p>Conoce el informe final sobre todo lo acontecido para la observación del Proyecto de Presupuesto 2020.</p>
			<p class="center-align">
				<a href="2019" target="_blank" class="btn waves-effec waves-light gris">¡Ver informe!</a>
			</p>
		 </div>
		 <div class="col s12">
			<h3>¿Qué es?</h3>
			<p><b>#NuestroPresupuesto</b> es un ejercicio que desde hace 4 años facilita herramientas a la Sociedad Civil para que realice observaciones sobre omisiones o insuficiencias al Proyecto de Presupuesto del Estado de Jalisco antes de su aprobación por el Congreso del Estado</p>
			<p class="center-align">
				<img src="imgs/photo_prensa.jpg" class="imagen">
			</p>
		 </div>
	 </div>

<?php
pageFooter();	
