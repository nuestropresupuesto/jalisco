<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/CapitulosGasto.php';

class DaoCapitulosGasto extends np_base{
	public function add(CapitulosGasto $CapitulosGasto){
		$Id=false;
		try {
			$stmt = $this->_db->prepare('INSERT INTO CapitulosGasto (Clave, Nombre) VALUES (:Clave, :Nombre)');
			$stmt->execute([
			    ':Clave' => $CapitulosGasto->getClave(),
			    ':Nombre' => $CapitulosGasto->getNombre()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
		    throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}

	public function update(CapitulosGasto $CapitulosGasto){
		try {
			$stmt = $this->_db->prepare('UPDATE CapitulosGasto SET Clave=:Clave,Nombre=:Nombre WHERE Id=:Id');
			$stmt->execute([
			    ':Clave' => $CapitulosGasto->getClave(),
			    ':Nombre' => $CapitulosGasto->getNombre(),
			    ':Id' => $CapitulosGasto->getId()
			]);
		} catch (PDOException $e) {
		    throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
		return $CapitulosGasto;
	}

	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM CapitulosGasto WHERE Id=:Id');
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
	    $query="SELECT * FROM CapitulosGasto WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new CapitulosGasto();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM CapitulosGasto";
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
	    $CapitulosGasto = new CapitulosGasto();
	    $CapitulosGasto->setId($row["Id"]);
	    $CapitulosGasto->setClave($row["Clave"]);
	    $CapitulosGasto->setNombre($row["Nombre"]);
	    return $CapitulosGasto;
	}
}