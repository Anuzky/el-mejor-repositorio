<?php
	class Semaforo {
	  
	  private $tiempo_pasado;
	  private $color;
	  private $intermitente;
	  
	  public function __construct($valor_color) {
	    $this->tiempo_pasado = 0;
	    $this->color = $valor_color;
	    $this->intermitente = False;
	  }
	  
	  private function colorSiguiente() {
	    if ($this->intermitente == False) {
	      switch ($this->color) {
	        case "Rojo":
	          return "Rojo-Amarillo";
	          break;
	        case "Rojo-Amarillo":
	          return "Verde";
	          break;
	        case "Verde":
	          return "Amarillo";
	          break;
	        case "Amarillo":
	          return "Rojo";
	          break;
	      }
	    }
	    
	    switch ($this->color) {
	        case "Apagado":
	          return "Amarillo";
	          break;
	        case "Amarillo":
	          return "Apagado";
	          break;
	      }
	  }
	  
	  public function pasoDelTiempo($tiempo) {
	    $this->tiempo_pasado = $tiempo;
	    if ($this->intermitente == False) {
	      while ($this->tiempo_pasado >= 2) {
	        if ($this->color == "Rojo-Amarillo" || $this->color == "Amarillo") {
	          $this->color = $this->colorSiguiente();
	          $this->tiempo_pasado -= 2;
	          }
	        else if ($this->color == "Rojo"){
	          if ($this->tiempo_pasado >= 30) {
	            $this->color = $this->colorSiguiente();
	            $this->tiempo_pasado -= 30;
	            }
	          else break;
	          }
	        else if ($this->color == "Verde"){
	          if ($this->tiempo_pasado >= 20) {
	            $this->color = $this->colorSiguiente();
	            $this->tiempo_pasado -= 20;
	            }
	          else break;
	          }
	        }
	    }
	  }
	  
	  public function mostrarColor() {
	    return $this->color;
	  }
	  
	  public function ponerEnIntermitente() {
	    $this->intermitente = True;
	  }
	  
	  public function sacarDeIntermitente() {
	    $this->intermitente = False;
	  }
	}
	
	$semaforito = new Semaforo("Rojo");
	print ($semaforito->mostrarColor());
	$semaforito->pasoDelTiempo(32);
	print ($semaforito->mostrarColor());
	
	
?>