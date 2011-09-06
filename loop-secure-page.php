<?php
/**
 * The loop that displays a page.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php if (!is_user_logged_in()): ?>
		<?php if ( has_post_thumbnail() ): ?>
			<div id="login_image" style="background: url(
			<?php echo (preg_match('~\bsrc="([^"]++)"~', get_the_post_thumbnail(get_the_ID(), 'page-spread'), $matches)) ? $matches[1] : ''; ?>) no-repeat 0 0;">
				<?php switch ($post->post_name) {
					case 'getinvolved': ?>
						<div id="login_info" class="get_involved">
							<div class="title">
								<h2>Get Involved</h2>
							</div>
							<div class="content">
								<p>Fundraising is a vital part of rebuilding children’s lives and there are plenty of fun and creative ways to do it. With SchoolsConnect, you can choose to raise the funds for specific programs and recipients of your choice. You will receive personalized recognition information and photos from the school that received your gift.</p>
								<nav>
									<ul>
										<li><a href="/register">Register Your School</a></li>
										<li><a href="/login?next=getinvolved">Login to Continue &raquo;</a></li>
									</ul>
								</nav>
							</div>
						</div>
					<?php break; ?>
					<?php case 'explore': ?>
						<div id="login_info" class="explore">
							<div class="left">
								<div class="title">
									<h2>Explore</h2>
								</div>
								<div class="content">
									<p>The EXPLORE curriculum will help you create, plan, and lead club meetings, awareness campaigns, and special activities. You’ll develop awareness of the needs of children, and ideas about how you’d like to do to make a difference.</p>
									<nav>
										<ul>
											<li><a href="/register">Register Your School</a></li>
											<li><a href="/login?next=explore">Login to Continue &raquo;</a></li>
										</ul>
									</nav>
								</div>
							</div>

							<div class="right">
								<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pages/explore_graphic.jpg" alt="Explore Info Graphic" />
							</div>
						</div>
					<?php break; ?>
					<?php case 'teamup': ?>
						<div id="login_info" class="team_up">
							<div class="title">
								<h2>Team Up!</h2>
							</div>
							<div class="content">
								<p>New to leading a club? No problem, you will have access to the curriculum and activity calendars of your fellow leaders as you develop an initiative that best fits your club. In addition, you will have the opportunity to stay connected with your fellow club leaders and members through the quarterly video chat forums. You can discuss fundraising strategies and update your group page to document your activities with videos and photos.  </p>
								<nav>
									<ul>
										<li><a href="/register">Register Your School</a></li>
										<li><a href="/login?next=teamup">Login to Continue &raquo;</a></li>
									</ul>
								</nav>
							</div>
						</div>
					<?php break; ?>
					<?php case 'resources': ?>
						<div id="login_info" class="resources">
							<div class="title">
								<h2>Resources</h2>
							</div>
							<div class="content">
								<p>Join the Happy Hearts Fund network team of school clubs and learn how you can help children that have been impacted by a natural disaster. Use the SchoolsConnect Resources to create, plan, and participate in club meetings, awareness campaigns, special activities, and fundraising efforts.</p>
								<nav>
									<ul>
										<li><a href="/register">Register Your School</a></li>
										<li><a href="/login?next=resources">Login to Continue &raquo;</a></li>
									</ul>
								</nav>
							</div>
						</div>
					<?php break; ?>
				<?php } ?>
			</div>
		<?php endif ?>
	<?php else: ?>
		<div id="page_grid">
			<div class="post mainpost" id="post-<?php the_ID() ?>">
				<h1 class="entry-title"><?php the_title(); ?></h1>
 
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div><!-- #post-## -->

			<?php $nav_id = $post->ID; $page_name = $post->post_name; $children = new WP_Query( array( 'post_type' => 'page', 'post_parent' => $nav_id, 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) ); ?>
			<?php if ( $children->have_posts() ): ?>
				<?php $x = 0 ?>
				<?php while ( $children->have_posts() ) : $children->the_post(); ?>
					<?php $x++ ?>
					<div id="child-post-<?php the_ID(); ?>" class="post <?php if ( get_post_meta($nav_id, 'two_column', true) ) : ?>mainpost mainchild<?php else: ?>childpost<?php endif; ?> <?php echo ( $x % 2 == 0 ) ? 'even' : 'odd'; ?>">
						<?php if ( has_post_thumbnail() ): ?>
							<div class="feature_image">
								<?php the_post_thumbnail('sub-page'); ?>
							</div>
						<?php endif ?>
						<h3>
							<a href="<?php the_permalink() ?>" title="Click to view <?php the_title() ?>">
								<?php the_title() ?>
							</a>
						</h3>

						<?php if ($nav_id == 4): ?>
							<span class="count"><?php echo $post->menu_order; ?></span>
						<?php endif ?>

						<?php the_excerpt(); ?>
					</div><!-- #child-post-## -->
				<?php endwhile ?>
			<?php endif; wp_reset_postdata(); ?>

			<?php if ( get_post_meta($nav_id, 'two_column', true) ) : ?>
				<?php dynamic_sidebar( $page_name ); ?>
			<?php endif; ?>
		</div><!-- #page_grid -->
	<?php endif ?>
<?php endwhile; // end of the loop. ?>