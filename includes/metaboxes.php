<?php

// Add the Meta Box
function add_queue_meta_box() {
    add_meta_box(
        'queue_meta_box', // $id
        'Queue Meta Box', // $title
        'show_queue_meta_box', // $callback
        'videos', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_queue_meta_box');

// Field Array
$prefix = 'queue_';
$queue_meta_fields = array(
    /*array(
        'label'=> 'Text Input',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'text',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Textarea',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'textarea',
        'type'  => 'textarea'
    ),*/
    array(
        'label'=> 'Info',
        'desc'  => 'Info delivered by ffmpeg',
        'id'    => $prefix.'info',
        'type'  => 'textelement'
    ),
    array(
        'label'=> 'Raw Info',
        'desc'  => 'Raw Info delivered by ffmpeg',
        'id'    => $prefix.'raw_info',
        'type'  => 'textelement'
    ),
    /*array(
        'label'=> 'Checkbox Input',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'checkbox',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Select Box',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'select',
        'type'  => 'select',
        'options' => array (
            'one' => array (
                'label' => 'Option One',
                'value' => 'one'
            ),
            'two' => array (
                'label' => 'Option Two',
                'value' => 'two'
            ),
            'three' => array (
                'label' => 'Option Three',
                'value' => 'three'
            )
        )
   ),*/
    array(
        'label'=> 'Status',
        'desc'  => 'Status in the queue.',
        'id'    => $prefix.'status',
        'type'  => 'select',
        'options' => array (
            'waiting' => array (
                'label' => 'Waiting',
                'value' => 'waiting'
            ),
            'missing' => array (
                'label' => 'Missing',
                'value' => 'missing'
            ),
            'done' => array (
                'label' => 'Done',
                'value' => 'done'
            )
        )
    ),
    array(
        'label'=> 'Creative Commons License',
        'desc'  => 'Creative Commons License.',
        'id'    => 'creative_commons_license',
        'type'  => 'checkbox',
        'options' => array (
            'Atribución [CC BY]' => array (
                'label' => 'Atribución [CC BY]',
                'value' => 'Atribución [CC BY]'
            ),
            'Atribución no derivadas [CC BY-ND]' => array (
                'label' => 'Atribución no derivadas [CC BY-ND]',
                'value' => 'Atribución no derivadas [CC BY-ND]'
            ),
            'Atribución no comercial [CC BY-NC]' => array (
                'label' => 'Atribución no comercial [CC BY-NC]',
                'value' => 'Atribución no comercial [CC BY-NC]'
            ),
            'Atribución no comercial no derivadas [CC BY-NC-ND]' => array (
                'label' => 'Atribución no comercial no derivadas [CC BY-NC-ND]',
                'value' => 'Atribución no comercial no derivadas [CC BY-NC-ND]'
            ),
            'Atribución compartir igual no comercial [CC BY-NC-SA]' => array (
                'label' => 'Atribución compartir igual no comercial [CC BY-NC-SA]',
                'value' => 'Atribución compartir igual no comercial [CC BY-NC-SA]'
            ),
            'Atribución compartir igual [CC BY-SA]' => array (
                'label' => 'Atribución compartir igual [CC BY-SA]',
                'value' => 'Atribución compartir igual [CC BY-SA]'
            )
        )
    ),
    array(
        'label'=> 'privacy_settings',
        'desc'  => 'Configuración de privacidad.',
        'id'    => 'privacy_settings',
        'type'  => 'select',
        'options' => array (
            'Público' => array (
                'label' => 'Público',
                'value' => 'Público'
            ),
            'Oculto' => array (
                'label' => 'Oculto',
                'value' => 'Oculto'
            )
        )
    ),
    array(
        'label'=> 'Contraseña',
        'desc'  => 'Introduce la contraseña de protección',
        'id'    => 'password',
        'type'  => 'textelement'
    )
);

// The Callback
function show_queue_meta_box() {
    global $queue_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="queue_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    //echo "<pre>";
    //var_dump($queue_meta_fields);
    //echo "</pre>";
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($queue_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // text
                    case 'textelement':
                        if($field['id'] == 'queue_info'){
                            echo '<p>'.$meta.'</p><br /><span class="description">'.$field['desc'].'</span>';
                        } elseif($field['id'] == 'queue_raw_info') {
                            //echo '<pre>'.var_dump($meta).'</pre>';
                            echo '<div style="width:550px; height:300px; overflow:scroll;"><pre style="font-size:10px;">'.$meta.'</pre></div><br /><span class="description">'.$field['desc'].'</span>';
                        }
                    break;
                    case 'text':
                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
                    break;
                    // textarea
                    case 'textarea':
                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea><br /><span class="description">'.$field['desc'].'</span>';
                    break;
                    // checkbox
                    case 'checkbox':
                    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/><label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;
                    // select
                    case 'select':
                        echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                        foreach ($field['options'] as $option) {
                            echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                        }
                        echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;
                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_queue_meta($post_id) {
    global $queue_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['queue_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($queue_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_queue_meta');


// Add the Meta Box for the video
function add_video_meta_box() {
    add_meta_box(
        'video_meta_box', // $id
        'Video Meta Box', // $title
        'show_video_meta_box', // $callback
        'videos', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_video_meta_box');

function show_video_meta_box(){
    global $post;
    $attachments = get_posts( array(
        	'post_type' => 'attachment',
			'posts_per_page' => 0,
			'post_parent' => $post->ID
	) );
    if($attachments){
        foreach($attachments as $attachment){
            $metadata = wp_get_attachment_metadata( $attachment->ID );
            
            $thumbnail = $thumbs['metadata']['custom-large']['file'];
            echo '
                <video 
                    id="example_video_1" 
                    class="video-js vjs-default-skin" 
                    controls 
                    preload="none" 
                    width="640" 
                    height="264"
                    poster="'.$thumbnail.'" 
                    data-setup="{}">
                    <!--video  id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264" data-setup="{}"-->
                    <!--video onerror="failed(event)" controls width="640" height="264"-->
                        <source src="'.wp_get_attachment_url($attachment->ID).'" type="video/mp4" />
                        <source src="'.wp_get_attachment_url($attachment->ID).'" type="video/flv" /> 
                        <!--source src="http://video-js.zencoder.com/oceans-clip.webm" type="video/webm" /-->
                        <!--source src="http://video-js.zencoder.com/oceans-clip.ogv" type="video/ogg" /-->
                        <!--track kind="captions" src="demo.captions.vtt" srclang="en" label="English"--></track><!-- Tracks need an ending tag thanks to IE9 -->
                        <!--track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"--></track><!-- Tracks need an ending tag thanks to IE9 -->
                    </video>';
            echo "<br /><strong>METADATA</strong><br />";
            echo "<strong>Filesize:</strong> ".$metadata['filesize'];
            echo "<br /><strong>Mime Type:</strong> ".$metadata['mime_type'];
            echo "<br /><strong>Length:</strong> ".$metadata['length'];
            echo "<br /><strong>Length Formatted:</strong> ".$metadata['length_formatted'];
            echo "<br /><strong>Width:</strong> ".$metadata['width'];
            echo "<br /><strong>Height:</strong> ".$metadata['height'];
            echo "<br /><strong>File Format:</strong> ".$metadata['fileformat'];
            echo "<br /><strong>Data Format:</strong> ".$metadata['dataformat'];
            echo "<br /><strong>AUDIO</strong>";
            echo "<br /><strong>Data Format:</strong> ".$metadata['audio']['dataformat'];
            echo "<br /><strong>Coded:</strong> ".$metadata['audio']['codec'];
            echo "<br /><strong>Sample Rate:</strong> ".$metadata['audio']['sample_rate'];
            echo "<br /><strong>Channels:</strong> ".$metadata['audio']['channels'];
            echo "<br /><strong>Bits per sample:</strong> ".$metadata['audio']['bits_per_sample'];
            echo "<br /><strong>Lossless:</strong> ".$metadata['audio']['lossless'];
            echo "<br /><strong>Channel Mode:</strong> ".$metadata['audio']['channelmode'];
        }
    }
}

// Add the Meta Box for the thumbnails
// Add the Meta Box for the video
function add_videothumbnails_meta_box() {
    add_meta_box(
        'videothumbnails_meta_box', // $id
        'Video Thumbnails Meta Box', // $title
        'show_videothumbnails_meta_box', // $callback
        'videos', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_videothumbnails_meta_box');

function show_videothumbnails_meta_box(){
    global $post;
    $attachments = get_posts( array(
        'post_type' => 'attachment',
	'posts_per_page' => 0,
	'post_parent' => $post->ID
	) );
    /*echo "<pre>";
    var_dump($attachments);
    echo "</pre>";*/
    if($attachments){
        foreach($attachments as $attachment){
            $thumbs = wp_get_attachment_metadata( $attachment->ID );
            /*echo "<pre>";
            var_dump($attachment);
            echo "</pre>";*/
            if($thumbs['sizes'] !== NULL){
                $thumbnail = $thumbs['sizes']['custom-large']['file'];
                foreach ($thumbs['sizes'] as $thumbnail){ ?>
                    <br />
                    <?php echo $thumbnail['width']; ?>x<?php echo $thumbnail['height']; ?><br />
                    <img src="<?php echo $thumbnail['url'];?>"<?php if($thumbnail['width'] > 700){ ?> style="width:100%; height:auto;"<?php } ?> />
                    <div style="clear:both;"></div>
                    <?php
                }
            } else {
                echo "No thumbs were created";
            }
        }
    } else {
        echo "No attachments associated to this post"; 
    }
//echo "</div></div>";
}

add_action('add_meta_boxes', 'add_metadata_meta_box');

function add_metadata_meta_box(){
     add_meta_box(
        'metadata_meta_box', // $id
        'Metadata Meta Box', // $title
        'show_metadata_meta_box', // $callback
        'videos', // $page
        'normal', // $context
        'high'); // $priority
}

function show_metadata_meta_box(){
    global $post;
    $meta_values = get_post_meta( $post->ID );
    //echo "<pre>";
    //var_dump($meta_values);
    //echo "</pre>";
    echo "<br />";
    if(is_array($meta_values['creative_commons_license'])){
        echo "<strong>Licencia Creative Commons</strong>: ";
        echo $meta_values['creative_commons_license'][0];
    }
    echo "<br />";
    if(is_array($meta_values['privacy_settings'])){
        echo "<strong>Configuración de Privacidad</strong>: ";
        echo $meta_values['privacy_settings'][0];
    }
    echo "<br />";
    if(is_array($meta_values['children_protection'])){
        echo "<strong>Protección a Menores</strong>: ";
        echo $meta_values['children_protection'][0];
    }
}

// Add the Meta Box
function add_attachment_log_meta_box() {
    add_meta_box(
        'log_meta_box', // $id
        'Log Meta Box', // $title
        'show_log_meta_box', // $callback
        'attachment', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_attachment_log_meta_box');

// Field Array
$prefix2 = 'log_';
$log_meta_fields = array(
    array(
        'label'=> 'Log',
        'desc'  => 'Info Obtained from log file',
        'id'    => $prefix2.'data',
        'type'  => 'textelement'
    )
);
// The Callback
function show_log_meta_box() {
    global $log_meta_fields, $post;
    echo '<table class="form-table">';
    foreach ($log_meta_fields as $field) {
         $meta = get_post_meta($post->ID, $field['id'], true);
         $array =  json_decode($meta);
         echo '<tr style="font-weight:strong"><td><strong>Date</strong></td><td><strong>Chunk</strong></td><td><strong>Temp</strong></td><td><strong>Size</strong></td><td><strong>Continuity</strong></td></tr>';
         foreach ($array as $row){
            echo "<tr>";
            echo "<td>".$row->date."</td>";
            echo "<td>".$row->chunk."</td>";
            echo "<td>".$row->tempname."</td>";
            echo "<td>".$row->size."</td>";
            echo "<td>".$row->continuity."</td>";
            echo "</tr>";
         }
    }
    echo '</table>';
}
?>
