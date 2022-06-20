<?php
global $wpdb;
$tabla = "productividad.productividad";

if (isset($_POST['buscar'])) {
    $error = false;
    $opcion = $_POST['ordena'];
    if ($opcion == "nombre") {
        # Si se esta buscando en nombre, primero tenemos que buscar el nif donde el nombre y apellidos coincidan
        $nombre = trim(mb_strtoupper($_POST['busca']));
        $apellidos = trim(mb_strtoupper($_POST['apellidos']));
        if ($nombre == "" || $apellidos == "") {
            $error = true;
        }
        if (!$error) {
            $sql_nif = "SELECT nif FROM productividad.trabajador WHERE nombre = %s AND apellidos = %s";
            $nif = $wpdb->get_results($wpdb->prepare($sql_nif, [$nombre, $apellidos]));
            foreach ($nif as $item) {
                $sql = "SELECT * FROM $tabla WHERE nif_trabajador = %s";
                $datos = $wpdb->get_results($wpdb->prepare($sql, array($item->nif)));
            }
        }
    } else {
        $nif = trim(strtoupper($_POST['busca']));
        if ($nif == "") {
            $error = true;
        }
        if (!$error) {
            $sql = "SELECT * FROM $tabla WHERE nif_trabajador = %s";
            $datos = $wpdb->get_results($wpdb->prepare($sql, array($nif)));
        }
    }
}

?>
<h1>Mostrar productividad</h1>
<form action="" method="post">
    <label for="busca">Buscar por: </label>
    <select name="ordena" id="orden">
        <option value="nif">NIF</option>
        <option value="nombre">Nombre y Apellidos</option>
    </select>
    &nbsp;
    <input type="text" name="busca" id="busca" placeholder="NIF" required>
    <button type="submit" name="buscar">Buscar</button>
    <?php
    if (isset($datos)) {
        $cuatrimestres_sql = "SELECT id,nombre from productividad.cuatrimestre";
        $servicios_sql = "SELECT id,nombre from productividad.servicio";
        $programas_sql = "SELECT id,nombre from productividad.programa";
        $cuatrimestres = $wpdb->get_results($cuatrimestres_sql);
        $servicios = $wpdb->get_results($servicios_sql);
        $programas = $wpdb->get_results($programas_sql);
    ?>
        <table width='75%' border="1" style='border-collapse: collapse;  margin-left: auto; margin-right: auto;'>
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Programa</th>
                    <th>Servicio a Evaluar</th>
                    <th>Calidad</th>
                    <th>Iniciativa</th>
                    <th>Asistencia</th>
                    <th>Disponibilidad</th>
                    <th>Formacion</th>
                    <th>Días Trabajados</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($datos as $item) {
                    echo "<tr>";
                    foreach ($cuatrimestres as $cuatrimestre) {
                        if ($item->id_periodo == $cuatrimestre->id) {
                            echo "<td>$cuatrimestre->nombre</td>";
                        }
                    }
                    foreach ($programas as $programa) {
                        if ($item->id_programa == $programa->id) {
                            echo "<td>$programa->nombre</td>";
                        }
                    }
                    foreach ($servicios as $servicio) {
                        if ($item->id_servicio_evalua == $servicio->id) {
                            echo "<td>$servicio->nombre</td>";
                        }
                    }
                    echo "<td>$item->puntuacion_calidad</td>";
                    echo "<td>$item->puntuacion_iniciativa</td>";
                    echo "<td>$item->puntuacion_asistencia</td>";
                    echo "<td>$item->puntuacion_disponibilidad</td>";
                    echo "<td>$item->puntuacion_formacion</td>";
                    echo "<td>$item->dias_trabajados</td>";
                    echo "<td>$item->importe</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        <?php
    } else {
        echo "<tr><td colspan='10'>Sin Datos a mostrar</td></tr>";
    }
        ?>
</form>
<script>
    var select = document.getElementById("orden");
    select.addEventListener("change", añadirInput);

    function añadirInput() {
        let select = event.target;
        if (select.value == "nombre") {
            if (document.getElementById("apellidos") != null) {
                let ape = document.getElementById("apellidos");
                ape.parentNode.removeChild(ape);
                let input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("name", "apellidos");
                input.setAttribute("id", "apellidos");
                input.setAttribute("placeholder", "Apellidos");
                document.getElementById("busca").setAttribute("placeholder", "Nombre");
                document.getElementById("busca").parentNode.insertBefore(input, document.getElementById("busca"));
            } else {
                let input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("name", "apellidos");
                input.setAttribute("id", "apellidos");
                input.setAttribute("placeholder", "Apellidos");
                document.getElementById("busca").setAttribute("placeholder", "Nombre");
                document.getElementById("busca").parentNode.insertBefore(input, document.getElementById("busca"));
            }
        } else {
            let ape = document.getElementById("apellidos");
            ape.parentNode.removeChild(ape);
            document.getElementById("busca").setAttribute("placeholder", "NIF");

        }
    }
</script>