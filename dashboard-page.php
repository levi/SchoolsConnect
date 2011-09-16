<?php
/**
 * Template Name: Dashboard
 *
 * Dashboard for school logins
 *
 */

get_header(); ?>

<div id="content" role="main">
	<?php if (!is_user_logged_in()): ?>
		<?php if ( has_post_thumbnail() ): ?>
			<div id="login_image" style="background: url(
			<?php echo (preg_match('~\bsrc="([^"]++)"~', get_the_post_thumbnail(get_the_ID(), 'page-spread'), $matches)) ? $matches[1] : ''; ?>) no-repeat 0 0;">
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
			</div>
		<?php endif ?>
	<?php else: ?>
		<div id="social_page">
			<div class="loading">
				<img src="<?php bloginfo('stylesheet_directory') ?>/images/social/profile_loader.gif" alt="Loading..." />
			</div>
		</div>
	<?php endif; ?>
</div>

<?php if (is_user_logged_in()): ?>
<!-- Templates -->

<script type="text/template" id="template-school">
	<a href="/teamup#school/<%= id %>">
		<img src="<?php bloginfo('stylesheet_directory') ?><% if (image) { %>/lib/slir/w210-h157-c210:157/wp-content/uploads/profile_photos/<%= image %><% } else { %>/images/social/thumb_placeholder.png<% } %>" alt="<%= name %>" />
		<strong class="name"><%= name %></strong>
		<% if (city) { %>
			<span class="location"><%= city %>, <%= state %></span>
		<% } %>
	</a>
</script>

<script type="text/template" id="template-school-list">
	<div id="schools">
		<div id="school_list">
		</div>
		<% if (more) { %>
			<div class="more">
				<a href="#" title="Click to show more schools">Show More Schools</a>
				<div class="loading">Loading...</div>
			</div>
		<% } %>
	</div>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div id="sidebar">
			<?php $nav_id = $post->ID; $page_name = $post->post_name; $children = new WP_Query( array( 'post_type' => 'page', 'post_parent' => $nav_id, 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) ); ?>
			<?php if ( $children->have_posts() ): ?>
				<?php $x = 0 ?>
				<?php while ( $children->have_posts() ) : $children->the_post(); ?>
					<?php $x++ ?>
					<div id="child-post-<?php the_ID(); ?>" class="widget post childpost <?php echo ( $x % 2 == 0 ) ? 'even' : 'odd'; ?>">
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
						<?php the_excerpt(); ?>
					</div><!-- #child-post-## -->
				<?php endwhile ?>
			<?php endif; wp_reset_postdata(); ?>
		</div>
	<?php endwhile; endif; ?>
</script>

<script type="text/template" id="template-modal">
	<div class="social_overlay"></div>
	<div class="editor_pane">
		<div class="toolbar">
			<a href="#" class="left cancel">Cancel</a>
		</div>
		<div class="editor">
		</div>
	</div>
</script>

<script type="text/template" id="template-profile">
	<div class="main_content">
	</div>
</script>

<script type="text/template" id="template-image-url">
<?php bloginfo('stylesheet_directory') ?><% if (image) { %>/lib/slir/w264-h198-c264:198/wp-content/uploads/profile_photos/<%= image %><% } else { %>/images/social/thumb_placeholder.png<% } %>
</script>

<script type="text/template" id="template-profile-photo">
	<h1><%= name %></h1>
	<div id="profile_image">
		<% if (is_admin) { %>
			<div class="change_image">Change Image</div>
		<% } %>
		<img src="<?php bloginfo('stylesheet_directory') ?><% if (image) { %>/lib/slir/w264-h198-c264:198/wp-content/uploads/profile_photos/<%= image %><% } else { %>/images/social/thumb_placeholder.png<% } %>" alt="<%= name %>" />
		<span class="arrow"></span>
	</div>
</script>

