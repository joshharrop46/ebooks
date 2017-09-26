<?php $postcounter = 1; if (have_posts()) : ?>
<?php while (have_posts()) : $postcounter = $postcounter + 1; the_post(); $do_not_duplicate = $post->ID; $the_post_ids = get_the_ID(); ?>
<div class="post post-<?php echo $postCount ;?>">
<div class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
<div class="tags"><?php the_time('l, F jS Y') ?>  &#124; <?php the_category(', ') ?></div>
<?php echo excerpt(20); ?> 
<div style="clear: both"></div></div>
<?php endwhile; ?>
<?php include (TEMPLATEPATH . '/ads.php'); ?>
<?php include (TEMPLATEPATH . '/navigator.php'); ?>	
<?php else : ?>
<div class="post"></div>
<?php endif; ?>