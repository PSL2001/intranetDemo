<?php
global $wpdb;
$tabla = $wpdb->prefix."liston";

//Conectar con la base de datos y actualizar los datos del liston
if (isset($_POST['but_submit'])) {
    //Borramos los datos de la tabla
    $wpdb->query("DELETE FROM $tabla");
    //Cojemos a todos los trabajadores
    $trabajadores = $wpdb->get_results("SELECT * FROM productividad.trabajador;");
    //var_dump($trabajadores);
    foreach ($trabajadores as $item) {
        //Para cada trabajador guardamos su id de servicio (Esto mostrara error si el trabajador no tiene servicio)
        $sql = "SELECT id_servicio FROM productividad.trabajadores_servicios WHERE productividad.trabajadores_servicios.nif = %s";
        $servicio = $wpdb->get_results($wpdb->prepare($sql, array($item->nif)));
        //echo $servicio[0]->id_servicio;
        //Como queremos mostrar el nombre del servicio y no la id, lo buscamos segun la id (Tambien mostrara error si no encuentra la id en el query anterior)
        $nomb_sql = "SELECT nombre FROM productividad.servicio WHERE productividad.servicio.id = %d";
        $nombre_serv = $wpdb->get_results($wpdb->prepare($nomb_sql, array($servicio[0]->id_servicio)));
        //var_dump($nombre_serv[0]->nombre);
        //Ahora insertamos todos los datos en la tabla, hay que revisar para cada caso si tienen telefono, servicio o correo electronico (Los que esten sin servicio se mostraran en rojo en la tabla)
        $ins_sql = "INSERT INTO $tabla (nif, nombre, tel ,servicio, correo) VALUES (%s, %s, %d, %s, %s)";
        if ($item->telefono == NULL) {
            $item->telefono = 0;
        }
        if ($nombre_serv[0]->nombre == "" || $nombre_serv[0]->nombre == NULL) {
            $null_nomb = "Sin Servicio";
        }
        if ($item->email == "" || $item->email == NULL) {
            $item->email = "Sin Correo";
        }
        if (isset($null_nomb)) {
            $wpdb->query($wpdb->prepare($ins_sql, array($item->nif, $item->apellidos.", ".$item->nombre, $item->telefono, $null_nomb, $item->email)));
        } else {
            $wpdb->query($wpdb->prepare($ins_sql, array($item->nif, $item->apellidos.", ".$item->nombre, $item->telefono, $nombre_serv[0]->nombre, $item->email)));
        }
    }
}
if (isset($_POST['orden'])) {
    $orden = $_POST['ordena'];
    $datos = $wpdb->get_results("SELECT * FROM ". $tabla. " ORDER BY $orden asc");
} else {
    $datos = $wpdb->get_results("SELECT * FROM ". $tabla. " ORDER BY nombre asc");
}
?>
<h1>Datos Actuales</h1>
<form action="" method="post">
    <button type="submit" name="but_submit">Actualizar</button>
    &nbsp;
    <label for="orden">Ordenar por:</label>
    <select name="ordena" id="orden">
        <option value="nombre" selected>Nombre</option>
        <option value="servicio">Servicio</option>
    </select>
    &nbsp;
    <button type="submit" name="orden">Ordenar</button>
</form>
<table width='100%' border='1' style='border-collapse: collapse;'>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Servicio</th>
            <th>Correo Electrónico</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($datos) > 0) {
            if (isset($_POST['ordena']) && $_POST['ordena'] == "servicio") {
                $servicios = $wpdb->get_results("SELECT nombre FROM productividad.servicio");
                foreach ($servicios as $servicio) {
                    //$servicio->nombre
                    $trabajadores = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tabla WHERE servicio = %s", array($servicio->nombre)));
                    echo "<tr><td colspan='5' align='center' style='background-color:cadetblue;'><b>$servicio->nombre</b></td></tr>";
                    foreach ($trabajadores as $item) {
                        echo "<tr>
                        <td>$item->nombre</td>
                        <td>$item->tel</td>
                        <td>$item->servicio</td>
                        <td>$item->correo</td>
                        </tr>";
                    }
                }
            } else {
                foreach ($datos as $item) {
                    if ($item->servicio == "Sin Servicio") {
                        echo "<tr>
                        <td style='background-color:red;'>$item->nombre</td>
                        <td style='background-color:red;'>$item->tel</td>
                        <td style='background-color:red;'>$item->servicio</td>
                        <td style='background-color:red;'>$item->correo</td>
                        </tr>";
                    } else {
                        echo "<tr>
                        <td>$item->nombre</td>
                        <td>$item->tel</td>
                        <td>$item->servicio</td>
                        <td>$item->correo</td>
                        </tr>";
                    }
                }
            }
        } else {
            echo "<tr><td colspan='5'>Sin Datos a mostrar</td></tr>";
        }
        ?>
    </tbody>
</table>