<script type="text/template" id="template-photo-modal">
	<div class="modal-overlay">
		<div class="modal-toolbar">
			<a href="#" class="left close">&larr; Back to your school's profile</a>
		</div>
		<div class="modal-page">
			<h2>Upload a new profile photo from your computer</h2>
			<div class="left">
				<img src="<?php bloginfo('stylesheet_directory') ?><% if (image) { %>/lib/slir/w264-h198-c264:198/wp-content/uploads/profile_photos/<%= image %><% } else { %>/images/social/thumb_placeholder.png<% } %>" alt="<%= name %>" />
				<div class="loader"></div>
			</div>

			<div class="right">
				<form action="<?php bloginfo('stylesheet_directory') ?>/photo_upload.php" method="post" enctype="multipart/form-data" encoding="multipart/form-data">
					<p>
						<input name="userfile" id="userfile" type="file" />	
					</p>
					<p class="submit">
						<input type="submit" value="Upload Photo" />
					</p>
					<em>By uploading an image you certify that you have the right to distribute it and that it does not contain any violent or pornographic material.</em>
				</form>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="template-profile-info">
	<div id="meta-info">
		<h3>More info</h3>

		<% if (address) { %>
			<table>
				<tr>
					<th>Address</th>
					<td>
						<%= address %><br />
						<% if (address_2) { %><%= address_2 %><br /><% } %>
						<%= city %>, <%= state %> <%= zipcode %>
					</td>
				</tr>

				<% if (advisor) { %>
					<tr>
						<th>Club Advisor</th>
						<td><%= advisor %></td>
					</tr>
				<% } %>

				<% if (leaders.length !== 0) { %>
					<tr>
						<th>Club Leaders</th>
						<td>
							<% for (var i = 0; i < leaders.length; i++) { %>
								<%= leaders[i] %><% if (i !== leaders.length - 1) { %><br /><% } %>
							<% } %>
						</td>
					</tr>
				<% } %>

				<% if (members.length !== 0) { %>
					<tr>
						<th>Club Members</th>
						<td>
							<% for (var i = 0; i < members.length; i++) { %>
								<%= members[i] %><% if (i !== members.length - 1) { %><br /><% } %>
							<% } %>
						</td>
					</tr>
				<% } %>
			</table>
		<% } else { %>
			<div class="none">
				<span>This school has not added any information</span>
			</div>
		<% } %>
	</div>
</script>

<script type="text/template" id="template-projects-list">
	<header>
		<h3>School Projects</h3>
		<% if (is_admin) { %>
			<a href="#" class="create-project">Create New Project</a>
		<% } %>
	</header>

	<ul class="project-list"></ul>
</script>

<script type="text/template" id="template-project">
	<span class="project"><%= name %></span>
	<span class="amount-raised">$<%= amount %></span>
	<a href="#" class="destroy">x</a>
</script>

<script type="text/template" id="template-blank-project">
	<li class="none">This school has not posted any projects</li>
</script>

<script type="text/template" id="template-project-editor">
	<div class="modal-overlay">
		<div class="modal-toolbar">
			<a href="#" class="left cancel">&larr; Cancel</a>
		</div>
		<div class="modal-page editor">
			<h2>Create Project</h2>
			<form action="#" method="post">
				<p>
					<label>Project Name</label>
					<input type="text" name="name" id="project_editor_name" />
				</p>
				<p class="inline">
					<label>Amount Raised</label>
					<span class="symbol">$</span> 
					<span>
						<input type="text" name="amount_dollar" class="numeric" id="project_editor_amount_dollar" />
						<label for="amount_dollar">Dollars</label>
					</span>
					<span class="symbol">.</span>
					<span>
						<input type="text" name="amount_cent" class="numeric" id="project_editor_amount_cent" />
						<label for="amount_cent">Cents</label>
					</span>
				</p>
				<p class="submit">
					<input type="submit" value="Publish Project" />
				</p>
			</form>
		</div>
	</div>
