<?php 
require_once 'modelos/cloud_base.php';
require_once 'modelos/PartidasGenericas.php';

class DaoPartidasGenericas extends cloud_base{

	public function add(PartidasGenericas $PartidasGenericas){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO PartidasGenericas (Clave,Nombre,ConceptoGeneral) VALUES (:Clave,:Nombre,:ConceptoGeneral)');
			$stmt->execute([
				':Clave' => $PartidasGenericas->getClave(),
				':Nombre' => $PartidasGenericas->getNombre(),
				':ConceptoGeneral' => $PartidasGenericas->getConceptoGeneral()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(PartidasGenericas $PartidasGenericas){
		try{
			$stmt = $this->_db->prepare('UPDATE PartidasGenericas SET Clave=:Clave, Nombre=:Nombre, ConceptoGeneral=:ConceptoGeneral WHERE Id=:Id');
			$stmt->execute([
				':Clave' => $PartidasGenericas->getClave(),
				':Nombre' => $PartidasGenericas->getNombre(),
				':ConceptoGeneral' => $PartidasGenericas->getConceptoGeneral(),
				':Id' => $PartidasGenericas->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM PartidasGenericas WHERE Id=:Id');
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
	    $query="SELECT * FROM PartidasGenericas WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new PartidasGenericas();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM PartidasGenericas";
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
	   $PartidasGenericas = new PartidasGenericas();
	   $PartidasGenericas->setId($row["Id"]);
	   $PartidasGenericas->setClave($row["Clave"]);
	   $PartidasGenericas->setNombre($row["Nombre"]);
	   $PartidasGenericas->setConceptoGeneral($row["ConceptoGeneral"]);
	   return $PartidasGenericas;
	}
}