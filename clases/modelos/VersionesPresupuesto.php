<?php 
class VersionesPresupuesto{ 
	public $Id;
	public $Anio;
	public $Nombre;
	public $Descripcion;
	public $Fecha;
	public $Organo;

	function __construct() {
		$this->Id = "";
		$this->Anio = "";
		$this->Nombre = "";
		$this->Descripcion = "";
		$this->Fecha = "";
		$this->Organo = "";
	}

    public function getId() {
        return $this->Id;
    }
    public function getAnio() {
        return $this->Anio;
    }
    public function getNombre() {
        return $this->Nombre;
    }
    public function getDescripcion() {
        return $this->Descripcion;
    }
    public function getFecha() {
        return $this->Fecha;
    }
    public function getOrgano() {
        return $this->Organo;
    }

    public function setId($Id) {
        $this->Id=$Id;
    }
    public function setAnio($Anio) {
        $this->Anio=$Anio;
    }
    public function setNombre($Nombre) {
        $this->Nombre=$Nombre;
    }
    public function setDescripcion($Descripcion) {
        $this->Descripcion=$Descripcion;
    }
    public function setFecha($Fecha) {
        $this->Fecha=$Fecha;
    }
    public function setOrgano($Organo) {
        $this->Organo=$Organo;
    }

}