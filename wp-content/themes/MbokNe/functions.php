<?php 
register_sidebar(array('name'=>'left Sidebar',
'before_widget' => '<div class="pingilan">', 
'after_widget' => '</div>', 
'before_title' => '<div id="pie">', 
'after_title' => '</div>', 
));
register_sidebar(array('name'=>'right Sidebar',
'before_widget' => '<div class="pingilan">', 
'after_widget' => '</div>', 
'before_title' => '<div id="pie">', 
'after_title' => '</div>', 
));
?>
<?php 
function breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Home'; //text for the 'Home' link
  $currentBefore = '<span class="current1">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . 'Archive by category &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . '' . get_search_query() . '' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}
?>
<?php // WP-PageNavi//
function custom_wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 6, $always_show = false) {
	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {
		$prelabel  = '<strong>&laquo;</strong>';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '<strong>&raquo;</strong>';
	}
	$half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
		}
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class=\"wp-pagenavi\"><span class=\"pages\">Page $paged of $max_page:</span>";
			if ($paged >= ($pages_to_show-1)) {
				echo '<a href="'.get_pagenum_link().'">&laquo; First</a>&nbsp;';
			}
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong class='current'>$i</strong>";
					} else {
						echo ' <a href="'.get_pagenum_link($i).'">'.$i.'</a> ';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
				echo '&nbsp;<a href="'.get_pagenum_link($max_page).'">Last &raquo;</a>';
			}
			echo "</div> $after";
		}
	}
}
?>
<?php
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
?>
<?php
//-------- theme options ---------- //

$themename = "doaibu";
$shortname = str_replace(' ', '_', strtolower($themename));

function get_theme_option($option)
{
	global $shortname;
	return stripslashes(get_option($shortname . '_' . $option));
}

function get_theme_settings($option)
{
	return stripslashes(get_option($option));
}
$options = array (
array(	"name" => "1 - Colours Option","type" => "heading", ),
array(	"name" => "Theme Color",
"id" => $shortname."_color","std" => "0066cc","type" => "colorjs", ),
array(	"name" => "twitter ","id" => $shortname."_twitter", "type" => "text", "std" => "", ),
array(	"name" => "Face book ","id" => $shortname."_facebook", "type" => "text", "std" => "", ),
array(	"name" => "</div></div>","type" => "close",),

array(	"name" => " 2 - Ads 728 x 90  setting", "type" => "heading", ),
array(	"name" => "Display ads 728 x 90 ? ","id" => $shortname."_home_ads_act1", "type" => "select",  "std" => "No",
"options" => array("No", "Yes")),
array(	"name" => "Input  Ads size 728 x 90 ",	"id" => $shortname."_home_ads1",  "type" => "textarea",  "std" => "", ),
array(	"name" => "</div></div>","type" => "close", ),

array(	"name" => " 3 - Ads 336x 280 setting", "type" => "heading", ),
array(	"name" => "Display ads ? ","id" => $shortname."_home_ads_act2", "type" => "select",  "std" => "No",
"options" => array("No", "Yes")),
array(	"name" => "display advertisement text ? ", "id" => $shortname."_ads_act2", "type" => "select",    "std" => "No",
"options" => array("No", "Yes")),
array(	"name" => "Input  Ads code ",	"id" => $shortname."_home_ads2",  "type" => "textarea",  "std" => "", ),
array(	"name" => "</div></div>","type" => "close", ),
		
array(	"name" => " 4- Analytic setting ( Histats or google analytic )","type" => "heading",),
array(	"name" => "add your stat code ? ","id" => $shortname."_footer_ads_act1","type" => "select","std" => "No",
"options" => array("No", "Yes")),			
array(	"name" => "Input your stat code","id" => $shortname."_footer_ads1","type" => "textarea","std" => "", ),
array(	"name" => "</div></div>","type" => "close",),

		

);

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}
function mytheme_add_init() {
$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/function.css", false, "1.0", "all");
}
function admin_js(){
	if ( $_GET['page'] == basename(__FILE__) ) {
?>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/jscolor.js"></script>
<?php }
}
function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<?php echo "<div id=\"function\"> ";?>
<h4><?php echo "$themename"; ?> Premium Wordpress Themes</h4>

<div class="opening">
<p>Themes Designed By <a href="http://fastestwp.com" target="_blank" rel="nofollow"><b>fastestwp.com</b></a> |  <a href="http://fastestwp.com/support" target="_blank" rel="nofollow"><b>support</b> </a> | <a href="http://fastestwp.com/themes" target="_blank" rel="nofollow"><b>fastest wordpress themes</b></a></p>
</div>

<form action="" method="post">

<?php foreach ($options as $value) { ?>

<?php switch ( $value['type'] ) { case 'heading': ?>

<div class="get-option">

<h2><?php echo $value['name']; ?></h2>

<div class="option-save">
<?php break;

case 'colorjs':
?>

<div class="description"><?php echo $value['name']; ?></div>

	<input style="width:200px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo stripslashes($value['std']); } ?>" class="color" />
	<br/>
<?php
break;
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (

get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php
break;
case 'select':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php
break;
case 'textarea':
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); }

else { echo $value['std']; } ?></textarea></p>

<?php
break;
case 'close':
?>

<div class="clearfix"></div>
</div><!-- OPTION SAVE END -->

<div class="clearfix"></div>
</div><!-- GET OPTION END -->

<?php
break;
default;
?>


<?php
break; } ?>

<?php } ?>

<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save Options" />
<input type="hidden" name="action" value="save" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset Options" />
<input type="hidden" name="action" value="reset" />
</p>
</form>

</div><!-- ADMIN OPTIONS END -->
<?php } 

?>
<?php
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');
?>
<?php
function get_freestyle_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ 
  	$img_dir = get_bloginfo('template_directory');
    $first_img = $img_dir . '/images/thumb.gif';
  }
  return $first_img;
}
?>
<?php
function mytheme_wp_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php }
add_action('wp_head', 'mytheme_wp_head');
add_action('admin_head', 'admin_js');
add_action('admin_menu', 'mytheme_add_admin'); ?>
<?php
function add_wp3menu_support() {
register_nav_menus(
        array(
        'main-menu' => __('Main Navigation')
        )
     );
 
}
add_action('init', 'add_wp3menu_support');
?>
<?php
function widget_recent() { ?>
<div class="box"><h4>Latest</h4><?php include (TEMPLATEPATH . '/thumbindex.php'); ?></div>
<?php }
if ( function_exists('register_sidebar_widget') )
register_sidebar_widget(__('Virtarich Recent Post'), 'widget_recent');
?>
<?php
function widget_related() { ?>
<div class="box"><div id="rata">Related Post</div><?php include (TEMPLATEPATH . '/related.php'); ?></div>
<?php }
if ( function_exists('register_sidebar_widget') )
register_sidebar_widget(__('Virtarich Related'), 'widget_related');
?>
<?php
define( 'HEADER_IMAGE', '%s/images/logo.png' ); 
define( 'HEADER_IMAGE_WIDTH', apply_filters( '', 300 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( '', 60 ) ); 
define( 'NO_HEADER_TEXT', true );
add_custom_image_header( '', 'admin_header_style' ); 
if ( ! function_exists( 'admin_header_style' ) ) :
function admin_header_style() {
?>
<?php
}
endif;
?>