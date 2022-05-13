<?php

class Cronometro {
  private $segundos = 0;
  private $minutos = 0;
  private $horas = 0;

  // reiniciar: setea el cronometro a 0
  public function reiniciar() {
    $this->segundos = 0;
    $this->minutos = 0;
    $this->horas = 0;
  }

  /* incrementarTiempo: aumenta el tiempo del cronometro de a
  un segundo, ajustando los minutos y horas cuando corresponde. */
  public function incrementarTiempo() {
      $this->segundos++;
    if ($this->segundos == 60) {
      $this->segundos = 0;
      $this->minutos++;
    }
    if ($this->minutos == 60) {
      $this->minutos = 0;
      $this->horas++;
    }
  }

  // mostrarTiempo: muestra el tiempo pasado en un formato legible.
  public function mostrarTiempo() {
    if ($this->horas > 0) {
      if ($this->horas == 1)
        print("1 hora");
      else
        print("$this->horas horas");
      if ($this->minutos > 0 || $this->segundos > 0)
        print(", ");
      }

    if ($this->minutos > 0) {
      if ($this->minutos == 1)
        print("1 minuto");
      else
        print("$this->minutos minutos");
      if ($this->segundos > 0)
        print(", ");
      }

    if ($this->segundos > 0) {
      if ($this->segundos == 1)
        print("1 segundo.");
      else
        print("$this->segundos segundos.");
      }

  }

}

$cronometrito = new Cronometro;

for ($i=0; $i < 4981; $i++) {
  $cronometrito->incrementarTiempo(1);
  }
print $cronometrito->mostrarTiempo();


?>