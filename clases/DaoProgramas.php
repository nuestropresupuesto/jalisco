<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/Programas.php';

class DaoProgramas extends np_base{

	public function add(Programas $Programas){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO Programas (Clave, Nombre, UnidadResponsable, Version, Monto) VALUES (:Clave, :Nombre, :UnidadResponsable, :Version, :Monto)');
			$stmt->execute([
				':Clave' => $Programas->getVersion(),
				':Nombre' => $Programas->getTipo(),
				':UnidadResponsable' => $Programas->getAnioValores(),
				':Version' => $Programas->getURL(),
				':Monto' => $Programas->getActualizacion()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(Programas $Programas){
		try{
			$stmt = $this->_db->prepare('UPDATE Programas SET Clave=:Clave, Nombre=:Nombre, UnidadResponsable=:UnidadResponsable, Version=:Version, Monto=:Monto WHERE Id=:Id');
			$stmt->execute([
				':Clave' => $Programas->getVersion(),
				':Nombre' => $Programas->getTipo(),
				':UnidadResponsable' => $Programas->getAnioValores(),
				':Version' => $Programas->getURL(),
				':Monto' => $Programas->getActualizacion(),
				':Id' => $Programas->getId()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Id){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM Programas WHERE Id=:Id');
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
	    $query="SELECT * FROM Programas WHERE Id=:Id";
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
	    $query="SELECT * FROM Programas ORDER BY UnidadResponsable,Clave";
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

	public function getByUnidadResponsable($UnidadResponsable,$Version){
	    $resp=array();
	    $query="SELECT * FROM Programas WHERE UnidadResponsable=$UnidadResponsable AND Version=$Version ORDER BY Clave";
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
	   $Programas = new Programas();
	   $Programas->setId($row["Id"]);
	   $Programas->setClave($row["Clave"]);
	   $Programas->setNombre($row["Nombre"]);
	   $Programas->setUnidadResponsable($row["UnidadResponsable"]);
	   $Programas->setVersion($row["Version"]);
	   $Programas->setMonto($row["Monto"]);
	   return $Programas;
	}
}