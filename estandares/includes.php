<?php
$file_script=$_SERVER['SCRIPT_FILENAME'];
$file_script=substr($file_script,0, strpos($file_script,".php"));
while(strpos($file_script,"/")!== false){
	$file_script=substr($file_script, strpos($file_script,"/")+1);
}


function pageHead($title="",$descripcion="",$thumb="",$tags=array()){
	global $file_script;
	if($title!==""){
		$title=" | ".$title;
	}
	$url="";
	if($file_script!=="index"){
		$url=$file_script;
	}
	if($thumb==""){
		$thumb="https://www.nuestropresupuesto.mx/imgs/thumb_inicio.jpg";
	}
	?><!DOCTYPE html>
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
        <title>#NuestroPresupuesto<?php echo($title); ?></title>

		<meta property="og:url" content="https://www.nuestropresupuesto.mx/<?php echo($url); ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="#NuestroPresupuesto<?php echo($title); ?>" />
		<meta property="og:description" content="<?php echo($descripcion); ?>" />
		<meta property="og:image" content="<?php echo($thumb); ?>" />

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@NtroPresupuesto">
		<meta name="twitter:creator" content="@GeneraWeb">
		<meta name="twitter:title" content="#NuestroPresupuesto<?php echo($title); ?>">
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
        <?php if(file_exists("css/$file_script.css")){ ?>
        <link rel="stylesheet" href="css/<?php echo($file_script); ?>.css">
		<?php } ?>
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
		<nav class="verde">
			<a href="/"><div class="logoContainer"><img src="imgs/logo.svg" id="logo"></div></a>
			<div class="nav-wrapper">
				<ul class="right hide-on-med-and-down">
					<li><a href="/app"><i class="fas fa-chart-pie"></i> App</a></li>
					<li><a href="/protocolo"><i class="fas fa-file-invoice"></i> Protocolo 2019</a></li>
					<li><a href="/planeacion"><i class="fas fa-tasks"></i> Planeación</a></li>
				</ul>
				<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="fas fa-bars"></i></a>
			</div>

		</nav>

		<ul id="slide-out" class="sidenav">
			<li><a href="/"><i class="fas fa-home"></i> Inicio</a></li>
			<li><a href="/convocatorias"><i class="fas fa-hand-paper"></i> Convocatorias</a></li>
			<li><a href="/protocolo"><i class="fas fa-file-invoice"></i> Protocolo 2019</a></li>
			<li><a href="/planeacion"><i class="fas fa-tasks"></i> Planeación</a></li>
		</ul>
		<div class="container white">
<?php	
}

function pageFooter(){
	?>
			<div class="footer">
				
			</div>
		</div>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col s12 m6">
						<i class="far fa-envelope"></i> <a href="mailto:hola@nuestropresupuesto.mx">hola@nuestropresupuesto.mx</a><br/><br/>
						<i class="fab fa-twitter"></i> <a href="https://twitter.com/NtroPresupuesto" target="_blank">@NtroPresupuesto</a><br/><br/>
						<i class="fab fa-facebook-f"></i> <a href="https://fb.com/NtroPresupuesto" target="_blank">fb.com/NtroPresupuesto</a>
					</div>
					<div class="col s12 m6 right-align">
						<p>Proyecto impulsado por el <a href="http://www.observatorios.org" target="_blank">Observatorio Permanente del Sistema Estatal Anticorrupción</a>.</p>		
						<p><a target="_blank" href="transparencia"><i class="fas fa-file-invoice-dollar"></i> Transparencia</a></p>				
					</div>
				</div>
			</div>
		</footer>
		<!--JavaScript at end of body for optimized loading-->
		<script src="js/scripts.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="https://kit.fontawesome.com/b32a539ef8.js"></script>
	</body>
</html><?php
}