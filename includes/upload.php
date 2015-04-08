<?php 
add_action( 'wp_ajax_mk_upload_file', 'mk_upload_file' );
add_action( 'wp_ajax_nopriv_mk_upload_file', 'mk_upload_file' );

add_action( 'wp_ajax_wpuf_insert_image', 'mk_insert_image'  );
add_action( 'wp_ajax_nopriv_wpuf_insert_image', 'mk_insert_image'  );

add_action( 'wp_ajax_mk_submit_post', 'mk_submit_post' );
add_action( 'wp_ajax_nopriv_mk_submit_post', 'mk_submit_post' );

add_action( 'wp_ajax_wpuf_file_del', 'mk_delete_file' );
add_action( 'wp_ajax_nopriv_wpuf_file_del', 'mk_delete_file' );

function mk_upload_file( $image_only = false ) {
	//echo "mk_upload_file";
        $upload = array(
            'name' => $_FILES['wpuf_file']['name'],
            'type' => $_FILES['wpuf_file']['type'],
            'tmp_name' => $_FILES['wpuf_file']['tmp_name'],
            'error' => $_FILES['wpuf_file']['error'],
            'size' => $_FILES['wpuf_file']['size']
        );
        
        header('Content-Type: text/html; charset=' . get_option('blog_charset'));

        $attach = mk_handle_upload( $upload );

        if ( $attach['success'] ) {

            $response = array( 'success' => true );

            if ($image_only) {
                $image_size = mk_get_option( 'insert_photo_size', 'mk_general', 'thumbnail' );
                $image_type = mk_get_option( 'insert_photo_type', 'mk_general', 'link' );
                
                if ( $image_type == 'link' ) {
                    $response['html'] = wp_get_attachment_link( $attach['attach_id'], $image_size );
                } else {
                    $response['html'] = wp_get_attachment_image( $attach['attach_id'], $image_size );
                }
                
            } else {
                $response['html'] = mk_attach_html( $attach['attach_id'] );
            }

            echo $response['html'];
        } else {
            echo 'error';
        }
        // $response = array('success' => false, 'message' => $attach['error']);
        // echo json_encode( $response );
        exit;
    }
	
	/**
     * Generic function to upload a file
     *
     * @param string $field_name file input field name
     * @return bool|int attachment id on success, bool false instead
     */
    function mk_handle_upload( $upload_data ) {

        $uploaded_file = wp_handle_upload( $upload_data, array('test_form' => false) );

        // If the wp_handle_upload call returned a local path for the image
        if ( isset( $uploaded_file['file'] ) ) {
            $file_loc = $uploaded_file['file'];
            $file_name = basename( $upload_data['name'] );
            $file_type = wp_check_filetype( $file_name );

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment( $attachment, $file_loc );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            return array('success' => true, 'attach_id' => $attach_id);
        }

        return array('success' => false, 'error' => $uploaded_file['error']);
    }

    function mk_attach_html( $attach_id, $type = NULL ) {
        if ( !$type ) {
            $type = isset( $_GET['type'] ) ? $_GET['type'] : 'image';
        }

        $attachment = get_post( $attach_id );

        if (!$attachment) {
            return;
        }

        if (wp_attachment_is_image( $attach_id)) {
            $image = wp_get_attachment_image_src( $attach_id, 'thumbnail' );
            $image = $image[0];
        } else {
            $image = wp_mime_type_icon( $attach_id );
        }
        //MAKUSI li ->div
        $html = '<div class="image-wrap thumbnail" style="width: 150px">';
        $html .= sprintf( '<div class="attachment-name"><img src="%s" alt="%s" /></div>', $image, esc_attr( $attachment->post_title ) );
        $html .= sprintf( '<div class="caption"><a href="#" class="btn btn-danger btn-small attachment-delete" data-attach_id="%d">%s</a></div>', $attach_id, __( 'Delete', 'wpuf' ) );
        $html .= sprintf( '<input type="hidden" name="wpuf_files[%s][]" value="%d">', $type, $attach_id );
        $html .= '</div>';

        return $html;
    }

function mk_get_option($option, $section, $default = ''){
	$options = get_option( $section );
	if (isset( $options[$option])){
		return $options[$option];
	}
	
	return $default;
}

function mk_delete_file() {
        check_ajax_referer( 'wpuf_nonce', 'nonce' );

        $attach_id = isset( $_POST['attach_id'] ) ? intval( $_POST['attach_id'] ) : 0;
        $attachment = get_post( $attach_id );

        //post author or editor role
        if ( get_current_user_id() == $attachment->post_author || current_user_can( 'delete_private_pages' ) ) {
            wp_delete_attachment( $attach_id, true );
            echo 'success';
        }

        exit;
    }

   


