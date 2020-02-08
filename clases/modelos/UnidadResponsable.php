<?php 
class UnidadResponsable{ 
	public $Id;
	public $Clave;
	public $Nombre;
	public $UnidadPresupuestal;
	public $Presupuesto;

	function __construct() {
		$this->Id = "";
		$this->Clave = "";
		$this->Nombre = "";
		$this->UnidadPresupuestal = "";
		$this->Presupuesto=0;
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
    public function getUnidadPresupuestal() {
        return $this->UnidadPresupuestal;
    }
    public function getPresupuesto() {
        return $this->Presupuesto;
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
    public function setUnidadPresupuestal($UnidadPresupuestal) {
        $this->UnidadPresupuestal=$UnidadPresupuestal;
    }
    public function setPresupuesto($Presupuesto) {
        $this->Presupuesto=$Presupuesto;
    }

}