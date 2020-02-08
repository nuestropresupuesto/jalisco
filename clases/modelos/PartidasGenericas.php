<?php 
class PartidasGenericas{ 
	public $Id;
	public $Clave;
	public $Nombre;
	public $ConceptoGeneral;

	function __construct() {
		$this->Id = "";
		$this->Clave = "";
		$this->Nombre = "";
		$this->ConceptoGeneral = "";
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
    public function getConceptoGeneral() {
        return $this->ConceptoGeneral;
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
    public function setConceptoGeneral($ConceptoGeneral) {
        $this->ConceptoGeneral=$ConceptoGeneral;
    }

}