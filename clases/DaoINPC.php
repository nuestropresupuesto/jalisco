<?php 
require_once 'modelos/np_base.php';
require_once 'modelos/INPC.php';

class DaoINPC extends np_base{

	public function add(INPC $INPC){
		$Id=false;
		try{
			$stmt = $this->_db->prepare('INSERT INTO INPC (Valor) VALUES (:Valor)');
			$stmt->execute([
				':Valor' => $INPC->getValor()
			]);
			$Id=$this->_db->lastInsertId();
		} catch (PDOException $e) {
			throw new Exception("Error al insertar: $query (" . $e->getMessage(). ") ");
		}
		return $Id;
	}
	public function update(INPC $INPC){
		try{
			$stmt = $this->_db->prepare('UPDATE INPC SET Valor=:Valor WHERE Anio=:Anio');
			$stmt->execute([
				':Valor' => $INPC->getValor(),
				':Anio' => $INPC->getAnio()
			]);
		} catch (PDOException $e) {
			throw new Exception("Error al actualizar: $query (" . $e->getMessage(). ") ");
		}
	}
	public function delete($Anio){
		$return=false;
		try {
			$stmt = $this->_db->prepare('DELETE FROM INPC WHERE Anio=:Anio');
			$stmt->execute([
			    ':Anio' => $Anio
			]);
			$return=true;
		} catch (PDOException $e) {
		    throw new Exception("Error al eliminar: $query (" . $e->getMessage(). ") ");
		}
		return $return;
	}

	public function show($Anio){
	    $query="SELECT * FROM INPC WHERE Anio=:Anio";
	    try{
			$stmt = $this->_db->prepare($query);
			$stmt->execute([
				    ':Anio' => $Anio,
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
	    $query="SELECT * FROM INPC ORDER BY Anio DESC";
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
	   $INPC = new INPC();
	   $INPC->setAnio($row["Anio"]);
	   $INPC->setValor($row["Valor"]);
	   return $INPC;
	}
}