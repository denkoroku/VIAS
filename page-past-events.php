<?php


get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
		<main id="main" class="site-main" role="main">

        <h1>Past Events</h1>

            <?php 
                $today = date('Ymd');
                $pastEvents = new WP_Query(array(
                    'paged' => get_query_var('paged', 1),
                    'post_type' => 'event',
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'compare' => '<=',
                            'value' => $today,
                            'type' => 'numeric'
                        )
                    )
                ));?>

                

<table class="table table-striped">
			<tbody>
            <?php while ($pastEvents->have_posts()) {
                    $pastEvents->the_post(); ?>
			<tr>
				<th scope="row"><?php
					$eventDate = new DateTime(get_field('event_date'));?>
					<span><?php echo $eventDate->format('jS');?></span>
					<span><?php echo $eventDate->format('M');?>
				</th>
				<td>
					<?php esc_attr(the_title())?>
				</td>
				<td>
					<a href="<?php esc_url(the_permalink()) ?>" class="btn wp-block-button__link mx-2">View event detail</a>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
        <div class="text-center">
            <a class="wp-block-button__link btn mt-5" href="<?php echo esc_url(site_url('/events'))?>">Back to all events</a>
        </div> 

		</main>
	</section>

    <?php echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
    )); ?>

<?php

get_footer();
