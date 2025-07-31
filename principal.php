<?php
include 'Conexion.php';

session_start();

if (isset($_SESSION['username'])) {
    $idUsuario = $_SESSION['username'];

    $nombreUsuarioQuery = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($nombreUsuarioQuery);
    $stmt->bind_param("s", $idUsuario);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $nombreUsuario = $row["nombre"];
        $rol = $row["rol"]; 
        $stmt->close();
        $conn->close();
    } else {
        echo "No se encontró un usuario con el ID proporcionado.";
    }
} else {
    echo "No se proporcionó un ID de usuario.";
    header("Location: index.html");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora Petravia</title>
    <link rel="icon" href="img/logologin.jpg">
    <link rel="stylesheet" href="css/principal.css" />
</head>

<body>

    <div class="container">
    <img class="logo-login" src="img/logologin.jpg" alt="logo de login" />
        <div class="main">

            <div class="text">

                <h1>Bienvenido <?php echo $nombreUsuario; ?></h1>                
                <h2 class="subtitle">Inició sesión con rol de: <?php echo $rol; ?></h2>
            </div>
        </div>

        <div class="nav">
            <!--    ROLES Y PÁGINAS  -->
        <?php 
        if ($rol == 'Mecanico') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/cuadreadores/cuadreadores_principal.php">Cuadreadores</a>
            <a href="paginas/espadas/espadas_principal.php">Espadas</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/generadores/generadores_principal.php">Generadores</a>
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>

        <?php } ?>

        <?php
        if ($rol == 'Supervisor de mantenimiento') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/cuadreadores/cuadreadores_principal.php">Cuadreadores</a>
            <a href="paginas/espadas/espadas_principal.php">Espadas</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/generadores/generadores_principal.php">Generadores</a>
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>

        <?php } ?>

        <?php
        if ($rol == 'Mantenimiento') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/cuadreadores/cuadreadores_principal.php">Cuadreadores</a>
            <a href="paginas/espadas/espadas_principal.php">Espadas</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/generadores/generadores_principal.php">Generadores</a>
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>

        <?php } ?>
        
        <?php 
        if ($rol == 'Perforista') { ?>

            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>

        <?php } ?>

        <?php
        if ($rol == 'Perforista/Supervisor') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>
        
        <?php } ?>

        <?php
        if ($rol == 'Operador') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>

        <?php } ?>

        <?php
        if ($rol == 'Hilero') { ?>

            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>

        <?php } ?>

        <?php
        if ($rol == 'Hilero 2') { ?>
            
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>

        <?php } ?>

        <?php
        if ($rol == 'Hilero 3') { ?>
            
                <a href="paginas/hilos/hilos_principal.php">Hilos</a>
                <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
                <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
                <a href="paginas/yucles/yucles_principal.php">Yucles</a>

        <?php } ?>

        <?php
        if ($rol == 'Hilero 4') { ?>
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/cuadreadores/cuadreadores_principal.php">Cuadreadores</a>

        <?php } ?>

        <?php
        if ($rol == 'Director') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/cuadreadores/cuadreadores_principal.php">Cuadreadores</a>
            <a href="paginas/espadas/espadas_principal.php">Espadas</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/generadores/generadores_principal.php">Generadores</a>
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>
            
        <?php } ?>


        <?php 
        if ($rol == 'Administrador') { ?>

            <a href="paginas/cargadores/cargadores_principal.php">Cargadores</a>
            <a href="paginas/compresores/compresores_principal.php">Compresores</a>
            <a href="paginas/cuadreadores/cuadreadores_principal.php">Cuadreadores</a>
            <a href="paginas/espadas/espadas_principal.php">Espadas</a>
            <a href="paginas/excavadoras/excavadoras_principal.php">Excavadoras</a>
            <a href="paginas/generadores/generadores_principal.php">Generadores</a>
            <a href="paginas/hilos/hilos_principal.php">Hilos</a>
            <a href="paginas/hilos dazzini/hilos_dazzini_principal.php">Hilos Dazzini</a>
            <a href="paginas/perforadoras/perforadoras_principal.php">Perforadoras</a>
            <a href="paginas/yucles/yucles_principal.php">Yucles</a>

            <br>
            <br>
            <br>
            <a href="paginas/usuarios/usuarios_principal.php">Usuarios</a>
            <a href="paginas/ConsultaGrande/Consulta_principal.php">Consulta</a>
            

        <?php } ?>

        </div>
        
        <a href="index.html" class="btn-actualizar">Cerrar sesión</a>
        
        <div class="final">
            || © 2024 Petravia. Todos los derechos reservados. ||
        </div>
    </div>
</body>

</html>

