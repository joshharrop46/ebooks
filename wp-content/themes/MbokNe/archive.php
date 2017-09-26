<?php get_header(); ?>
<div style="clear: both"></div>
<div id="bigcontent">
<?php include (TEMPLATEPATH . '/sidebar-left.php'); ?>
<div id="content"><div class="post"><div id="breadchumb">
<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>  </div>
<h1><?php if(is_category()) { ?> <?php single_cat_title(''); ?>
    <?php } elseif (is_day()) { ?><?php the_time('F jS, Y'); ?>
	<?php } elseif (is_month()) { ?> <?php the_time('F, Y'); ?>
	<?php } elseif (is_tag()) { ?> <?php single_tag_title(''); ?>
	<?php } elseif (is_year()) { ?> <?php the_time('Y'); ?>
	<?php } elseif (is_author()) { ?> Author
	<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?> Blog Archives
	    <?PHP } ?><?php  if ( get_query_var('paged') ) { echo ' ('; echo __('page') . ' ' . get_query_var('paged');   echo ')';  } ?></h1>
		<?php echo category_description( $category_id ); ?> </div>
<?php include (TEMPLATEPATH . '/loop.php'); ?>	
</div><?php get_sidebar(); ?>
<?php get_footer(); ?>