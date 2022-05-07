<?php

class Semaforo {
  private $color; // Color encendido en las luces del semaforo
  private $contadorTiempo; // Tiempo que ha estado en un mismo color
  private $estaIntermitente = false;

  // El semaforo puede inicializarse con un color en especifico
  public function __construct(string $color) {
    $this->color = $color;
  }

  // mostrarColor: Imprime el color actual del semaforo
  public function mostrarColor() {
    print("$this->color\n");
  }

  public function pasoDelTiempo($segundos) {
    $this->contadorTiempo += $segundos;

    $duracionColor; // La duracion en segundos del color actual
    $proximoColor; // El color que sigue ,al actual, en la secuencia

    /* El semaforo esta en modo intermitente, se ejecuta
    este codigo y se sale de la funcion al terminarse el tiempo dado */
    if ($this->estaIntermitente) {
      while ($this->contadorTiempo) {
        switch($this->color) {
          case "Amarillo":
            $this->color = "Apagado";
            $this->contadorTiempo--;
            $this->mostrarColor();
            break;
          case "Apagado":
            $this->color = "Amarillo";
            $this->contadorTiempo--;
            $this->mostrarColor();
            break;
          default:
            return 1;
          }
        }
      return 0;
      }

    /* En cambio, si el semaforo no esta en modo intermitente,
    se ejecuta el siguiente codigo */
    $puedeCambiar = 1; /* En el tiempo que queda, el color actual
                        puede seguir cambiando? */

    while ($puedeCambiar) {
      switch($this->color) {
        case "Rojo":
          $duracionColor = 30;
          $proximoColor = "Rojo - Amarillo";
          break;
        case "Rojo - Amarillo":
          $duracionColor = 2;
          $proximoColor = "Verde";
          break;
        case "Verde":
          $duracionColor = 20;
          $proximoColor = "Amarillo";
          break;
        case "Amarillo":
          $duracionColor = 2;
          $proximoColor = "Rojo";
          break;
        default:
          return 1;
        }

      /* Si el tiempo dado es igual o supera a la duracion del color actual,
      se cambia el color, este se muestra y se determina el tiempo restante */
      if ($this->contadorTiempo >= $duracionColor) {
        $this->color = $proximoColor;
        $this->contadorTiempo -= $duracionColor;
        $this->mostrarColor();
        }
      else
        $puedeCambiar = 0;
      }

    return 0;
  }

  public function ponerEnIntermitente() {
    $this->estaIntermitente = true;
  }

  public function sacarDeIntermitente() {
    $this->estaIntermitente = false;
  }
}

$semaforito = new Semaforo("Amarillo");
$semaforito->ponerEnIntermitente();
$semaforito->pasoDelTiempo(200);



?>