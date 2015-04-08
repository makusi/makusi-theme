<?php
/**
 * Template Name: Send Error
 *
 * Inform users about problems to upload file.
 *
 */

?>

<?php 

$message = "Today at " . date("F jS, Y"). " a failure happened when trying to upload a video.";


wp_mail( 'makusi@makusi.tv', 'Error when uploading a video', $message ); ?> 

We inform you that your file was not uploaded correctly.

<a href="#" id="close-window">Close</a>
