<?php
//La clase para el widget
class ListonWidget extends WP_Widget {
    
    //Constructor
    public function __construct() {
        parent::__construct(
            'ListonWidget', __('Liston Widget', 'text_domain'), 
            array(
                'customize_selective_refresh' => true
            )
        );
    }

    //El formulario (para el backend)
    public function form( $instance ) {
        //Añadimos los campos del formulario en question
        $defaults = array(
            'select' => ''
        );

        //Parseamos las opciones actuales con las por defecto
        extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>
        <?php // Select ?>
	<p>
		<label for="<?php echo $this->get_field_id( 'select' ); ?>"><?php _e( 'Select', 'text_domain' ); ?></label>
		<select name="<?php echo $this->get_field_name( 'select' ); ?>" id="<?php echo $this->get_field_id( 'select' ); ?>" class="widefat">
		<?php
		// Your options array
		$options = array(
			''        => __( 'Select', 'text_domain' ),
			'option_1' => __( 'Option 1', 'text_domain' ),
			'option_2' => __( 'Option 2', 'text_domain' ),
			'option_3' => __( 'Option 3', 'text_domain' ),
		);

		// Loop through options and add each one to the select dropdown
		foreach ( $options as $key => $name ) {
			echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $select, $key, false ) . '>'. $name . '</option>';

		} ?>
		</select>
	</p>

<?php }

    //Para actualizar las opciones del widget
    public function update($nueva_inst, $inst_previa) {
        $instancia = $inst_previa;
        $instancia['select']   = isset( $nueva_inst['select'] ) ? wp_strip_all_tags( $nueva_inst['select'] ) : '';
	    return $instancia;
    }

    //Mostrar el Widget
    public function widget($args, $inst) {
        
        //Extraemos los datos del argumento
        extract($args);
        //Revisamos las opciones
        $select = isset( $inst['select'] ) ? $inst['select'] : '';
        // WordPress core before_widget hook (always include )
	    echo $before_widget;

        //Muestra el widget
        echo '<div class="widget-text wp_widget_plugin_box">';

		// Muestra el campo de select
		if ( $select ) {
			echo '<p>' . $select . '</p>';
		}

	    echo '</div>';

	    // WordPress core after_widget hook (always include )
	    echo $after_widget;
    }
}

//Registrar el Widget
function liston_widget() {
    register_widget("ListonWidget");
} 
addaction('widgets-init', "liston_widget");
