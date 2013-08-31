
<?php get_header(); ?>


<div id="featured" class="">

	<script type="text/javascript">
		jQuery(document).ready(function($){
			
            $('#featured-slider').responsiveSlides({
                pause: true,
                speed: 500,
                timeout: 4000,
                pager: true,
                manualControls: "#f-pager",  
                
            });
											
		});

	</script>
	
	<div id="featured-slider">
	
		<?php $featured = get_posts(  array ( 
			'post_type' 		=> array ('page', 'attachment'),
			'category_name' 	=> 'featured',
			'posts_per_page'	=> '5',
			'post_status'		=> array ('publish', 'inherit'),
		) );
		foreach( $featured as $post ) :	setup_postdata($post); ?>
			
			<?php if ( 'attachment' == get_post_type() ) { ?>
				<article <?php post_class(); ?> >
				
					<?php $att_image = wp_get_attachment_image_src( $post->id, 'featured-thumb'); ?>

					<img src="<?php echo $att_image[0];?>" class="attachment-medium" alt="<?php $post->post_excerpt; ?>" />
					
				</article>
			<?php } else { ?>
			
				<article <?php post_class(); ?> >
					
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); }?>
			
					<header class="entry-header">
					
						<a href="<?php the_permalink(); ?>"><h1 class="entry-title"><?php the_title(); ?></h1></a>
						
					</header>
					
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
						
					<footer class="entry-meta">
						<time><?php the_date(); ?></time>
					</footer>
					
				</article>
			<?php } ?>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
		
					
		
	</div>
	<div id="f-pager" class="pagers"></div>
				

</div>



<div class="front-c-wrapper bg-light-brown">

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

<aside id="front-sidebar" class="">
	<?php dynamic_sidebar( 'front-sidebar' ); ?>
</aside>

<?php get_footer(); ?>

