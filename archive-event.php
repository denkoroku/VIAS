<?php

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<main id="main" class="site-main container" role="main">

        <h1 class="m-5">All Events</h1>
		<table class="table table-striped m-5">
			<tbody>
            <?php 
                while (have_posts()) {
                    the_post(); ?>
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
					<a href="<?php echo esc_url(the_permalink()) ?>" class="btn wp-block-button__link mx-2">View event detail</a>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>

        <p class="ml-5 my-5">Looking for a recap of past events? <a href="<?php echo esc_url(site_url('/past-events')) ?>">checkout our past events archive.<p></a>

		</main>
	</section>

    <?php echo paginate_links(); ?>

<?php

get_footer();
