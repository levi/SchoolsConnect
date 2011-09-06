<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="content" role="main">
      <div id="page_sidebar">
    		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <?php if ( is_front_page() ) { ?>
                <h2 class="entry-title"><?php the_title(); ?></h2>
              <?php } else { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
              <?php } ?>

              <div class="entry-content">
                <?php the_content(); ?>
                <?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
              </div><!-- .entry-content -->
            </div><!-- #post-## -->
                
            <?php 
              if ($post->post_parent) {
                $parent_id = $post->post_parent;
                $GLOBALS['parent'] = $parent_id;
                $GLOBALS['parent_title'] = get_the_title($parent_id);
                $GLOBALS['parent_link'] = get_permalink($parent_id);
              }
            ?>

        <?php endwhile; // end of the loop. ?>

        <?php get_sidebar(); ?>

      </div>
		</div><!-- #content -->

<?php get_footer(); ?>
