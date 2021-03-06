<?php get_header(); ?>






	<div id="posts-list" class="c-wrapper">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
						
						
					
						<header class="entry-header">
						
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail('featured-thumb'); }?>
							
							<a href="<?php the_permalink(); ?>"><h1 class="entry-title"><?php the_title(); ?></h1></a>
							
						</header>
						
						<div class="entry-content">
						
							<?php the_excerpt(); ?>
							
						</div>
						
						<footer class="entry-meta">
							<time><?php the_date(); ?></time>
						</footer>
						
					</article>
			<?php endwhile; endif; ?>
		

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>