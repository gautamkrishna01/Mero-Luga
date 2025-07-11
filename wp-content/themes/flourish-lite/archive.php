<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Flourish Lite
 */

get_header(); ?>

<div class="container">
    <div id="content_holder">
        <div class="default_content_alignbx">
			<?php if ( have_posts() ) : ?>
                <header class="page-header">
                <?php
                the_archive_title( '<h1 class="entry-title">', '</h1>' );
                the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?> 
                </header><!-- .page-header -->
                <div class="my_blogpost_layout">
					<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content' ); ?>
                        <?php endwhile; ?>                   
                </div>
            <?php the_posts_pagination(); ?>
            <?php else : ?>
            <?php get_template_part( 'no-results' ); ?>
            <?php endif; ?>
        </div><!-- default_content_alignbx-->   
        <?php get_sidebar();?>       
        <div class="clear"></div>
    </div><!-- site-aligner -->
</div><!-- container -->
	
<?php get_footer(); ?>