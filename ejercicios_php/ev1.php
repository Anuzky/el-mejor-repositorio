<?php

/*
  Evaluación 1 AAT
  
  Nombre: Ana Marina Caballero
  
  1. Escribir una nueva clase Juego, que tenga dos métodos. jugar y practicar.
  El método jugar acepta 3 parámetros: un Tablero, y un Jugador y la cantidad
  de Intentos que tiene el jugador para adivinar. Si el jugador adivina la
  palabra antes de la cantidad de intentos especificados, debe devolver. El
  jugador gano el juego, la palabra secreta era... y mostrar la palabra
  secreta. En caso de que los intentos no alcancen, se debe indicar, el jugador
  perdió, y mostrar de todas formas cual era la palabra secreta. El método
  practicar acepta solo dos parámetros, el tablero, y el jugador, y permite que
  el jugador intente hasta que adivine, sin importar cuantos intentos le lleve.
  Reescribir todo el código del recuadrado de arriba para que use esta nueva
  clase. Considerar que ambos métodos pueden llamarse muchas veces para jugar
  o practicar con diferentes palabras en cada llamado.

  2. Diseñar una clase JugadorAvanzado que juegue mejor que el jugador
  intermedio. *Pista, el jugador intermedio puede sugerir varias veces la misma
  letra aun sabiendo que no esta en la palabra secreta.

  3. Para que el ejercicio
  1 funcione, es necesario crear una interfaz o varias interfaces, codificar
  dicha/s interfaz/ces en indicar como quedarían las declaraciones de las clases
  que adhieren a éstas.
 */

class Ahorcado {
  protected $palabrasDisponibles;
  protected $palabraSecreta;
  protected $letrasAdivinadas = [];

  public function __construct() {
    $this->palabrasDisponibles = ['avestruz', 'horario', 'elefante', 'sopa'];
    $this->elegirNuevaPalabra();
  }

  protected function elegirNuevaPalabra() {
    $this->letrasAdivinadas = [];
    shuffle($this->palabrasDisponibles); // shuffle mezcla una lista.
    $this->palabraSecreta = $this->palabrasDisponibles[0];
  } // y elegimos la primera palabra de la lista como la palabra secreta.

  public function mostrarTablero() : string {
    $tablero = ''; // strlen cuenta la cantidad de caracteres de un string.
    for ($x = 0; $x < strlen($this->palabraSecreta); $x++) {
      $letra = $this->palabraSecreta[$x];
      if (in_array($letra, $this->letrasAdivinadas)) {
        $tablero = $tablero . " $letra"; // el punto concatena cadenas.
      }
      else {
        $tablero = $tablero . ' _';
      }
    }
    return $tablero; // Esto genera un tablero asi: e _ e f _ n t e
  }

  public function palabraAdivinada() : bool {
    return substr_count($this->mostrarTablero(), '_') == 0;
  } // substr_count() cuenta subcadenas en una cadena mÃ¡s larga.

  public function intentarLetra(string $letra) : bool {
    if (strlen($letra) > 1) {
      throw Exception('Solo se aceptan letras, no palabras.');
    }
    $acierto = substr_count($this->palabraSecreta, $letra) != 0;
    if ($acierto) {
      $this->letrasAdivinadas[] = $letra; // agrega un nuevo elemento a una lista.
    }
    return $acierto;
  }
}


interface Jugador {
  public function sugerirLetra(string $tablero) : string;
  public function finDelJuego(); /* Avisa al jugador que terminó el juego, por
                                  si es necesario realizar alguna acción */
}

class JugadorPrincipiante implements Jugador {

  public function sugerirLetra(string $tablero) : string {
    $letras = range('a', 'z'); // Genera: ['a', 'b', 'c', 'd', 'e', ..., 'x', 'y', 'z']
    shuffle($letras);
    return $letras[0];
  }

  public function finDelJuego() {
    // no hay variables para olvidar :(
  }
}

class JugadorIntermedio implements Jugador {

  public function sugerirLetra(string $tablero) : string {
    $letras = range('a', 'z');
    do {
      shuffle($letras);
      $letra_elegida = $letras[0];
    } while ($this->letraYaAdivinada($letra_elegida, $tablero));
    return $letra_elegida;
  }

  protected function letraYaAdivinada(string $letra, string $tablero) : bool {
    return substr_count($tablero, $letra) > 0;
  }

  public function finDelJuego() {
    // no hay variables para olvidar :(
  }
}

class JugadorAvanzado implements Jugador {
  
  protected $letrasUsadas = [];

  public function sugerirLetra(string $tablero) : string {
    $letras = range('a', 'z');
    do {
      shuffle($letras);
      $letra_elegida = $letras[0];
    } while ($this->letraYaUsada($letra_elegida));
    return $letra_elegida;
  }

  /* letraYaUsada: por cada letra que se va sugiriendo, esta se guarda
  en una lista para luego no sugerirla de nuevo */
  protected function letraYaUsada(string $letra) : bool {
    if (in_array($letra, $this->letrasUsadas) == FALSE){
      $this->letrasUsadas[] = $letra;
      return FALSE; 
    }
    return TRUE;
  }

  /* finDelJuego: vacia la lista de letras usadas */
  public function finDelJuego() {
    $this->letrasUsadas = [];
  }
}


class Juego {
  
  public function jugar(Ahorcado $juego, Jugador $jugador, int $intentos) {
    $juego = new Ahorcado;
    $i = 0;
    echo "AHORCADO \n\n";
    echo $juego->mostrarTablero() . "\n\n";

    do {
      $tablero = $juego->mostrarTablero();
      $letra = $jugador->sugerirLetra($tablero);
      echo "Se ingreso $letra\n";
      $juego->intentarLetra($letra);
      echo $juego->mostrarTablero() . "\n\n";
      $i++;

    } while ($juego->palabraAdivinada() == FALSE && $i < $intentos);


    if ($juego->palabraAdivinada()) {
      echo "Luego de $i intentos... Termino el juego.\n\n";
      echo "La palabra secreta era: " . $juego->mostrarTablero() . "\n";
    }
    else {
      // Para terminar de revelar la palabra secreta en el resultado:
      do {
        $tablero = $juego->mostrarTablero() . "\n\n";
        $letra = $jugador->sugerirLetra($tablero);
        $juego->intentarLetra($letra);
      } while ($juego->palabraAdivinada() == FALSE);

      echo "El jugador se quedo sin intentos.\n\n";
      echo "La palabra secreta era: " . $juego->mostrarTablero() . "\n\n";

      $jugador->finDelJuego();

    }
  }

  public function practicar(Ahorcado $juego, Jugador $jugador) {
    $juego = new Ahorcado;
    $i = 0;
    echo "AHORCADO \n\n";
    echo $juego->mostrarTablero() . "\n\n";
    do {
        $tablero = $juego->mostrarTablero();
        $letra = $jugador->sugerirLetra($tablero);
        echo "Se ingreso $letra\n";
        $juego->intentarLetra($letra);
        echo $juego->mostrarTablero() . "\n\n";
        $i++;
      } while ($juego->palabraAdivinada() == FALSE);

      echo "Luego de $i intentos... Termino el juego.\n\n";
      echo "La palabra secreta era: " . $juego->mostrarTablero() . "\n\n";

      $jugador->finDelJuego();
  }
}

$pepe = new JugadorAvanzado;
$tablet = new Ahorcado;
$juego = new Juego;

$juego->jugar($tablet,$pepe,20)

?>