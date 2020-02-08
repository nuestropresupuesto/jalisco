<?php 
class Visualizaciones{ 
	public $Id;
	public $Version;
	public $Tipo;
	public $AnioValores;
	public $URL;
	public $Actualizacion;

	function __construct() {
		$this->Id = "";
		$this->Version = "";
		$this->Tipo = "";
		$this->AnioValores = "";
		$this->URL = "";
		$this->Actualizacion = "";
	}

    public function getId() {
        return $this->Id;
    }
    public function getVersion() {
        return $this->Version;
    }
    public function getTipo() {
        return $this->Tipo;
    }
    public function getAnioValores() {
        return $this->AnioValores;
    }
    public function getURL() {
        return $this->URL;
    }
    public function getActualizacion() {
        return $this->Actualizacion;
    }

    public function setId($Id) {
        $this->Id=$Id;
    }
    public function setVersion($Version) {
        $this->Version=$Version;
    }
    public function setTipo($Tipo) {
        $this->Tipo=$Tipo;
    }
    public function setAnioValores($AnioValores) {
        $this->AnioValores=$AnioValores;
    }
    public function setURL($URL) {
        $this->URL=$URL;
    }
    public function setActualizacion($Actualizacion) {
        $this->Actualizacion=$Actualizacion;
    }

}