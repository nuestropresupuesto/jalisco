<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/ConceptosGenerales.php';

class DaoConceptosGenerales extends np_base{

	public function add(ConceptosGenerales $ConceptosGenerales){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO ConceptosGenerales (Clave,Nombre,CapituloGasto) VALUES (:Clave,:Nombre,:CapituloGasto)');
			$stmt->execute([
				':Clave' => $ConceptosGenerales->getClave(),
				':Nombre' => $ConceptosGenerales->getNombre(),
				':CapituloGasto' => $ConceptosGenerales->getCapituloGasto()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(ConceptosGenerales $ConceptosGenerales){
		try{
			$stmt = $this->_db->prepare('UPDATE ConceptosGenerales SET Clave=:Clave, Nombre=:Nombre, CapituloGasto=:CapituloGasto WHERE Id=:Id');
			$stmt->execute([
				':Clave' => $ConceptosGenerales->getClave(),
				':Nombre' => $ConceptosGenerales->getNombre(),
				':CapituloGasto' => $ConceptosGenerales->getCapituloGasto(),
				':Id' => $ConceptosGenerales->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM ConceptosGenerales WHERE Id=:Id');
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
	    $query="SELECT * FROM ConceptosGenerales WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new ConceptosGenerales();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM ConceptosGenerales";
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
	   $ConceptosGenerales = new ConceptosGenerales();
	   $ConceptosGenerales->setId($row["Id"]);
	   $ConceptosGenerales->setClave($row["Clave"]);
	   $ConceptosGenerales->setNombre($row["Nombre"]);
	   $ConceptosGenerales->setCapituloGasto($row["CapituloGasto"]);
	   return $ConceptosGenerales;
	}

	public function getByCapituloGasto($CapituloGasto){
	    $resp=array();
	    $query="SELECT * FROM ConceptosGenerales WHERE CapituloGasto=:CapituloGasto";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				':CapituloGasto' => $CapituloGasto
			]);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		    	array_push($resp, $this->create_object($row));
    		}
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
		return $resp;
	}
	
	public function getPresupuestoForUnidadResponsable($IdConceptosGenerales,$IdUnidadResponsable,$IdVersion){
	    $query="SELECT SUM(Monto) AS Monto FROM ObjetoDeGasto JOIN PartidasGenericas ON PartidasGenericas.Id=ObjetoDeGasto.PartidaGenerica JOIN ConceptosGenerales ON ConceptosGenerales.Id=PartidasGenericas.ConceptoGeneral WHERE ConceptosGenerales.Id=$IdConceptosGenerales AND UnidadResponsable=$IdUnidadResponsable AND VersionPresupuesto=$IdVersion ";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute();
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return 'false';
	        }else{
	            return $row["Monto"];
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

}