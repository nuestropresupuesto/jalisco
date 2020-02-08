<?php 
require_once('estandares/includes.php');
$title="Planeación 2019";
$descripcion="Se muestran las etapas del proyecto, sus principales tareas y hitos en la comunicación, comparado contra la línea del tiempo del calendario presupuestario.";
$thumb="https://www.nuestropresupuesto.mx/imgs/thumb_planeacion.jpg";
$tags=array();
pageHead($title,$descripcion,$thumb,$tags);
	 ?>
			<h1>Planeación</h1>
			<img src="imgs/journey.svg" style="width: 98vw;margin-left: 50%;transform: translateX(-50%);">
			<p>Puedes conocer el plan completo para la edición de este año en el siguiente documento:</p>
			<p class="center-align">
				<a class="btn waves-effect waves-light verde" href="protocolo">Protocolo 2019</a>
			</p>

<?php
pageFooter();