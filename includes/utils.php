<?php
/**
 * @package           wordpress
 * @subpackage        special-offer
 * @author            Ivan Nozhka <ivan.nozhko@gmail.com>
 * @since             1.0.0
 */

if(!defined('ABSPATH')){
    exit;
}


/**
 * Update postmeta
 *
 * @param $post
 * @param $key
 * @param $value
 *
 * @return bool|int
 */
function so_update_postmeta($post, $key, $value)
{
    $id = 'theme_' . $post->post_type . '_' . $key;
    return update_post_meta($post->ID, '_' . $id, $value);
}


/**
 * Get postmeta
 *
 * @param $post
 * @param $key
 * @param bool $single
 *
 * @return mixed
 */
function so_get_postmeta($post, $key, $single = true)
{
    $id = 'theme_' . $post->post_type . '_' . $key;
    return get_post_meta($post->ID, '_' . $id, $single);
}


/**
 * Delete postmeta
 *
 * @param $post
 * @param $key
 * @param bool $value
 *
 * @return bool
 */
function so_delete_postmeta($post, $key, $value = false)
{
    $id = 'theme_' . $post->post_type . '_' . $key;
    if (!$value){
        return delete_post_meta($post->ID, $id);
    }
    return delete_post_meta($post->ID, $id, $value);
}

/**
 * Metabox control input
 * Render control input where name and value is postmeta key and value
 *
 * @param $post
 * @param $name
 * @param $label
 * @param bool $decorator
 * @param bool $size
 * @param bool $suffix
 * @param bool $disabled
 */
function so_metabox_control_input($post, $name, $label, $decorator = false, $size = false, $suffix = false, $disabled = false)
{
    $id = 'theme_'.$post->post_type.'_'.$name;
    $value = get_post_meta($post->ID, '_'.$id, true);

    if($disabled){
        $disabled = 'disabled="disabled"';
    }

    $label = '<label for="'.$id.'">'.$label.'</label> ';
    $control = '<input type="text" name="'.$id.'" id="'.$id.'" class="'.$size.'" value="'.esc_attr( $value ).'" '.$disabled.'>';

    if($suffix){
        $control .= '<span class="suffix">'.$suffix.'</span>';
    }

    if($decorator && ($decorator == 'table')){
        $label   = '<td class="label">'.$label.'</td>';
        $control = '<td class="control">'.$control.'</td>';
    }

    if($decorator && ($decorator == 'block')){
        $label   = '<div class="input_row">'.$label;
        $control = $control.'</div>';
    }

    $output = $label.$control;
    echo $output;
}


/**
 * Metabox control select
 * Render control select where name and value is postmeta key and value
 *
 * @param $post
 * @param $name
 * @param $title
 * @param array $option
 * @param bool $decorator
 * @param bool $size
 * @param bool $suffix
 * @param bool $disabled
 */
function so_metabox_control_select($post, $name, $title, $option = array(), $decorator = false, $size = false, $suffix = false, $disabled = false)
{
    $id = 'theme_'.$post->post_type.'_'.$name;
    $value = get_post_meta($post->ID, '_'.$id, true);

    if($disabled){
        $disabled = 'disabled="disabled"';
    }

    $label = '<label for="'.$id.'">'.$title.'</label> ';

    $control = '<select name="'.$id.'" id="'.$id.'" class="'.$size.'" '.$disabled.'>';

    foreach($option as $option_key=>$option_value)
    {
        $selected = $value == $option_key ? 'selected="selected"' : '';
        $control .= '<option value="'.$option_key.'" '.$selected.'>'.$option_value.'</option>';
    }

    $control.= '</select>';

    if($suffix){
        $control .= '<span class="suffix">'.$suffix.'</span>';
    }

    if($decorator && ($decorator == 'table')){
        $label   = '<td class="label">' . $label . '</td>';
        $control = '<td class="control">' . $control . '</td>';
    }

    if($decorator && ($decorator == 'block')){
        $label   = '<div class="input_row">'.$label;
        $control = $control.'</div>';
    }

    $output = $label.$control;
    echo $output;
}


/**
 * Metabox control textarea
 * Render control textarea where name and value is postmeta key and value
 *
 * @param $post
 * @param $name
 * @param $title
 * @param bool $decorator
 * @param string $css_class
 * @param int $rows
 * @param int $cols
 * @param bool $suffix
 * @param bool $disabled
 */
