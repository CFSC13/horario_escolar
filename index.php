<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }
  
  th, td {
    text-align: center;
    border: 1px solid black;
    padding: 8px;
  }
  
  th {
    background-color: #ddd;
  }
  
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '0');


// Definir los datos
$asignaturas = array(
    "Sistemas" => 3,
    "Telemática" => 4,
    "Investigacion" => 4,
    "Encuadre" => 3, 
    "matematica" => 4, 
);

$asignaturas_profesores = array(
    "Sistemas" => "Encina",
    "Telemática" => "Enrique",
    "Investigacion" => "Rivero",  
    "Encuadre" => "Encina",
    "matematica" => "Maaria", 
);

$horario_inicio = 8;
$horario_fin = 16;
$horas_maximas_por_dia = 3;

// Inicializar el horario
//Se crea el array que contendra el horario
$horario = array();
for ($dia = 0; $dia < 5; $dia++) {
    for ($hora = $horario_inicio; $hora < $horario_fin; $hora++) {
        $horario[$dia][$hora] = array();
    }
}


// Disponibilidad horaria de los profesores
$profesores_disponibilidad = array(
    "Encina" => array(
        array(),
        array(),
        array(),
        array(8,9,10,11,12,13),
        array(8,9,10,11,12,13)
    ),
    "Enrique" => array(
        array(8,9,10,11,12,13,14),
        array(11, 12, 13),
        array(),
        array(),
        array()
    ),
    "Rivero" => array(
        array(8,9,10,11,12,13,14),
        array(11, 12, 13),
        array(),
        array(8,9,10,11,12,13,14),
        array(11, 12, 13)
    ),
    "Maaria" => array(
        array(8,9,10,11,12,13,14),
        array(11, 12, 13),
        array(),
        array(8,9,10,11,12,13,14),
        array(11, 12, 13)
    ),
     
);


// ASIGNAR HORARIOS con HORAS CONSECUTIVAS
/*foreach ($asignaturas as $asignatura => $horas_semanales) {
    $horas_asignadas = 0;
    while ($horas_asignadas < $horas_semanales) {
        $profesor_disponible = false;
        $dia = 0;
        $hora = 0;
        while (!$profesor_disponible) {
            $dia = rand(0, 4);
            $hora = rand($horario_inicio, $horario_fin - 1);
            $horas_asignadas_dia = 0;
            $horas_consecutivas_disponibles = 0;
            foreach ($horario[$dia] as $horas) {
                if (isset($horas[$asignatura])) {
                    $horas_asignadas_dia++;
                    $horas_consecutivas_disponibles = 0;
                } else {
                    $horas_consecutivas_disponibles++;
                }
                if ($horas_consecutivas_disponibles >= $horas_semanales - $horas_asignadas) {
                    break;
                }
            }
            if ($horas_asignadas_dia < $horas_maximas_por_dia && $horas_consecutivas_disponibles >= $horas_semanales - $horas_asignadas) {
                // Verificar disponibilidad del profesor
                $profesor = $asignaturas_profesores[$asignatura];
                $disponibilidad_profesor = $profesores_disponibilidad[$profesor];
                $horas_consecutivas_disponibles = 0;
                for ($i = $hora; $i < $horario_fin; $i++) {
                    if (isset($horario[$dia][$i][$asignatura])) {
                        $horas_consecutivas_disponibles = 0;
                    } else {
                        $horas_consecutivas_disponibles++;
                    }
                    if ($horas_consecutivas_disponibles >= $horas_semanales - $horas_asignadas) {
                        break;
                    }
                }
                if (!empty($disponibilidad_profesor[$dia]) && in_array($hora, $disponibilidad_profesor[$dia]) && $horas_consecutivas_disponibles >= $horas_semanales - $horas_asignadas) {
                    $profesor_disponible = true;
                }
            }
        }
        // Asignar las clases consecutivas
        for ($i = $hora; $i < $hora + $horas_semanales - $horas_asignadas; $i++) {
            $horario[$dia][$i][$asignatura] = true;
        }
        $horas_asignadas = $horas_semanales;
    }
}
*/


// ASIGNAR HORARIOS SIN HORAS CONSECUTIVAS
// Se recorre el array y se asigan su contenido a las variables clave valor $asignatura => $horas_semanales
foreach ($asignaturas as $asignatura => $horas_semanales) {
    $horas_asignadas = 0;
    while ($horas_asignadas < $horas_semanales) {
        $profesor_disponible = false;
        $dia = 0;
        $hora = 0;
        while (!$profesor_disponible) {
            //Se leige un dia y hora aleatorio
            $dia = rand(0, 4);
            $hora = rand($horario_inicio, $horario_fin - 1);
            $horas_asignadas_dia = 0;
            //Este fragmento de código se utiliza para contar cuántas horas de una asignatura específica se han asignado en un día de la semana específico dentro del array $horario
            //$horario[$dia] se refiere a la hora específica de un día de la semana dentro del array multidimensional $horario
            foreach ($horario[$dia] as $horas) {
                if (isset($horas[$asignatura])) {
                    $horas_asignadas_dia++;
                }
            }
            //Se comprueba si la cantidad de horas asignadas en ese día de la semana para esa asignatura es menor que la cantidad máxima de horas por día para esa asignatura, y si aún no hay ningún profesor asignado a esa hora en el array $horario
            if ($horas_asignadas_dia < $horas_maximas_por_dia && count($horario[$dia][$hora]) == 0) {
                //se obtiene el nombre del profesor que está asignado a esa asignatura en el array $asignaturas_profesores
                $profesor = $asignaturas_profesores[$asignatura];
                //se comprueba si el profesor está disponible en el día de la semana seleccionado utilizando la matriz $profesores_disponibilidad
                $disponibilidad_profesor = $profesores_disponibilidad[$profesor];
                //Si el día de la semana está presente en la matriz $disponibilidad_profesor del profesor y
                // Y la hora específica del día de la semana está presente en el array correspondiente,                
                if (!empty($disponibilidad_profesor[$dia]) && in_array($hora, $disponibilidad_profesor[$dia])) {
                    $profesor_disponible = true;
                }
            }
            
        }
        // Asignar la clase
        $horario[$dia][$hora][$asignatura] = true;
        $horas_asignadas++;
    }
}


// Imprimir el horario
echo "<table>";
echo "<tr><th></th>";
for ($dia = 0; $dia < 5; $dia++) {
    echo "<th>" . obtener_nombre_dia($dia) . "</th>";
}
echo "</tr>";
for ($hora = $horario_inicio; $hora < $horario_fin; $hora++) {
    echo "<tr><th>$hora:00</th>";
    for ($dia = 0; $dia < 5; $dia++) {
        echo "<td>";
        if (!empty($horario[$dia][$hora])) {
           foreach ($horario[$dia][$hora] as $asignatura => $valor) {
        $profesor = $asignaturas_profesores[$asignatura];
    echo "$asignatura ($profesor)<br>";
}
        }
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";


// Función para obtener el nombre del día a partir de su número
function obtener_nombre_dia($num_dia) {
$dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes");
return $dias[$num_dia];
}
?>

                       
