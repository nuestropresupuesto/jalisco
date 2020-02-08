<?php 
require_once 'modelos/cloud_base.php';
require_once 'modelos/ObjetoDeGasto.php';

class DaoObjetoDeGasto extends cloud_base{

	public function add(ObjetoDeGasto $ObjetoDeGasto){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO ObjetoDeGasto (Clave,Nombre,PartidaGenerica,UnidadResponsable,VersionPresupuesto,Monto) VALUES (:Clave,:Nombre,:PartidaGenerica,:UnidadResponsable,:VersionPresupuesto,:Monto)');
			$stmt->execute([
				':Clave' => $ObjetoDeGasto->getClave(),
				':Nombre' => $ObjetoDeGasto->getNombre(),
				':PartidaGenerica' => $ObjetoDeGasto->getPartidaGenerica(),
				':UnidadResponsable' => $ObjetoDeGasto->getUnidadResponsable(),
				':VersionPresupuesto' => $ObjetoDeGasto->getVersionPresupuesto(),
				':Monto' => $ObjetoDeGasto->getMonto()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(ObjetoDeGasto $ObjetoDeGasto){
		try{
			$stmt = $this->_db->prepare('UPDATE ObjetoDeGasto SET Clave=:Clave, Nombre=:Nombre, PartidaGenerica=:PartidaGenerica, UnidadResponsable=:UnidadResponsable,VersionPresupuesto=:VersionPresupuesto,Monto=:Monto WHERE Id=:Id');
			$stmt->execute([
				':Clave' => $ObjetoDeGasto->getClave(),
				':Nombre' => $ObjetoDeGasto->getNombre(),
				':PartidaGenerica' => $ObjetoDeGasto->getPartidaGenerica(),
				':UnidadResponsable' => $ObjetoDeGasto->getUnidadResponsable(),
				':VersionPresupuesto' => $ObjetoDeGasto->getVersionPresupuesto(),
				':Monto' => $ObjetoDeGasto->getMonto(),
				':Id' => $ObjetoDeGasto->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM ObjetoDeGasto WHERE Id=:Id');
			$stmt->execute([
			    ':Id' => $Id
			]);
			$return=true;
		} catch (PDOException $e) {
		    throw new Exception("Error al eliminar: $query (" . $e->getMessage(). ") ");
		}
		return $return;
	}

	public function show($Id){
	    $query="SELECT * FROM ObjetoDeGasto WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new ObjetoDeGasto();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM ObjetoDeGasto";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		    	array_push($resp, $this->create_object($row));
    		}
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
		return $resp;
	}

	public function advanced_query($query){
	    $resp=array();
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		    	array_push($resp, $this->create_object($row));
    		}
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
		return $resp;
	}
	public function create_object($row){
	   $ObjetoDeGasto = new ObjetoDeGasto();
	   $ObjetoDeGasto->setId($row["Id"]);
	   $ObjetoDeGasto->setClave($row["Clave"]);
	   $ObjetoDeGasto->setNombre($row["Nombre"]);
	   $ObjetoDeGasto->setPartidaGenerica($row["PartidaGenerica"]);
	   $ObjetoDeGasto->setUnidadResponsable($row["UnidadResponsable"]);
	   $ObjetoDeGasto->setVersionPresupuesto($row["VersionPresupuesto"]);
	   $ObjetoDeGasto->setMonto($row["Monto"]);
	   return $ObjetoDeGasto;
	}
}