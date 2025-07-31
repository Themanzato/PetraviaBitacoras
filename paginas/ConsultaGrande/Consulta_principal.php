<?php
require_once('../../TCPDF-main/tcpdf.php'); // Ruta a tu archivo TCPDF
// Inicia la sesión
session_start();
include "../../Conexion.php";

// Configurar la localización en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Consulta a la base de datos para obtener los tipos de máquinas disponibles
$sql_tipos_maquinas = "SELECT DISTINCT tipo_maquina FROM Maquinas;";
$result_tipos_maquinas = $conn->query($sql_tipos_maquinas);

// Verificar si se obtuvieron resultados
if ($result_tipos_maquinas->num_rows > 0) {
    $tipos_maquinas = array();
    // Iterar sobre los resultados y almacenar en un array
    while ($row_tipo_maquina = $result_tipos_maquinas->fetch_assoc()) {
        $tipos_maquinas[] = $row_tipo_maquina["tipo_maquina"];
    }
} else {
    echo "No se encontraron tipos de máquinas en la base de datos";
}

// Meses del año en español
$meses = array(
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
);

// Variables para almacenar los resultados de la consulta para la página
$resultado_html = ''; // Aquí se almacenará el HTML de la tabla de resultados
$mensaje_resultado = ''; // Aquí se almacenará el mensaje en caso de no encontrar resultados
$Turno='';
$alerta = ''; // Variable para almacenar el código JavaScript de la alerta

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha seleccionado un turno
    if (!isset($_POST["turno"])) {
        $alerta = "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, selecciona un turno antes de realizar la consulta.',
                    confirmButtonText: 'Entendido'
                });
              </script>";
    } else {
        // Obtener los valores del formulario
        $mes = $_POST["mes"];
        $tipo_maquina = $_POST["tipo_maquina"];
        $turno = $_POST["turno"];
        $_SESSION['Turno'] = $turno;
        $_SESSION['tipo_maquina'] = $tipo_maquina;
        $_SESSION['mes'] = $mes;

        // SQL base
        $sql_base = "SELECT Nombre_Maquina, Fecha_Reporte, Turno FROM $tipo_maquina WHERE MONTH(Fecha_Reporte) = '$mes'";

        // Verificar el turno seleccionado
        if ($turno == "Todos") {
            $sql_consulta_pagina = $sql_base . " AND Turno IN ('Matutino', 'Vespertino', 'Check');";
        } else {
            $sql_consulta_pagina = $sql_base . " AND Turno = '$turno';";
        }
        $result_consulta_pagina = $conn->query($sql_consulta_pagina);

        // Verificar si se obtuvieron resultados (para la página)
        if ($result_consulta_pagina->num_rows > 0) {
            // Obtener los nombres de las columnas de la tabla (para la página)
            $column_names_pagina = array('Nombre Máquina', 'Fecha', 'Turno');
            // Obtener los datos de las filas de la consulta (para la página)
            $data_rows_pagina = array();
            while ($row_pagina = $result_consulta_pagina->fetch_assoc()) {
                $data_rows_pagina[] = $row_pagina;
            }

            // Construir la tabla de resultados en HTML (para la página)
            $resultado_html .= "<div class='table-responsive'>";
            $resultado_html .= "<table class='table table-bordered'>";
            $resultado_html .= "<thead class='thead-dark'>";
            $resultado_html .= "<tr>";
            foreach ($column_names_pagina as $column_name_pagina) {
                $resultado_html .= "<th>$column_name_pagina</th>";
            }
            $resultado_html .= "</tr>";
            $resultado_html .= "</thead>";
            $resultado_html .= "<tbody>";
            foreach ($data_rows_pagina as $row_pagina) {
                $resultado_html .= "<tr>";
                foreach ($row_pagina as $value_pagina) {
                    $resultado_html .= "<td>$value_pagina</td>";
                }
                $resultado_html .= "</tr>";
            }
            $resultado_html .= "</tbody>";
            $resultado_html .= "</table>";
            $resultado_html .= "</div>";
        } else {
            $alerta = "<script>
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin Resultados',
                        text: 'No se encontraron resultados para el tipo de máquina seleccionado en el mes y turno especificados.',
                        confirmButtonText: 'Entendido'
                    });
                  </script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .white-container {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <form method="post" class="bg-light p-4 rounded" id="consultaForm">
            <div class="form-group">
                <label for="tipo_maquina">Selecciona un tipo de máquina:</label>
                <select class="form-control" name="tipo_maquina" id="tipo_maquina">
                    <option value="">Selecciona un tipo de máquina</option>
                    <?php foreach ($tipos_maquinas as $tipo_maquina) : ?>
                        <option value="<?php echo $tipo_maquina; ?>"><?php echo $tipo_maquina; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="mes">Selecciona un mes:</label>
                <select class="form-control" name="mes" id="mes">
                    <option value="">Selecciona un mes</option>
                    <?php foreach ($meses as $numero_mes => $nombre_mes) : ?>
                        <option value="<?php echo $numero_mes; ?>"><?php echo $nombre_mes; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Turno">Selecciona un turno:</label><br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input type="radio" name="turno" id="turnoMatutino" value="Matutino"> Matutino
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="turno" id="turnoVespertino" value="Vespertino"> Vespertino
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="turno" id="turnoCheck" value="Check"> Check
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="turno" id="turnoTodos" value="Todos"> Todos
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>

        <!-- Aquí se muestra la tabla de resultados o el mensaje de no resultados -->
        <div class="mt-4">
            <?php
            if (!empty($resultado_html)) {
                echo $resultado_html;
            } elseif (!empty($mensaje_resultado)) {
                echo "<div class='alert alert-warning'>$mensaje_resultado</div>";
            }
            ?>
        </div>

        <a href="../../principal.php" class="btn btn-secondary mt-3">Volver</a>
        <a id="downloadPdfBtn" class="btn btn-success mt-3" href="consultarReporteMatutino.php" target="_blank">Descargar Reporte Mensual</a>
    </div>

    <script>
        document.getElementById('consultaForm').addEventListener('submit', function(event) {
            var tipoMaquina = document.getElementById('tipo_maquina').value;
            var mes = document.getElementById('mes').value;
            var turnos = document.getElementsByName('turno');
            var turnoSeleccionado = false;

            for (var i = 0; i < turnos.length; i++) {
                if (turnos[i].checked) {
                    turnoSeleccionado = true;
                    break;
                }
            }

            if (!turnoSeleccionado || tipoMaquina === "" || mes === "") {
                event.preventDefault();
                var mensaje = 'Por favor, selecciona';
                if (tipoMaquina === "") {
                    mensaje += ' un tipo de máquina,';
                }
                if (mes === "") {
                    mensaje += ' un mes,';
                }
                if (!turnoSeleccionado) {
                    mensaje += ' un turno';
                }
                mensaje = mensaje.replace(/,$/, ''); // Elimina la última coma, si existe
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: mensaje + ' antes de realizar la consulta.',
                    confirmButtonText: 'Entendido'
                });
            }
        });

        document.getElementById('downloadPdfBtn').addEventListener('click', function(event) {
            // Verifica si se realizó una consulta
            var consultaRealizada = <?php echo isset($_POST["mes"]) && isset($_POST["tipo_maquina"]) && isset($_POST["turno"]) ? 'true' : 'false'; ?>;

            if (!consultaRealizada) {
                event.preventDefault(); // Previene la acción por defecto del enlace
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, realiza una consulta antes de descargar el PDF.',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    </script>

    <?php
    // Incluir la alerta si existe
    if (!empty($alerta)) {
        echo $alerta;
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
