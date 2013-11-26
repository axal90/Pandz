<?php get_header(); ?>









<div class="content-wrapper" role="main">



	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		

		<article  <?php post_class(''); ?>>

				

			<header class="entry-header">

				
					
				<h1 class="entry-title"><?php the_title(); ?></h1>

			</header>

			

			<div class="entry-content">
				
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail( array( 200, 150 ), array( 'class'	=> 'alignright' )); }?>

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