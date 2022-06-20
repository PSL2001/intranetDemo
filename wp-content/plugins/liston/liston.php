<?php
/* Plugin Name: Liston
 * Description: Plugin para mostrar datos de una base de datos
 * Version: 1.1
 * Author: Pablo Sánchez López
 * License: GPL2
 */

//La clase para el widget del liston de telefonos

class listonWidget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

            // Base ID of your widget
            'listonWidget',

            // Widget name will appear in UI
            __('Liston Widget', 'wpb_widget_domain'),

            // Widget description
            array('description' => __('Widget para mostrar los datos', 'wpb_widget_domain'),)
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        //$select = apply_filters('widget_select', $instance['select']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        // if (!empty($select))
        //     echo $args['before_title'] . $select . $args['after_title'];

        // This is where you run the code and display the output
        global $wpdb;
        $tabla = $wpdb->prefix . "liston";

        if (isset($_POST['but_submit'])) {
            $wpdb->query("DELETE FROM $tabla");
            $trabajadores = $wpdb->get_results("SELECT * FROM productividad.trabajador;");
            //var_dump($trabajadores);
            foreach ($trabajadores as $item) {
                $sql = "SELECT id_servicio FROM productividad.trabajadores_servicios WHERE productividad.trabajadores_servicios.nif = %s";
                $servicio = $wpdb->get_results($wpdb->prepare($sql, array($item->nif)));
                //echo $servicio[0]->id_servicio;
                $nomb_sql = "SELECT nombre FROM productividad.servicio WHERE productividad.servicio.id = %d";
                $nombre_serv = $wpdb->get_results($wpdb->prepare($nomb_sql, array($servicio[0]->id_servicio)));
                //var_dump($nombre_serv[0]->nombre);
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
                    $wpdb->query($wpdb->prepare($ins_sql, array($item->nif, $item->apellidos . ", " . $item->nombre, $item->telefono, $null_nomb, $item->email)));
                } else {
                    $wpdb->query($wpdb->prepare($ins_sql, array($item->nif, $item->apellidos . ", " . $item->nombre, $item->telefono, $nombre_serv[0]->nombre, $item->email)));
                }
            }
        }
        if (isset($_POST['orden'])) {
            $orden = $_POST['ordena'];
            $datos = $wpdb->get_results("SELECT * FROM " . $tabla . " ORDER BY $orden asc");
        } else {
            $datos = $wpdb->get_results("SELECT * FROM " . $tabla . " ORDER BY nombre asc");
        }
?>
        <h1>Datos Actuales</h1>
        <form action="" method="post">
            <label for="orden">Ordenar por:</label>
            <select name="ordena" id="orden">
                <option value="nombre" selected>Nombre</option>
                <option value="servicio">Servicio</option>
            </select>
            &nbsp;
            <button type="submit" name="orden">Ordenar</button>
        </form>
        <table width='100%' style='border-collapse: collapse; border:1px solid black;'>
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
    <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['select'])) {
            $select = $instance['select'];
        } else {
            $select = __('New select', 'wpb_widget_domain');
        }
        // Widget admin form
    ?>
        <p>

            <label for=”<?php echo $this->get_field_id("select"); ?>“><?php _e("Select", "wpb_widget_domain"); ?></label>
        </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['select'] = (!empty($new_instance['select'])) ? strip_tags($new_instance['select']) : '';
        return $instance;
    }

    // Class listonWidget ends here
}

// Register and load the widget
function wpb_load_widget()
{
    register_widget('listonWidget');
}
add_action('widgets_init', 'wpb_load_widget');

class prodWidget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

            // Base ID of your widget
            'prodWidget',

            // Widget name will appear in UI
            __('Productividad Widget', 'wpb_widget_domain'),

            // Widget description
            array('description' => __('Widget para mostrar los datos', 'wpb_widget_domain'),)
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        //$select = apply_filters('widget_select', $instance['select']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        // if (!empty($select))
        //     echo $args['before_title'] . $select . $args['after_title'];

        // This is where you run the code and display the output
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
        </form>
        <table width='50%' border="1" style='border-collapse: collapse;'>
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
                if (isset($datos)) {
                    $cuatrimestres_sql = "SELECT id,nombre from productividad.cuatrimestre";
                    $servicios_sql = "SELECT id,nombre from productividad.servicio";
                    $programas_sql = "SELECT id,nombre from productividad.programa";
                    $cuatrimestres = $wpdb->get_results($cuatrimestres_sql);
                    $servicios = $wpdb->get_results($servicios_sql);
                    $programas = $wpdb->get_results($programas_sql);
                ?>
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
                <?php
                } else {
                    echo "<tr><td colspan='10'>Sin Datos a mostrar</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
    <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['select'])) {
            $select = $instance['select'];
        } else {
            $select = __('New select', 'wpb_widget_domain');
        }
        // Widget admin form
    ?>
        <p>

            <label for=”<?php echo $this->get_field_id("select"); ?>“><?php _e("Select", "wpb_widget_domain"); ?></label>
        </p>
<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['select'] = (!empty($new_instance['select'])) ? strip_tags($new_instance['select']) : '';
        return $instance;
    }

    // Class prodWidget ends here
}

// Register and load the widget
function loadWidget()
{
    register_widget('prodWidget');
}
add_action('widgets_init', 'loadWidget');
//Crear la base de datos
function liston_tabla()
{
    global $wpdb;

    $tablename = $wpdb->prefix . "liston";
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    $drop_sql = "DROP TABLE IF EXISTS $tablename";
    dbDelta($drop_sql);

    $sql = "CREATE TABLE $tablename (
        id int AUTO_INCREMENT PRIMARY KEY,
        nif varchar(9) UNIQUE NOT NULL,
        nombre varchar(100) NOT NULL,
        tel varchar(100) DEFAULT(0),
        servicio varchar(100) DEFAULT('Sin Servicio'),
        correo varchar(100) DEFAULT('Sin Correo')
    );";
    dbDelta($sql);
}
register_activation_hook(__FILE__, "liston_tabla");
register_activation_hook(__FILE__, "liston_widget");


//Añadir el menu
function liston_menu()
{
    //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position )
    add_menu_page("Liston", "Liston", "manage_options", "liston", "actualizar", plugins_url('/liston/img/icon.svg'));
    //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function )
    add_submenu_page("liston", "Productividad", "Productividad", "manage_options", "productividad", "productividad");
}
add_action("admin_menu", "liston_menu");

function actualizar()
{
    include "actualizar.php";
}

function productividad()
{
    include "productividad.php";
}


?>