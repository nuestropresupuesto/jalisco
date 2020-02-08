<?php
require_once("clases/DaoVersionesPresupuesto.php");
require_once("clases/DaoVisualizaciones.php");

$DaoVersionesPresupuesto=new DaoVersionesPresupuesto();
$DaoVisualizaciones=new DaoVisualizaciones();

$descripcion="La app de #NuestroPresupuesto es una plataforma se pueden visualizar los presupuestos desde distintas perspectivas: ¿Quién lo gasta?, ¿En qué se gasta?, ¿Cómo se gasta?. La app es un esfuerzo para que la ciudadanía pueda entender mejor la información presupuestal publicada por el Estado.";
$tags=array();
$thumb="https://www.nuestropresupuesto.mx/imgs/thumb_app.jpg";
	?>
<!DOCTYPE html>
<html>
	<head>
        <!-- META -->
        <meta charset="UTF-8">
        <meta name="author" content="GeneraWeb" />
        <meta name="description" content="<?php echo($descripcion); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="<?php echo(implode(",", $tags)); ?>">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

        <!-- SITE TITLE -->
        <title>#NuestroPresupuesto app</title>

		<meta property="og:url" content="https://www.nuestropresupuesto.mx/app" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="#NuestroPresupuesto app" />
		<meta property="og:description" content="<?php echo($descripcion); ?>" />
		<meta property="og:image" content="<?php echo($thumb); ?>" />

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@NtroPresupuesto">
		<meta name="twitter:creator" content="@GeneraWeb">
		<meta name="twitter:title" content="#NuestroPresupuesto app">
		<meta name="twitter:description" content="<?php echo($descripcion); ?>">
		<meta name="twitter:image" content="<?php echo($thumb); ?>">

        <!-- FAVICON -->
        <link rel="icon" href="imgs/favicon.png">
		<link rel="icon" href="imgs/favicon.png" sizes="57x57">
		<link rel="icon" href="imgs/favicon.png" sizes="72x72">
		<link rel="icon" href="imgs/favicon.png" sizes="114x114">
		<link rel="icon" href="imgs/favicon.png" sizes="144x144">


		<link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">
		<!--Import materialize.css-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- STYLE -->
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/app.css">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109234855-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		
		  gtag('config', 'UA-109234855-2');
		</script>

	</head>
	<body>
		<div id="canvas">
			<div class="msg">Iniciando app <i class="fas fa-circle-notch fa-spin"></i></div>
		</div>
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large">
				<img src="imgs/logo.svg">
			</a>
			<ul>
				<li><a class="btn-floating red modal-trigger" data-target="modalGraficos"><i class="fas fa-cog"></i></a></li>
				<li><a class="btn-floating purple modal-trigger" data-target="modalSlack"><i class="fab fa-slack"></i></a></li>
				<li><a class="btn-floating green modal-trigger" data-target="modalExcel"><i class="fas fa-cloud-download-alt"></i></a></li>
				<!--<li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>-->
			</ul>
		</div>		

		<!-- Modal Structure -->
		<div id="modalGraficos" class="modal">
			<div class="modal-content">
				<div class="row">
					<div class="col s12">
						<h4>Selecciona la visualización</h4>
						<table id="versionesPresupuesto">
							<thead>
								<tr>
									<th>Presupuesto</th>
									<th>Visualización</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($DaoVisualizaciones->show_All() as $Visualizacion){ 
									$Version=$DaoVersionesPresupuesto->show($Visualizacion->getVersion());
									$Tipo="";
									if($Visualizacion->getTipo()=="OGbyUP"){
										$Tipo="¿Quién gasta y en qué? <span>Partidas Generales por Unidad Responsable</span>";
									}
									if($Visualizacion->getTipo()=="URbyOG"){
										$Tipo="¿En qué gasta y quién? <span>Por Capítulos de Gasto</span>";
									}
									if($Visualizacion->getTipo()=="PPbyUR"){
										$Tipo="¿Cómo se gasta? <span>Por Programas Presupuestales</span>";
									}
								?>
								<tr data-id="<?php echo($Visualizacion->getId()); ?>" data-url="<?php echo($Visualizacion->getURL()); ?>" data-tipo="<?php echo($Visualizacion->getTipo()); ?>" data-valores="<?php echo($Visualizacion->getAnioValores()); ?>">
									<td class="nombrePresupuesto"><?php echo($Version->getAnio()); ?> : <?php echo($Version->getNombre()); ?></td>
									<td><?php echo($Tipo); ?></td>
									<td><a onclick="goPresupuesto(<?php echo($Visualizacion->getId()); ?>)" href="#v:<?php echo($Visualizacion->getId()); ?>"><i class="fa fa-chevron-circle-right verde-text" aria-hidden="true"></i></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


		<!-- Modal Structure -->
		<div id="modalExcel" class="modal">
			<div class="modal-content">
				<div class="row">
					<div class="col s12">
						<h4>Descarga de archivos</h4>
						<table id="versionesPresupuesto">
							<thead>
								<tr>
									<th>Presupuesto</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Presentación capacitación</td>
									<td><a target="_blank" href="https://docs.google.com/presentation/d/1YcO9OqzswSQktt18SyWV66JRjWN_138p5rrgUVDxdQs/edit?usp=sharing"><i class="fas fa-file-powerpoint"></i></a></td>
								</tr>
								<tr>
									<td>Proyecto 2020</td>
									<td><a href="https://storage.googleapis.com/nuestropresupuesto/Proyecto2020v2020.xlsx" target="_blank"><i class="far fa-file-excel"></i></a></td>
								</tr>
								<tr>
									<td>Matriz de Indicadores para Resultados: Poder ejecutivo</td>
									<td><a href="https://sepbr.jalisco.gob.mx/files/Preciudadano/Proyecto2020/7a%20MIR.a.Sector%20Central.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
								</tr>
								<tr>
									<td>Matriz de Indicadores para Resultados: Poder legislativo, judicial y Organismos Autónomos</td>
									<td><a href="https://sepbr.jalisco.gob.mx/files/Preciudadano/Proyecto2020/8b%20MIR.b.Poderes%20y%20organos%20Autponomos.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
								</tr>
								<tr>
									<td>Matriz de Indicadores para Resultados: OPDs</td>
									<td><a href="https://sepbr.jalisco.gob.mx/files/Preciudadano/Proyecto2020/8c%20MIR.c.OPD%20y%20Fideicomisos.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
								</tr>
								<tr>
									<td>Autorizado 2019 (a montos del 2020)</td>
									<td><a href="https://storage.googleapis.com/nuestropresupuesto/Autorizado2019v2020.xlsx" target="_blank"><i class="far fa-file-excel"></i></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Structure -->
		<div id="modalSlack" class="modal">
			<div class="modal-content">
				<div class="row">
					<div class="col s12">
						<h4><i class="fab fa-slack"></i> Slack</h4>
						<p>Slack es una plataforma o foro donde podemos tener una conversación permanente.</p>
						<p class="center-align"><a class="btn waves-effect waves-light verde" target="_blank" href="https://observatoriosgroup.slack.com/archives/CQ84ZPXR7">Ir al canal</a></p>
						<div class="divider"></div>
						<p>Si aún no tienes tu cuenta de Slack, o no te has unido a nuestro canal puedes hacerlo en el siguiente botón:</p>
						<p class="center-align"><a class="btn waves-effect waves-light gris" target="_blank" href="https://join.slack.com/t/observatoriosgroup/shared_invite/enQtODM0MzAyMTEyOTAyLTlhNDhlOTcxMjNkMzg1MGE4NWZkM2NiMWYwMDM3MWI5ZTBkM2ZiM2RkZDBlZTM4NTA3ZjU5NWU0NTAwYjhlMDk">Unirme a Slack</a></p>
						<p>Si quieres un instructivo paso a paso puedes dar click <a href="https://docs.google.com/presentation/d/1PPV6BEQkFm5Evsiu1OddnEKFOf9a82c-VY0khvcmMoM/edit?usp=sharing" target="_blank">aquí</a></p>
					</div>
				</div>
			</div>
		</div>

		<!--JavaScript at end of body for optimized loading-->
		<script src="js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="https://kit.fontawesome.com/b32a539ef8.js"></script>
		<script src="https://d3js.org/d3.v3.min.js"></script>

		<script src="js/app.js"></script>
	</body>
</html>