function so_metabox_control_textarea($post, $name, $title, $decorator = false, $css_class = '', $rows = 1, $cols = 40, $suffix = false, $disabled = false)
{
    $id = 'theme_'.$post->post_type.'_'.$name;
    $value = get_post_meta($post->ID, '_'.$id, true);

    if($disabled){
        $disabled = 'disabled="disabled"';
    }

    if($css_class){
        $css_class = ' ' . $css_class;
    }

    $label = '<span>' . $title . '</span>';
    $control = '<textarea name="'.$id.'" id="'.$id.'" rows="'.$rows.'" cols="'.$cols.'" class="textarea'.$css_class.'" '.$disabled.'>'. esc_attr( $value ) .'</textarea>';

    if( $suffix ){
        $control .= '<span class="suffix">'.$suffix.'</span>';
    }

    if($decorator && ($decorator == 'table')){
        $label   = '<td class="label">' . $label . '</td>';
        $control = '<td class="control">' . $control . '</td>';
    }

    if($decorator && ($decorator == 'block')){
        $label   = '<div class="input_row">'.$label;
        $control = $control.'</div>';
    }

    $output = $label.$control;
    echo $output;
}


function so_metabox_control_upload($post, $name, $title, $decorator = false, $size = false, $add_text = false, $disabled = false){

    $id = 'theme_'.$post->post_type.'_'.$name;
    $value = get_post_meta($post->ID, '_' . $id, true);

    if($disabled){
        $disabled = ' disabled="disabled"';
    }

    $label   = '<label for="' . $id . '">' . $title . '</label> ';
    $control = '<input type="text" name="' . $id . '" id="' . $id . '" class="' . $size . '"' . $disabled . ' value="'.$value.'">';
    $button  = '<input type="button" class="button add_media" id="button_'.$id.'" value="'. __( 'Choose file', 'as' ) .'">';

    if($add_text){
        $button .= ' ' . $add_text;
    }

    if($decorator && ($decorator == 'table')){
        $label   = '<td class="label">'   . $label   . '</td>';
        $control = '<td class="control">' . $control . '</td>';
        $button  = '<td class="control">' . $button  . '</td>';
    }

    if($decorator && ( $decorator == 'table-row')){
        $label   = '<tr>';
        $label  .= '<td class="label">'   . $label   . '</td>';
        $control = '<td class="control">' . $control . '</td>';
        $button  = '<td class="control">' . $button  . '</td>';
        $button .= '</tr>';
    }

    $output = $label . $control . $button;
    echo $output;
}


/**
 * @param $post
 * @param $key
 * @param bool|false $filter
 * @return mixed
 */
function so_metabox_control_save($post, $key, $filter = false){
    $value = $_POST['theme' . '_' . $post->post_type . '_' . $key];
    if($filter){
        if($filter == 'int'){
            $value = intval($value);
        }
        if($filter == 'float'){
            $value = floatval($value);
        }
        if($filter == 'str'){
            $value = strval($value);
        }
    }
    return so_update_postmeta($post, $key, $value);
}


/**
 * @param $post_id
 * @param $key
 * @param bool|false $filter
 * @return mixed
 */
function so_metabox_control_save_relative($post, $key, $filter = false){

    $value = $_POST['theme' . '_' . $post->post_type . '_' . $key];

    $value = wp_make_link_relative($value);

    if($filter){
        if($filter == 'int'){
            $value = intval($value);
        }

        if($filter == 'float'){
            $value = floatval($value);
        }

        if($filter == 'str'){
            $value = strval($value);
        }
    }

    return so_update_postmeta($post, $key, $value);
}

///**
// * AJAX error message generator
// *
// * @param $message
// *
// * @return mixed|string|void
// */
//function ajax_error($message)
//{
//    $result = array(
//        'status' => 'error',
//        'message' => __($message, SO_TEXTDOMAIN),
//    );
//
//    return json_encode($result);
//}
//
//
/**
 * AJAX Ok message generator
 *
 * @param $message
 * @param array $data
 *
 * @return mixed|string|void
 */
function ajax_success($message, array $data = array())
{
    $data['status'] = 'success';
    $data['message'] = __($message, SO_TEXTDOMAIN);

    return json_encode($data);
}

