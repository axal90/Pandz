<?php get_header(); ?>



	

			<article>
				<h1 class="entry-title">Page not found<h1>
				<p>You 
				<?php
					$website = get_bloginfo('url'); #gets your blog's url from wordpress
					$websitename = get_bloginfo('name'); #sets the blog's name, according to wordpress

					if (!isset($_SERVER['HTTP_REFERER'])) {
						echo 'tried going to '; 
						$casemessage = 'Yet, all is not lost! Visit our <a href="yip.se">homepage</a> to start over.';
					} elseif (isset($_SERVER['HTTP_REFERER'])) {
						echo 'clicked a link to'; 
					$casemessage = 'We are are woorking to get this fixed as soon as possible. In the mean time visit our <a href="yip.se">homepage</a> to start over.  ';
					}
					
					echo ' <strong>'.$website.$_SERVER['REQUEST_URI'].'</strong>'; ?> 
					but the page was not found.</p> <p> <?php echo $casemessage; ?>
				</p>
			</article>




<?php get_footer(); ?>



