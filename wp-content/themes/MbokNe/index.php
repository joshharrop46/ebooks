<?php get_header(); ?>
<div style="clear: both"></div>
<div id="aprelik">
<?php include (TEMPLATEPATH . '/sidebar-left.php'); ?>
<div id="content">
<div class="post"> <h1><?php bloginfo('name'); ?></h1>
<h2><?php bloginfo('description'); ?></h2> <?php  if ( get_query_var('paged') ) { echo ' ('; echo __('page') . ' ' . get_query_var('paged');   echo ')';  } ?></div>
<div class="post"><div class="posttitle">
<b>Latest Post  : <br /> </b> <?php while (have_posts()) : the_post(); ?>
<span style="color:#1acc85;margin-right:2px;"><ul>
<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li></ul></span>
<?php endwhile;?>
<div style="clear: both"></div></div>
</div></div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>