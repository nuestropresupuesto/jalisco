<?php
require_once("clases/DaoVersionesPresupuesto.php");
require_once("clases/DaoUnidadPresupuestal.php");
require_once("clases/DaoUnidadResponsable.php");
require_once("clases/DaoCapitulosGasto.php");
require_once("clases/DaoConceptosGenerales.php");
require_once("clases/DaoProgramas.php");
require_once("clases/DaoINPC.php");

$DaoVersionesPresupuesto=new DaoVersionesPresupuesto();
$DaoUnidadPresupuestal=new DaoUnidadPresupuestal();
$DaoUnidadResponsable=new DaoUnidadResponsable();
$DaoCapitulosGasto=new DaoCapitulosGasto();
$DaoConceptosGenerales=new DaoConceptosGenerales();
$DaoProgramas=new DaoProgramas();
$DaoINPC=new DaoINPC();

if(isset($_POST["action"])){
	if($_POST["action"]=="getData"){
		$resp=array();
		$resp["pp"]=array();
		$anios=array();
		if(strlen($_POST["pp"])>0){
			foreach(explode(",", $_POST["pp"]) as $pp){
				$version=$DaoVersionesPresupuesto->show($pp);
				array_push($resp["pp"], $version);
				if(!in_array($version->getAnio(),$anios)){
					array_push($anios, $version->getAnio());
				}
			}
		}
		$resp["INPC"]=array();
		foreach($anios as $anio){
			$resp["INPC"][$anio]=$DaoINPC->show($anio)->getValor();
		}
		if($_POST["level"]=="UR"){
			$resp["UR"]=array();
			foreach($resp["pp"] as $version){
				foreach($DaoUnidadResponsable->show_All() as $UR){
					$ObjUR=array();
					$UR->setNombre(utf8_encode($UR->getNombre()));
					$ObjUR["UR"]=$UR;
					$ObjUR["Monto"]=$DaoUnidadResponsable->getPresupuesto($UR->getId(),$version->getId());
					array_push($resp["UR"], $ObjUR);
				}
			}
		}
		echo(json_encode($resp));
	}
}

