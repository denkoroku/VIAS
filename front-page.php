<?php
/**
 * The template for displaying the front page only
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<main id="main" class="site-main " role="main">

		<?php 
			$today = date('Ymd');
			$frontpageEvents = new WP_Query(array(
				'posts_per_page' => 3,
				'post_type' => 'event',
				'meta_key' => 'event_date',
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'event_date',
						'compare' => '>=',
						'value' => $today,
						'type' => 'numeric'
					)
				)
			));
?>
		<div class="container">
			<div class="card-group row mx-auto my-5">
			<?php 
			while ($frontpageEvents->have_posts()) {
				$frontpageEvents->the_post(); ?>

			<div class="card col-md-4 mx-auto text-center">
				<div class="card-header"><?php
					$eventDate = new DateTime(get_field('event_date'));?>
						<span><?php echo $eventDate->format('jS');?></span>
						<span><?php echo $eventDate->format('F');?></span>
						
				</div><!-- close card-header -->
				
				<div class="card-body">
					<h5 class="card-title"><?php esc_attr(the_title()) ?></h5>
					<p class="card-text"><?php 
							if(has_excerpt()) {
								echo esc_attr(get_the_excerpt());
							} else {
								echo wp_trim_words(esc_attr(get_the_content()), 15);
							};?>
					<p>
				</div> <!-- close card body  -->
				<div class="card-footer text-center">
					<a class="btn wp-block-button__link" href="<?php esc_url(the_permalink()) ?>">
						More information
					</a>
				</div> <!-- close footer  -->
			</div> <!-- close card  -->
		
		<?php } ?>
		</div> <!-- close row  -->

		<div class="ml-5 my-5">
			<a href="<?php echo esc_url(get_post_type_archive_link('event')) ?>">See all events here!
			</a>
		</div>
		</div>
	</main>
</section>

<?php

get_footer();
