<?php

interface Jugador {
  public function correr(int $minutos);
  public function cansado();
  public function descansar(int $minutos);
}

class Amateur {
  private $minLimite = 20;
  private $minCorridos = 0;
  private $minPorDescansar = 20;
  private $minDescansados = 0;
  private $cansado = false;

  public function correr(int $minutos) {
    if (($this->minCorridos + $minutos) > $this->minLimite) {
      $this->minCorridos = $this->minLimite;
      $this->cansado = true;
      return false;
    }
    else if (($this->minCorridos + $minutos) == $this->minLimite) {
      $this->minCorridos = $this->minLimite;
      $this->cansado = true;
    }
    else
      $this->minCorridos += $minutos;

    return true;
  }

  public function cansado() {
    return $this->cansado;
  }

  public function descansar(int $minutos) {
    $this->minutosDescansados += $minutos;
    if ($this->minDescansados >= $this->minPorDescansar) {
      $this->cansado = false;
      $this->minDescansados = 0;
    }
  }
}

class Profesional {
  private $minLimite = 40;
  private $minCorridos = 0;
  private $minPorDescansar = 25;
  private $minDescansados = 0;
  private $cansado = false;

  public function correr(int $minutos) {
    if (($this->minCorridos + $minutos) > $this->minLimite) {
      $this->minCorridos = $this->minLimite;
      $this->cansado = true;
      return false;
    }
    else if (($this->minCorridos + $minutos) == $this->minLimite) {
      $this->minCorridos = $this->minLimite;
      $this->cansado = true;
    }
    else
      $this->minCorridos += $minutos;

    return true;
  }

  public function cansado() {
    return $this->cansado;
  }

  public function descansar(int $minutos) {
    $this->minutosDescansados += $minutos;
    if ($this->minDescansados >= $this->minPorDescansar) {
      $this->cansado = false;
      $this->minDescansados = 0;
    }
  }
}

$amadeus = new Amateur;
print($amadeus->correr(20));
print($amadeus->cansado());

$prometeus = new Profesional;
print($prometeus->correr(20));
print($prometeus->cansado());

?>