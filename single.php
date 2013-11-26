<?php get_header(); ?>




<div class="content-wrapper">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>



			<article  <?php post_class(''); ?>>
			
				
					
				<header class="entry-header">
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('featured-thumb'); }?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
				</header>
				
				<div class="entry-content">
				
					<?php the_content(); ?>
					
				</div>
				
				<footer class="entry-meta">
					<time><?php the_date(); ?></time>
				</footer>
				

			</article>



	<?php endwhile; endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>