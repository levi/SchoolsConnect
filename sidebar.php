<?php
/**
 * The Sidebar containing the primary widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

		<div id="primary" class="widget-area" role="complementary">
			<div class="xoxo">
				<?php if ($GLOBALS['parent']): ?>
					<?php 
						$parent = $GLOBALS['parent'];
						$parent_title = $GLOBALS['parent_title'];
						$parent_permalink = $GLOBALS['parent_link'];
					?>
					<div id="page_nav" class="widget-container">
						<ul>
							<li><a href="<?php echo $parent_permalink; ?>"><?php echo $parent_title; ?></a></li>
							<?php wp_list_pages("title_li=&child_of=$parent&depth=1"); ?>
						</ul>
					</div>
				<?php endif ?>

				<?php
					/* When we call the dynamic_sidebar() function, it'll spit out
					 * the widgets for that widget area. If it instead returns false,
					 * then the sidebar simply doesn't exist, so we'll hard-code in
					 * some default sidebar stuff just in case.
					 */
					if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

				<?php endif; // end primary widget area ?>

			</div>
		</div><!-- #primary .widget-area -->