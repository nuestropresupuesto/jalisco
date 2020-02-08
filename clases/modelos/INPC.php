<?php 
class INPC{ 
	public $Anio;
	public $Valor;

	function __construct() {
		$this->Anio = "";
		$this->Valor = "";
	}

    public function getAnio() {
        return $this->Anio;
    }
    public function getValor() {
        return $this->Valor;
    }

    public function setAnio($Anio) {
        $this->Anio=$Anio;
    }
    public function setValor($Valor) {
        $this->Valor=$Valor;
    }

}