<?php 
class CapitulosGasto{ 
	public $Id;
	public $Clave;
	public $Nombre;

	function __construct() {
		$this->Id = "";
		$this->Clave = "";
		$this->Nombre = "";
	}

    public function getId() {
        return $this->Id;
    }
    public function getClave() {
        return $this->Clave;
    }
    public function getNombre() {
        return $this->Nombre;
    }

    public function setId($Id) {
        $this->Id=$Id;
    }
    public function setClave($Clave) {
        $this->Clave=$Clave;
    }
    public function setNombre($Nombre) {
        $this->Nombre=$Nombre;
    }

}