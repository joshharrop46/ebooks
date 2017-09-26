<?php get_header(); ?>
<div style="clear: both"></div>
<div id="aprelik">
<?php include (TEMPLATEPATH . '/sidebar-left.php'); ?>
<div id="content">
<?php if (have_posts()) :?><?php $postCount=0; ?><?php while (have_posts()) : the_post();?><?php $postCount++;?>
<div class="post post-<?php echo $postCount ;?>"><div id="breadchumb">
<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>  </div>
<div class="posttitle"><a href=""><h1><?php the_title(); ?></h1></a></div>
<div class="tags"><?php the_time('l, F jS Y.') ?>  &#124; <?php the_category(', ') ?></div>
<input type="hidden" name="IL_IN_TAG" value="1"/>
<?php the_content(); ?>	

<?php include (TEMPLATEPATH . '/ads.php'); ?>
<?php if (function_exists('the_related')) the_related(); ?>
<div style="clear: both"></div>
<?php the_tags('tags: ',', ',''); ?></div>
<?php endwhile; ?>
<?php else : ?>

<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>