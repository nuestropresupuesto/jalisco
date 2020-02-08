<?php 
class ObjetoDeGasto{ 
	public $Id;
	public $Clave;
	public $Nombre;
	public $PartidaGenerica;
	public $UnidadResponsable;
	public $VersionPresupuesto;
	public $Monto;

	function __construct() {
		$this->Id = "";
		$this->Clave = "";
		$this->Nombre = "";
		$this->PartidaGenerica = "";
		$this->UnidadResponsable = "";
		$this->VersionPresupuesto = "";
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
    public function getPartidaGenerica() {
        return $this->PartidaGenerica;
    }
    public function getUnidadResponsable() {
        return $this->UnidadResponsable;
    }
    public function getVersionPresupuesto() {
        return $this->VersionPresupuesto;
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
    public function setPartidaGenerica($PartidaGenerica) {
        $this->PartidaGenerica=$PartidaGenerica;
    }
    public function setUnidadResponsable($UnidadResponsable) {
        $this->UnidadResponsable=$UnidadResponsable;
    }
    public function setVersionPresupuesto($VersionPresupuesto) {
        $this->VersionPresupuesto=$VersionPresupuesto;
    }
    public function setMonto($Monto) {
        $this->Monto=$Monto;
    }

}