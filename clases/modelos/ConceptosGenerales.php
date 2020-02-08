<?php 
class ConceptosGenerales{ 
	public $Id;
	public $Clave;
	public $Nombre;
	public $CapituloGasto;

	function __construct() {
		$this->Id = "";
		$this->Clave = "";
		$this->Nombre = "";
		$this->CapituloGasto = "";
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
    public function getCapituloGasto() {
        return $this->CapituloGasto;
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
    public function setCapituloGasto($CapituloGasto) {
        $this->CapituloGasto=$CapituloGasto;
    }

}