if(isset($_GET["format"])){
	if($_GET["format"]=="json" && $_GET["c"]=="UR"){
		$resp=array();
		$resp["UP"]=array();
		$resp["UR"]=array();
		$resp["ConG"]=array();
		
		$UPs=array();
		foreach($DaoUnidadPresupuestal->show_All() as $UP){
			$UPs[$UP->getId()]=$DaoUnidadPresupuestal->fillStr($UP->getClave(),3);
			$resp["UP"][$DaoUnidadPresupuestal->fillStr($UP->getClave(),3)]=$UP->getNombre();
		}
		foreach($DaoUnidadResponsable->show_All() as $UR){
			$resp["UR"][$UPs[$UR->getUnidadPresupuestal()]."-".$DaoUnidadPresupuestal->fillStr($UR->getClave(),3)]=$UR->getNombre();
		}
		foreach($DaoCapitulosGasto->show_All() as $CG){
			$resp["ConG"][$CG->getClave()]=$CG->getNombre();
		}
		foreach($DaoConceptosGenerales->show_All() as $CG){
			$resp["ConG"][$CG->getClave()]=$CG->getNombre();
		}
		echo(json_encode($resp));
	}
	
	
	if($_GET["format"]=="json" && $_GET["t"]=="OGbyUR"){
/*
  {
    "key": "Afghanistan", → [key] → Concepto General
    "region": "Asia", → [UnidadResponsable] Unidad Responsable
    "subregion": "Southern Asia", [CapituloGasto] Capitulo Gasto
    "value": 25500100
  },
	
	*/
		$version=$DaoVersionesPresupuesto->show($_GET["pp"]);
		$resp=array();
		foreach($DaoUnidadPresupuestal->show_All() as $UP){
			foreach($DaoUnidadResponsable->getByUnidadPresupuestal($UP->getId()) as $UR){
				foreach($DaoCapitulosGasto->show_All() as $CG){
					foreach($DaoConceptosGenerales->getByCapituloGasto($CG->getId()) as $CGral){
						$ObjCGral=array();
						$ObjCGral["UnidadResponsable"]=utf8_encode($DaoCapitulosGasto->fillStr($UP->getClave(),3)."-".$DaoCapitulosGasto->fillStr($UR->getClave(),3));
						$ObjCGral["CapituloGasto"]=utf8_encode($CG->getClave());
						$ObjCGral["key"]=utf8_encode($CGral->getNombre());
						$ObjCGral["value"]=round($DaoConceptosGenerales->getPresupuestoForUnidadResponsable($CGral->getId(),$UR->getId(),$version->getId())*1,0);
						if($ObjCGral["value"]>0){
							array_push($resp, $ObjCGral);
						}
					}
				}
			}
		}
		echo(json_encode($resp));
	}

	if($_GET["format"]=="json" && $_GET["t"]=="URbyOG"){
/*
  {
    "key": "Afghanistan", → [key] → Concepto General
    "region": "Asia", → [UnidadResponsable] Capitulo Gasto
    "subregion": "Southern Asia", [CapituloGasto] Unidad Responsable
    "value": 25500100
  },
	
	*/
		$version=$DaoVersionesPresupuesto->show($_GET["pp"]);
		$resp=array();
		foreach($DaoUnidadPresupuestal->show_All() as $UP){
			foreach($DaoUnidadResponsable->getByUnidadPresupuestal($UP->getId()) as $UR){
				foreach($DaoCapitulosGasto->show_All() as $CG){
					foreach($DaoConceptosGenerales->getByCapituloGasto($CG->getId()) as $CGral){
						$ObjCGral=array();
						$ObjCGral["UnidadResponsable"]=utf8_encode($CG->getClave());
						$ObjCGral["CapituloGasto"]=utf8_encode($DaoCapitulosGasto->fillStr($UP->getClave(),3)."-".$DaoCapitulosGasto->fillStr($UR->getClave(),3));
						$ObjCGral["key"]=utf8_encode($CGral->getNombre());
						$ObjCGral["value"]=round($DaoConceptosGenerales->getPresupuestoForUnidadResponsable($CGral->getId(),$UR->getId(),$version->getId())*1,0);
						if($ObjCGral["value"]>0){
							array_push($resp, $ObjCGral);
						}
					}
				}
			}
		}
		echo(json_encode($resp));
	}	
	if($_GET["format"]=="json" && $_GET["t"]=="PPbyUR"){
/*
  {
    "key": "Afghanistan", → [key] → Concepto General
    "region": "Asia", → [UnidadResponsable] Capitulo Gasto
    "subregion": "Southern Asia", [CapituloGasto] Unidad Responsable
    "value": 25500100
  },
	
	*/
		$version=$DaoVersionesPresupuesto->show($_GET["pp"]);
		$resp=array();
		foreach($DaoUnidadPresupuestal->show_All() as $UP){
			foreach($DaoUnidadResponsable->getByUnidadPresupuestal($UP->getId()) as $UR){
				foreach($DaoProgramas->getByUnidadResponsable($UR->getId(),$version->getId()) as $Programa){
					$ObjCGral=array();
					$ObjCGral["UnidadResponsable"]=utf8_encode($DaoCapitulosGasto->fillStr($UP->getClave(),3)."-".$DaoCapitulosGasto->fillStr($UR->getClave(),3));
					$ObjCGral["CapituloGasto"]=utf8_encode($DaoCapitulosGasto->fillStr($Programa->getClave(),2)." ".iconv("WINDOWS-1252", "UTF-8",$Programa->getNombre()));
					$ObjCGral["key"]=utf8_encode("Total");
					$ObjCGral["value"]=round($Programa->getMonto()*1.03,0);
					if($ObjCGral["value"]>0){
						array_push($resp, $ObjCGral);
					}
				}
			}
		}
		echo(json_encode($resp));
	}	

}

/*
  {
    "key": "Afghanistan",
    "region": "Asia",
    "subregion": "Southern Asia",
    "value": 25500100
  },
			*/
		/*
		**********************Sunburst******************
		
		foreach($DaoUnidadPresupuestal->show_All() as $UP){
			$ObjUP=array();
			$ObjUP["name"]=utf8_encode($UP->getNombre());
			$ObjUP["children"]=array();

			foreach($DaoUnidadResponsable->getByUnidadPresupuestal($UP->getId()) as $UR){
				$ObjUR=array();
				$ObjUR["name"]=utf8_encode($UR->getNombre());
				//$Obj["size"]=$DaoUnidadResponsable->getPresupuesto($UR->getId(),$version->getId());
				$ObjUR["children"]=array();
				
				foreach($DaoCapitulosGasto->show_All() as $CG){
					$ObjCG=array();
					$ObjCG["name"]=utf8_encode($CG->getNombre());
					$ObjCG["children"]=array();
					
					foreach($DaoConceptosGenerales->getByCapituloGasto($CG->getId()) as $CGral){
						$ObjCGral=array();
						$ObjCGral["name"]=utf8_encode($CGral->getNombre());
						$ObjCGral["size"]=$DaoConceptosGenerales->getPresupuestoForUnidadResponsable($CGral->getId(),$UR->getId(),$version->getId());
						array_push($ObjCG["children"], $ObjCGral);
					}
					
					array_push($ObjUR["children"], $ObjCG);
				}
				array_push($ObjUP["children"], $ObjUR);
			}

			array_push($resp, $ObjUP);
		}
		
		
		$Obj=$resp;
		$resp=array();
		$resp["name"]="Gobierno de Jalisco ".$version->getAnio().". ".$version->getNombre();
		$resp["children"]=$Obj;
		*/