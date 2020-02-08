<?php 
class Programas{ 
	public $Id;
	public $Clave;
	public $Nombre;
	public $UnidadResponsable;
	public $Version;
	public $Monto;

	function __construct() {
		$this->Id = "";
		$this->Clave = "";
		$this->Nombre = "";
		$this->UnidadResponsable = "";
		$this->Version = "";
		$this->Monto = "";
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
    public function getUnidadResponsable() {
        return $this->UnidadResponsable;
    }
    public function getVersion() {
        return $this->Version;
    }
    public function getMonto() {
        return $this->Monto;
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
    public function setUnidadResponsable($UnidadResponsable) {
        $this->UnidadResponsable=$UnidadResponsable;
    }
    public function setVersion($Version) {
        $this->Version=$Version;
    }
    public function setMonto($Monto) {
        $this->Monto=$Monto;
    }

}