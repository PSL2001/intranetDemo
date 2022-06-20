<?php
    $readonly = isset( $field['readonly'] ) && $field['readonly'] == true ? 'readonly' : '';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    $clipboard = isset($field['clipboard']) ? $field['clipboard'] : '';

echo '<div class="betterdocs-settings-input-text">';
echo '<input '.$readonly.' class="'.esc_attr( $class ).'" id="'.$field_id.'" type="text" name="'.$name.'" placeholder="'.$placeholder.'" value="'.esc_attr(stripslashes($value)).'" '.$attrs.'>';
if( $clipboard ) {
    printf('<span id="copy-clipboard"><span>%s</span></span>', esc_html__('Click To Copy!', 'betterdocs'));
}
echo '</div>';
