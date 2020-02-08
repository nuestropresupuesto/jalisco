<?php 
require_once('estandares/includes.php');
$title="Convocatorias";
$descripcion="Este proyecto es posible gracias a la participación de muchas personas, quienes ofrecen sus distintas habilidades y recursos para llevarlo a cabo.  En esta página mostramos las convocatorias abiertas para que más personas se sumen al proyecto desde el área en la que se sientan cómodas aportando.";
$thumb="https://www.nuestropresupuesto.mx/imgs/thumb_convocatorias.jpg";
$tags=array();
pageHead($title,$descripcion,$thumb,$tags);
	 ?>
			<h1>Convocatorias</h1>
			<p>Intégrate al equipo que va a hacer posible el ejercicio de <b>#NuestroPresupuesto 2019</b>, actualmente tenemos las siguientes convocatorias abiertas:</p>
			<h4>Coordinaciones</h4>
			<p>La coordinación grupal está conformada por quienes liderarán las <b>cinco Coordinaciones</b> del proyecto: <ol>
				<li>Logística</li>
				<li>Minería de datos</li>
				<li>Comunicación</li>
				<li>Vinculación</li>
				<li>Pedagogía</li>
			</ol>
			Buscamos a quienes encabecen los trabajos de dichas Coordinaciones durante los siguientes 5 meses.  La recepción de perfiles estará abierta hasta el día <b>30 de Agosto</b>. Consulta la convocatoria completa en el siguiente documento:</p>
			<p>
				<a class="btn waves-effect waves-light verde" target="_blank" href="https://docs.google.com/document/d/1vBlWhgpNgHUThKn4nWhJ-3GYhhXKCSg00HS1Nm2lvTU/edit?usp=sharing">Convocatoria Coordinaciones</a>
			</p>
			<h4>Donadores</h4>
			<p>La realización de <b>#NuestroPresupuesto</b> es la suma de 5 meses de ejecución de tareas coordinadas, a pesar de que el ejercicio es abierto y voluntario se necesitan recursos para la producción de los espacios de capacitación, papelería, impresión de informes, etc.  Así mismo se busca que los miembros de la Coordinación Grupal tengan una remuneración simbólica por sus 5 meses de trabajo.</p>
			<p>
				<a class="btn waves-effect waves-light verde" href="https://drive.google.com/open?id=1T_wEhKIDl9GYjq780YQqB-isr6jW7Psy" target="_blank">¡Apúntate como donador!</a>
			</p>

<?php
pageFooter();