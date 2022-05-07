<?php

interface Vehiculo {
    public function mover(int $tiempo);
    public function posicion();
    public function reiniciarPosicion();
}

class Auto implements Vehiculo {
    private $velocidadMaxima = 40;
    private $posicion = 0;

    public function __construct(int $velMax) {
        $this->velocidadMaxima = $velMax;
    }

    public function mover(int $tiempo) {
        $this->posicion += $this->velocidadMaxima * $tiempo;
    }

    public function posicion(){
        return $this->posicion;
    }

    public function reiniciarPosicion(){
        $this->posicion = 0;
    }

}

class Camion implements Vehiculo {
    private $velocidadMaxima = 30;
    private $posicion = 0;

    public function mover(int $tiempo) {
        $this->posicion += $this->velocidadMaxima * $tiempo;
    }

    public function posicion(){
        return $this->posicion;
    }

    public function reiniciarPosicion(){
        $this->posicion = 0;
    }
}

class Bicicleta implements Vehiculo {
    private $velocidadMaxima = 10;
    private $posicion = 0;

    public function mover(int $tiempo) {
        $this->posicion += $this->velocidadMaxima * $tiempo;
    }

    public function posicion(){
        return $this->posicion;
    }

    public function reiniciarPosicion(){
        $this->posicion = 0;
    }
}

class Carrera {
    private $vehiculo1, $vehiculo2;

    public function __construct($vehiculo1, $vehiculo2) {
        $this->vehiculo1 = $vehiculo1;
        $this->vehiculo2 = $vehiculo2;
    }

    public function correr($segundos) {
        $this->vehiculo1->reiniciarPosicion();
        $this->vehiculo2->reiniciarPosicion();
        $this->vehiculo1->mover($segundos);
        $this->vehiculo2->mover($segundos);

        print("La posicion del vehiculo 1 es de {$this->vehiculo1->posicion()} metros.\n");
        print("La posicion del vehiculo 2 es de {$this->vehiculo2->posicion()} metros.\n");

        if ($this->vehiculo1->posicion() > $this->vehiculo2->posicion())
            print("Gana el vehiculo 1!\n");
        elseif ($this->vehiculo1->posicion() < $this->vehiculo2->posicion())
            print("Gana el vehiculo 2!\n");
        else
            print("Es un empate.\n");
    }
}


$fiat = new Auto(45); // El auto se mueve a 45 mts por segundo
$bici = new Bicicleta();
$camion = new Camion();

$carreraGod = new Carrera($fiat, $bici);
$carreraGod->correr(10);

?>