function mk_insert_image() {
	mk_upload_file( true );
}
    
function mk_allowed_extensions() {
    $extensions = array(
        'images' => array('ext' => 'jpg,jpeg,gif,png,bmp', 'label' => __( 'Images', 'wpuf' )),
        'audio' => array('ext' => 'mp3,wav,ogg,wma,mka,m4a,ra,mid,midi', 'label' => __( 'Audio', 'wpuf' )),
        'video' => array('ext' => 'avi,divx,flv,mov,ogv,mkv,mp4,m4v,divx,mpg,mpeg,mpe', 'label' => __( 'Videos', 'wpuf' )),
        'pdf' => array('ext' => 'pdf', 'label' => __( 'PDF', 'wpuf' )),
        'office' => array('ext' => 'doc,ppt,pps,xls,mdb,docx,xlsx,pptx,odt,odp,ods,odg,odc,odb,odf,rtf,txt', 'label' => __( 'Office Documents', 'wpuf' )),
        'zip' => array('ext' => 'zip,gz,gzip,rar,7z', 'label' => __( 'Zip Archives' )),
        'exe' => array('ext' => 'exe', 'label' => __( 'Executable Files', 'wpuf' )),
        'csv' => array('ext' => 'csv', 'label' => __( 'CSV', 'wpuf' ))
    );

    return apply_filters( 'wpuf_allowed_extensions', $extensions );
}

