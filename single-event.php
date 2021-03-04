<?php

get_header(); ?>

<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <!-- if want to change the banner use:
            pageBanner(array(
                    'title'=>'Test if I can change title',
                    'subtitle'=>'Test if I can change subtitle',
                    'photo'=> 'https://unsplash.com/photos/RCfi7vgJjUY'
                ));?> -->

        <?php 
            $today = date('Ymd');
            while (have_posts()) {
                the_post();pageBanner();?>
                <div class="container">
                <h2 class="mt-5"><?php
                    $eventDate = new DateTime(get_field('event_date'));?>
                        <span><?php echo $eventDate->format('jS');?></span>
						<span><?php echo $eventDate->format('F');?></span>
						<span><?php echo $eventDate->format('Y');?></span>
                </h2>
                <p><?php echo esc_attr(get_the_content())?></p>
            <?php } 
        ?>

        <?php 
            if ($eventDate->format('Ymd') >= $today) { ?>
                <div class="text-center">
                    <a class="wp-block-button__link btn mt-5" href="<?php echo esc_url(get_post_type_archive_link('event'))?>">Back to all events</a>
                </div> <?php
            } else { ?>
                <div class="text-center">
                    <a class="wp-block-button__link btn mt-5" href="<?php echo esc_url(site_url('/past-events'))?>">Back to all past events</a>
                </div> <?php 
            }
        ?>
        
		</div>
		</main>
	</section>

<?php

get_footer();
