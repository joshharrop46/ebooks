<?php $category_id = get_cat_id($featured_category);
$my_query = new WP_Query('offset=' . '&' . 'showposts='. 3);
while ($my_query->have_posts()) : $my_query->the_post(); $do_not_duplicate = $post->ID; $the_post_ids = get_the_ID(); ?> 
<div class="post-sidebar post-<?php echo $postCount ;?>"><?php include (TEMPLATEPATH . '/thumb2.php'); ?>
<div class="posttitle"><h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3></div>
<?php echo excerpt(12); ?><div style="clear: both"></div> 	</div>
<?php endwhile; ?>
<?php wp_reset_query(); ?>