/**
     * Get a meta value
     *
     * @param int $object_id user_ID or post_ID
     * @param string $meta_key
     * @param string $type post or user
     * @param bool $single
     * @return string
     */
    function mk_get_meta( $object_id, $meta_key, $type = 'post', $single = true ) {
        if ( !$object_id ) {
            return '';
        }

        if ( $type == 'post' ) {
            return get_post_meta( $object_id, $meta_key, $single );
        }

        return get_user_meta( $object_id, $meta_key, $single );
    }
    
        /**
     * New/Edit post submit handler
     *
     * @return void
     */
    function mk_submit_post() {
    	
    	// Avoid alternative access to this actions
    	// check_ajax_referer( $action, $query_arg, $die )
    	// action is added at frontend-form-profile.php
    	// wp_nonce_field( 'wpuf_form_add' ); 
      check_ajax_referer( 'wpuf_form_add' );
		echo "Hello";
		exit;
        @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
			//to be removed
        $form_id = isset( $_POST['form_id'] ) ? intval( $_POST['form_id'] ) : 0;
        // to be obtained from $makusi_options = get_option( 'theme_makusi_options' );
        // needs to be redefined.
        $form_vars = $this->input_fields( $form_id );
        // to be obtainded from $makusi_options.
        $form_settings = get_post_meta( $form_id, 'wpuf_form_settings', true );

        list( $post_vars, $taxonomy_vars, $meta_vars ) = $form_vars;

        // don't check captcha on post edit
        if ( !isset( $_POST['post_id'] ) ) {

            // search if rs captcha is there. Needs search. validate_rs_captcha and validate_re_captcha functions from somewhere
            if ( search( $post_vars, 'input_type', 'really_simple_captcha' ) ) {
                validate_rs_captcha();
            }

            // check recaptcha
            if ( search( $post_vars, 'input_type', 'recaptcha' ) ) {
                validate_re_captcha();
            }
        }

        $is_update = false;
        $post_author = null;
        // Replace here with post author. Check where wpuf_get_option is created
        $default_post_author = wpuf_get_option( 'default_post_owner', 'wpuf_general', 1 );

        // Guest Stuffs: check for guest post
        if ( !is_user_logged_in() ) {
            if ( $form_settings['guest_post'] == 'true' && $form_settings['guest_details'] == 'true' ) {
                $guest_name = trim( $_POST['guest_name'] );
                $guest_email = trim( $_POST['guest_email'] );

                // is valid email?
                if ( !is_email( $guest_email ) ) {
                    send_error( __( 'Invalid email address.', 'wpuf' ) );
                }

                // check if the user email already exists
                $user = get_user_by( 'email', $guest_email );
                if ( $user ) {
                    $post_author = $user->ID;
                } else {

                    // user not found, lets register him
                    // username from email address
                    $username = guess_username( $guest_email );
                    $user_pass = wp_generate_password( 12, false );

                    $user_id = wp_create_user( $username, $user_pass, $guest_email );

                    // if its a success and no errors found
                    if ( $user_id && !is_wp_error( $user_id ) ) {
                        update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.
                        wp_new_user_notification( $user_id, $user_pass );

                        // update display name to full name
                        wp_update_user( array('ID' => $user_id, 'display_name' => $guest_name) );

                        $post_author = $user_id;
                    } else {
                        //something went wrong creating the user, set post author to the default author
                        $post_author = $default_post_author;
                    }
                }

                // guest post is enabled and details are off
            } elseif ( $form_settings['guest_post'] == 'true' && $form_settings['guest_details'] == 'false' ) {
                $post_author = $default_post_author;
            }

            // the user must be logged in already
        } else {
            $post_author = get_current_user_id();
        }

        $postarr = array(
            'post_type' => $form_settings['post_type'],
            'post_status' => $form_settings['post_status'],
            'post_author' => $post_author,
            'post_title' => isset( $_POST['post_title'] ) ? trim( $_POST['post_title'] ) : '',
            'post_content' => isset( $_POST['post_content'] ) ? trim( $_POST['post_content'] ) : '',
            'post_excerpt' => isset( $_POST['post_excerpt'] ) ? trim( $_POST['post_excerpt'] ) : '',
        );

        if ( isset( $_POST['category'] ) ) {
            $category = $_POST['category'];
            $postarr['post_category'] = is_array( $category ) ? $category : array($category);
        }
        
        if ( isset( $_POST['tags'] ) ) {
            $postarr['tags_input'] = explode( ',', $_POST['tags'] );
        }

        // if post_id is passed, we update the post
        if ( isset( $_POST['post_id'] ) ) {
            $is_update = true;
            $postarr['ID'] = $_POST['post_id'];
            $postarr['post_date'] = $_POST['post_date'];
            $postarr['comment_status'] = $_POST['comment_status'];
            $postarr['post_author'] = $_POST['post_author'];
            
            if ( $form_settings['edit_post_status'] == '_nochange') {
                $postarr['post_status'] = get_post_field( 'post_status', $_POST['post_id'] );
            } else {
                $postarr['post_status'] = $form_settings['edit_post_status'];
            }
            
        } else {
            if ( isset( $form_settings['comment_status'] ) ) {
                $postarr['comment_status'] = $form_settings['comment_status'];
            }
        }

        // check the form status, it might be already a draft
        // in that case, it already has the post_id field
        // so, WPUF's add post action/filters won't work for new posts
        if ( isset( $_POST['wpuf_form_status'] ) && $_POST['wpuf_form_status'] == 'new' ) {
            $is_update = false;
        }
        
        // set default post category if it's not been set yet and if post type supports
        if ( !isset( $postarr['post_category'] ) && isset( $form_settings['default_cat'] ) && is_object_in_taxonomy( $form_settings['post_type'], 'category' ) ) {
            $postarr['post_category'] = array( $form_settings['default_cat'] );
        }

        // validation filter
        if ( $is_update ) {
            $error = apply_filters( 'wpuf_update_post_validate', '' );
        } else {
            $error = apply_filters( 'wpuf_add_post_validate', '' );
        }

        if ( !empty( $error ) ) {
            $this->send_error( $error );
        }

        // ############ It's Time to Save the World ###############
        if ( $is_update ) {
            $postarr = apply_filters( 'wpuf_update_post_args', $postarr, $form_id, $form_settings, $form_vars );
        } else {
            $postarr = apply_filters( 'wpuf_add_post_args', $postarr, $form_id, $form_settings, $form_vars );
        }

        $post_id = wp_insert_post( $postarr );

        if ( $post_id ) {
            self::update_post_meta($meta_vars, $post_id);

            // set the post form_id for later usage
            update_post_meta( $post_id, self::$config_id, $form_id );

            // save post formats if have any
            if ( isset( $form_settings['post_format'] ) && $form_settings['post_format'] != '0' ) {
                if ( post_type_supports( $form_settings['post_type'], 'post-formats' ) ) {
                    set_post_format( $post_id, $form_settings['post_format'] );
                }
            }
            
            // find our if any images in post content and associate them
            if ( !empty( $postarr['post_content'] ) ) {
                $dom = new DOMDocument();
                $dom->loadHTML( $postarr['post_content'] );
                $images = $dom->getElementsByTagName( 'img' );

                if ( $images->length ) {
                    foreach ($images as $img) {
                        $url = $img->getAttribute( 'src' );
                        $url = str_replace(array('"', "'", "\\"), '', $url);
                        $attachment_id = wpuf_get_attachment_id_from_url( $url );

                        if ( $attachment_id ) {
                            wpuf_associate_attachment( $attachment_id, $post_id );
                        }
                    }
                }
            }

            // save any custom taxonomies
            $woo_attr = array();
            foreach ($taxonomy_vars as $taxonomy) {
                if ( isset( $_POST[$taxonomy['name']] ) ) {

                    if ( is_object_in_taxonomy( $form_settings['post_type'], $taxonomy['name'] ) ) {
                        $tax = $_POST[$taxonomy['name']];

                        // if it's not an array, make it one
                        if ( !is_array( $tax ) ) {
                            $tax = array($tax);
                        }
                        
                        if ( $taxonomy['type'] == 'text' ) {

                            $hierarchical = array_map( 'trim', array_map( 'strip_tags', explode( ',', $_POST[$taxonomy['name']] ) ) );

                            wp_set_object_terms( $post_id, $hierarchical, $taxonomy['name'] );
                            
                            // woocommerce check
                            //if ( isset( $taxonomy['woo_attr']) && $taxonomy['woo_attr'] == 'yes' ) {
                            //    $woo_attr[sanitize_title( $taxonomy['name'] )] = $this->woo_attribute( $taxonomy );
                            //}
                            
                        } else {

                            if ( is_taxonomy_hierarchical( $taxonomy['name'] ) ) {
                                wp_set_post_terms( $post_id, $_POST[$taxonomy['name']], $taxonomy['name'] );
                                
                                // woocommerce check
                                if ( isset( $taxonomy['woo_attr']) && $taxonomy['woo_attr'] == 'yes' ) {
                                    $woo_attr[sanitize_title( $taxonomy['name'] )] = $this->woo_attribute( $taxonomy );
                                }
                            } else {
                                if ( $tax ) {
                                    $non_hierarchical = array();

                                    foreach ($tax as $value) {
                                        $term = get_term_by( 'id', $value, $taxonomy['name'] );
                                        if ( $term && !is_wp_error( $term ) ) {
                                            $non_hierarchical[] = $term->name;
                                        }
                                    }

                                    wp_set_post_terms( $post_id, $non_hierarchical, $taxonomy['name'] );
                                }
                            } // hierarchical
                        } // is text
                        
                    } // is object tax
                } // isset tax
            }
            
            // if a woocommerce attribute
            //if ( $woo_attr ) {
            //    update_post_meta($post_id, '_product_attributes', $woo_attr);
            //}

            if ( $is_update ) {

                // plugin API to extend the functionality
                do_action( 'wpuf_edit_post_after_update', $post_id, $form_id, $form_settings, $form_vars );

                //send mail notification
                if ( $form_settings['notification']['edit'] == 'on' ) {
                    $mail_body = $this->prepare_mail_body( $form_settings['notification']['edit_body'], $post_author, $post_id );
                    wp_mail( $form_settings['notification']['edit_to'], $form_settings['notification']['edit_subject'], $mail_body );
                }
            } else {

                // plugin API to extend the functionality
                do_action( 'wpuf_add_post_after_insert', $post_id, $form_id, $form_settings, $form_vars );

                // send mail notification
                if ( $form_settings['notification']['new'] == 'on' ) {
                    $mail_body = $this->prepare_mail_body( $form_settings['notification']['new_body'], $post_author, $post_id );
                    wp_mail( $form_settings['notification']['new_to'], $form_settings['notification']['new_subject'], $mail_body );
                }
            }

            //redirect URL
            $show_message = false;
            $redirect_to = false;

            if ( $is_update ) {
                if ( $form_settings['edit_redirect_to'] == 'page' ) {
                    $redirect_to = get_permalink( $form_settings['edit_page_id'] );
                } elseif ( $form_settings['edit_redirect_to'] == 'url' ) {
                    $redirect_to = $form_settings['edit_url'];
                } elseif ( $form_settings['edit_redirect_to'] == 'same' ) {
                    $redirect_to = add_query_arg( array(
                        'pid' => $post_id,
                        '_wpnonce' => wp_create_nonce('wpuf_edit'),
                        'msg' => 'post_updated'
                         ), get_permalink( $_POST['page_id'] )
                    );
                } else {
                    $redirect_to = get_permalink( $post_id );
                }

            } else {
                if ( $form_settings['redirect_to'] == 'page' ) {
                    $redirect_to = get_permalink( $form_settings['page_id'] );
                } elseif ( $form_settings['redirect_to'] == 'url' ) {
                    $redirect_to = $form_settings['url'];
                } elseif ( $form_settings['redirect_to'] == 'same' ) {
                    $show_message = true;
                } else {
                    $redirect_to = get_permalink( $post_id );
                }
            }

            // send the response
            $response = array(
                'success' => true,
                'redirect_to' => $redirect_to,
                'show_message' => $show_message,
                'message' => $form_settings['message']
            );

            if ( $is_update ) {
                $response = apply_filters( 'wpuf_edit_post_redirect', $response, $post_id, $form_id, $form_settings );
            } else {
                $response = apply_filters( 'wpuf_add_post_redirect', $response, $post_id, $form_id, $form_settings );
            }

            echo json_encode( $response );
            exit;
        }

        send_error( __( 'Something went wrong', 'wpuf' ) );
    }
