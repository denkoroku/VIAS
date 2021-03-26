<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>
<div class= "container news">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

<!-- The title -->
	<header class="entry-header mt-5">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title text-dark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php the_date(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

<!-- Main body -->
	<?php
	if ( is_single() ) : ?>
	<div class = "container entry-content">
		<div class = "row  mx-auto">
			<div class = "post-thumbnail col-md-6">
				<?php the_post_thumbnail(); ?>
			</div>
			<div class = "col-md-12">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
	<?php	
	else : ?>
		<div class = "row entry-content">
			<div class = "post-thumbnail col-md-6">
				<?php the_post_thumbnail(); ?>
			</div>
			<div class = "col-md-6">
				<?php the_content(); ?>
			</div>
			<div class = "divider col-8 mx-auto my-5">
			</div>
		</div>
	<?php	
	endif; ?>

	<footer class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
