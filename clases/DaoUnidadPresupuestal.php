<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/UnidadPresupuestal.php';

class DaoUnidadPresupuestal extends np_base{

	public function add(UnidadPresupuestal $UnidadPresupuestal){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO UnidadPresupuestal (Clave,Nombre) VALUES (:Clave,:Nombre)');
			$stmt->execute([
				':Clave' => $UnidadPresupuestal->getClave(),
				':Nombre' => $UnidadPresupuestal->getNombre()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(UnidadPresupuestal $UnidadPresupuestal){
		try{
			$stmt = $this->_db->prepare('UPDATE UnidadPresupuestal SET Clave=:Clave, Nombre=:Nombre WHERE Id=:Id');
			$stmt->execute([
				':Clave' => $UnidadPresupuestal->getClave(),
				':Nombre' => $UnidadPresupuestal->getNombre(),
				':Id' => $UnidadPresupuestal->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM UnidadPresupuestal WHERE Id=:Id');
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
	    $query="SELECT * FROM UnidadPresupuestal WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new UnidadPresupuestal();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM UnidadPresupuestal";
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
	   $UnidadPresupuestal = new UnidadPresupuestal();
	   $UnidadPresupuestal->setId($row["Id"]);
	   $UnidadPresupuestal->setClave($row["Clave"]);
	   $UnidadPresupuestal->setNombre($row["Nombre"]);
	   return $UnidadPresupuestal;
	}
}