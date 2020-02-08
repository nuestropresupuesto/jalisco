<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/UnidadResponsable.php';

class DaoUnidadResponsable extends np_base{

	public function add(UnidadResponsable $UnidadResponsable){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO UnidadResponsable (Clave,Nombre,UnidadPresupuestal) VALUES (:Clave,:Nombre,:UnidadPresupuestal)');
			$stmt->execute([
				':Clave' => $UnidadResponsable->getClave(),
				':Nombre' => $UnidadResponsable->getNombre(),
				':UnidadPresupuestal' => $UnidadResponsable->getUnidadPresupuestal()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(UnidadResponsable $UnidadResponsable){
		try{
			$stmt = $this->_db->prepare('UPDATE UnidadResponsable SET Clave=:Clave, Nombre=:Nombre, UnidadPresupuestal=:UnidadPresupuestal WHERE Id=:Id');
			$stmt->execute([
				':Clave' => $UnidadResponsable->getClave(),
				':Nombre' => $UnidadResponsable->getNombre(),
				':UnidadPresupuestal' => $UnidadResponsable->getUnidadPresupuestal(),
				':Id' => $UnidadResponsable->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM UnidadResponsable WHERE Id=:Id');
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
	    $query="SELECT * FROM UnidadResponsable WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new UnidadResponsable();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM UnidadResponsable";
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
	   $UnidadResponsable = new UnidadResponsable();
	   $UnidadResponsable->setId($row["Id"]);
	   $UnidadResponsable->setClave($row["Clave"]);
	   $UnidadResponsable->setNombre($row["Nombre"]);
	   $UnidadResponsable->setUnidadPresupuestal($row["UnidadPresupuestal"]);
	   return $UnidadResponsable;
	}

	public function getByUnidadPresupuestal($UnidadPresupuestal){
	    $resp=array();
	    $query="SELECT * FROM UnidadResponsable WHERE UnidadPresupuestal=:UnidadPresupuestal";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':UnidadPresupuestal' => $UnidadPresupuestal
				    ]);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		    	array_push($resp, $this->create_object($row));
    		}
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
		return $resp;
	}

	public function getPresupuesto($IdUnidadResponsable,$IdVersion){
	    $query="SELECT SUM(Monto) AS Monto FROM PartidaVersion JOIN Partidas ON Partidas.Id=PartidaVersion.Partida JOIN UnidadResponsable ON UnidadResponsable.Id=Partidas.UnidadResponsable WHERE UnidadResponsable.Id=:UnidadResponsable AND VersionPresupuesto=:VersionPresupuesto ";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':UnidadResponsable' => $IdUnidadResponsable,
				    ':VersionPresupuesto' => $IdVersion
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return 0;
	        }else{
	            return $row["Monto"];
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}
}