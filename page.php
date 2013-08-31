<?php get_header(); ?>




<div class="c-wrapper">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<article  <?php post_class(''); ?>>
				
			<header class="entry-header">
					
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
			</header>
			
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			
			<footer class="entry-meta">
			</footer>
			
		</article>
				
		<?php wp_link_pages( array(
			'before'           => '<div class="page-pagination">',
			'after'            => '</div>',
			'next_or_number'   => 'pandz',
			'nextpagelink'     => '',
			'previouspagelink' => '',
			'pagelink'         => '%',
		)); ?>
	<?php endwhile; endif; ?>

</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>