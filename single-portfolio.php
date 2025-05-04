<?php
// Redirect to 404 page when this template is accessed
global $wp_query;
$wp_query->set_404();
status_header(404);
get_template_part(404);
exit();
?>