<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/Visualizaciones.php';

class DaoVisualizaciones extends np_base{

	public function add(Visualizaciones $Visualizaciones){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO Visualizaciones (Version, Tipo, AnioValores, URL, Actualizacion) VALUES (:Version, :Tipo, :AnioValores, :URL, :Actualizacion)');
			$stmt->execute([
				':Version' => $Visualizaciones->getVersion(),
				':Tipo' => $Visualizaciones->getTipo(),
				':AnioValores' => $Visualizaciones->getAnioValores(),
				':URL' => $Visualizaciones->getURL(),
				':Actualizacion' => $Visualizaciones->getActualizacion()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(Visualizaciones $Visualizaciones){
		try{
			$stmt = $this->_db->prepare('UPDATE Visualizaciones SET Version=:Version, Tipo=:Tipo, AnioValores=:AnioValores, URL=:URL, Actualizacion=:Actualizacion WHERE Id=:Id');
			$stmt->execute([
				':Version' => $Visualizaciones->getVersion(),
				':Tipo' => $Visualizaciones->getTipo(),
				':AnioValores' => $Visualizaciones->getAnioValores(),
				':URL' => $Visualizaciones->getURL(),
				':Actualizacion' => $Visualizaciones->getActualizacion(),
				':Id' => $Visualizaciones->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM Visualizaciones WHERE Id=:Id');
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
	    $query="SELECT * FROM Visualizaciones WHERE Id=:Id";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Id' => $Id,
				    ]);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    if(!$row){
			    return new INPC();
	        }else{
	            return $this->create_object($row);
	        }
	    }catch (PDOException $e) {
            throw new Exception("Error en consulta: (" . $e->getMessage() . ")  Query: $query");
		}
	}

	public function show_All(){
	    $resp=array();
	    $query="SELECT * FROM Visualizaciones ORDER BY Version DESC, Tipo";
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
	   $Visualizaciones = new Visualizaciones();
	   $Visualizaciones->setId($row["Id"]);
	   $Visualizaciones->setVersion($row["Version"]);
	   $Visualizaciones->setTipo($row["Tipo"]);
	   $Visualizaciones->setAnioValores($row["AnioValores"]);
	   $Visualizaciones->setURL($row["URL"]);
	   $Visualizaciones->setActualizacion($row["Actualizacion"]);
	   return $Visualizaciones;
	}
}