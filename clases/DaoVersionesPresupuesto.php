<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/VersionesPresupuesto.php';

class DaoVersionesPresupuesto extends np_base{

	public function add(VersionesPresupuesto $VersionesPresupuesto){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO VersionesPresupuesto (Anio,Nombre,Descripcion,Fecha,Organo) VALUES (:Anio,:Nombre,:Descripcion,:Fecha,:Organo)');
			$stmt->execute([
				':Anio' => $VersionesPresupuesto->getAnio(),
				':Nombre' => $VersionesPresupuesto->getNombre(),
				':Descripcion' => $VersionesPresupuesto->getDescripcion(),
				':Fecha' => $VersionesPresupuesto->getFecha(),
				':Organo' => $VersionesPresupuesto->getOrgano()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(VersionesPresupuesto $VersionesPresupuesto){
		try{
			$stmt = $this->_db->prepare('UPDATE VersionesPresupuesto SET Anio=:Anio, Nombre=:Nombre, Descripcion=:Descripcion, Fecha=:Fecha, Organo=:Organo WHERE Id=:Id');
			$stmt->execute([
				':Anio' => $VersionesPresupuesto->getAnio(),
				':Nombre' => $VersionesPresupuesto->getNombre(),
				':Descripcion' => $VersionesPresupuesto->getDescripcion(),
				':Fecha' => $VersionesPresupuesto->getFecha(),
				':Organo' => $VersionesPresupuesto->getOrgano(),
				':Id' => $VersionesPresupuesto->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM VersionesPresupuesto WHERE Id=:Id');
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
	    $query="SELECT * FROM VersionesPresupuesto WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new VersionesPresupuesto();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM VersionesPresupuesto";
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
	   $VersionesPresupuesto = new VersionesPresupuesto();
	   $VersionesPresupuesto->setId($row["Id"]);
	   $VersionesPresupuesto->setAnio($row["Anio"]);
	   $VersionesPresupuesto->setNombre($row["Nombre"]);
	   $VersionesPresupuesto->setDescripcion($row["Descripcion"]);
	   $VersionesPresupuesto->setFecha($row["Fecha"]);
	   $VersionesPresupuesto->setOrgano($row["Organo"]);
	   return $VersionesPresupuesto;
	}

	public function getByAnio($Anio){
	    $resp=array();
	    $query="SELECT * FROM VersionesPresupuesto WHERE Anio=$Anio";
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
}