</script>

<script type="text/template" id="template-chart">
	<h3>Money Raised</h3>

	<div id="chart_progress">	
		<div class="meter">
			<% if (notStarted) { %>
				<span class="not_started">No money has been raised, yet!</span>
			<% } %>
			<span class="progress">
			  <% if (completed) { %>
			    <span>$<%= total %> Raised!</span>
			  <% } %>
			</span>
			<span class="amount">$<%= total %></span>
		</div>
		<div class="meter_labels">
			<span class="lines"></span>
			<span class="beginning">$0</span>
			<span class="ending">$<%= goal %></span>
		</div>
	</div>
</script>

<script type="text/template" id="template-updates-list">
	<header>
		<h3>Recent Updates</h3>
		<% if (is_admin) { %>
			<a href="#" class="create-update">Create New Update</a>
		<% } %>
	</header>

	<div class="update-list"></div>

	<div class="more">
		<a href="#" title="Click to load more updates">More</a>
		<div class="loading">Loading...</div>
	</div>
</script>

<script type="text/template" id="template-update">
	<span class="date"><%= formatted_created_at %></span>
	<h2><a href="/teamup#school/<%= school_id %>/update/<%= permalink %>-<%= id %>" title="Click to read <%= title %>"><%= title %></a></h2>
	<p><%= excerpt %></p>
</script>

<script type="text/template" id="template-blank-update">
	<div class="none">This school has not posted any updates</div>
</script>

<script type="text/template" id="template-update-editor">
	<div class="modal-overlay">
		<div class="modal-toolbar">
			<a href="#" class="left cancel">&larr; Cancel</a>
		</div>
		<div class="modal-page editor">
			<h2>Create Project</h2>
			<form action="#" method="post">
				<p>
					<label for="title">Title</label>
					<input type="text" name="title" id="update_editor_title" />
				</p>
				<p>
					<label for="content">Content</label>
					<textarea name="content" id="update_editor_content"></textarea>
				</p>
				<p class="submit">
					<input type="submit" value="Publish Update" />
				</p>
			</form>
		</div>
	</div>
</script>

<script type="text/template" id="template-update-modal">
	<div class="modal-overlay">
		<% if (title) { %>
			<div class="modal-toolbar">
				<a href="#" class="left close">&larr; Back to school's profile</a>
				<a href="#" class="right destroy">Delete</a>
			</div>
			<div class="modal-page">
				<header>
					<span class="entry-date"><%= formatted_created_at %></span>
					<h2 class="entry-title"><%= title %></h2>
				</header>
				<div class="entry-content">
					<%= content %>
				</div>
			</div>
		<% } %>
	</div>
</script>

<!-- /end Templates -->

<?php

get_currentuserinfo();
$table = 'school_info';
$schools = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}{$table} LIMIT 0, 12");

$data = array( 'models' => array() );

if ($schools) {
	$school_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}{$table};" ) );
	$data['total'] = (int) $school_count;
	$data['offset'] = 1;

	foreach ($schools as $school) {
		$data['models'][] = array(
			'id'         => $school->school_id,
			'name'       => $school->name,
			'image'      => $school->image,
			'goal'       => (int) $school->goal,
			'address'    => $school->address,
			'address_2'  => $school->address_2,
			'city'       => $school->city,
			'state'      => $school->state,
			'zipcode'    => (int) $school->zipcode,
			'advisor'    => $school->advisor,
			'leaders'    => empty($school->leaders) ? array() : explode(', ', $school->leaders),
			'members'    => empty($school->members) ? array() : explode(', ', $school->members),
			'is_admin'   => (bool) ($school->school_id == $current_user->ID),
		);
	}
}

$GLOBALS['footer_inline'] = '<script>$(function() { SC.init('.json_encode($data).'); })</script>';
?>
<?php endif; ?>

<?php get_footer(); ?>