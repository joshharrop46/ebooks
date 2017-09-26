<?php
require_once( dirname(__FILE__) . '../../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
a:link, a:visited {color:#<?php echo $doaibu_color; ?>;}
#header a{color:#<?php echo $doaibu_color; ?>;}
h1{color:#<?php echo $doaibu_color; ?>;}
.link a{color:#<?php echo $doaibu_color; ?>;}
#amazon a{color:#<?php echo $doaibu_color; ?>;}
.tags a{color:#<?php echo $doaibu_color; ?>;}
h2{color:#<?php echo $doaibu_color; ?>;}
h3{color:#<?php echo $doaibu_color; ?>;}
#sidebar a:hover{color:#<?php echo $doaibu_color; ?>;}