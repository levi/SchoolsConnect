<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<?php if ( !is_user_logged_in() ): ?>
	<div id="site_overview">
		<div class="left">
			<h2>Join student leaders from around the world in creating a SchoolsConnect Club<br />
			on your campus and supporting the work of <span class="orange">Happy Hearts Fund</span>...</h2>
		</div>

		<nav class="right">
			<ul class="btn_nav">
				<li><a href="/get-to-know-us" title="Click to learn more about SchoolsConnect">Learn More &raquo;</a></li>
			</ul>
		</nav>
	</div>
<?php endif ?>

<?php echo do_shortcode('[promoslider width="960px" height="300px"]') ?>

<div id="updates_bar">
	<div class="title">
		<h2>Updates</h2>
	</div>

	<ul class="content">
		<li>The Wat Pattikaram Art Center and Library opens in Thailand</li>
		<li>Computer lab opens at the Santa Rosa School in Peru</li>
		<li>HHF opens Kindergarten at Ecole Nouvelle Zoranje in Haiti</li>
		<li>Trinity High School H.A.N.D.S. Club leaders join HHF summer intern team!</li>
		<li>Track the progress of the Al Munawar Kindergarten on Facebook</li>
	</ul>

  <div id="social_buttons">
    <div class="facebook">
      <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://schoolsconnectclubs.org" send="false" layout="button_count" width="100" show_faces="false" font="arial"></fb:like>
    </div>
    <div class="twitter">
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="HappyHeartsFund">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
  </div>
</div>

<div class="wrapper">
	<div class="left">
		<div id="overview_thumbs">
			<ul>
				<li id="gettoknow_thumb">
					<a href="/get-to-know-us">
						<img src="<?php bloginfo('stylesheet_directory') ?>/images/frontpage/thumbs/gettoknow.jpg" alt="Get to know us" />
						<span class="toolbar">
							<strong>Get to Know Us</strong>
						</span>
					</a>
				</li>
				<li id="startaclub_thumb">
					<a href="http://schoolsconnect.dreamhosters.com/starting-a-club-six-easy-steps/" title="Click to read Start a Club in 6 Steps">
						<img src="<?php bloginfo('stylesheet_directory') ?>/images/frontpage/thumbs/startaclub.jpg" alt="Start a Club in 6 Steps" />
						<span class="toolbar">
							<strong>Start a Club in 6 Steps</strong>
						</span>
					</a>
				</li>
				<li id="programs_thumb">
					<a href="/programs">
						<img src="<?php bloginfo('stylesheet_directory') ?>/images/frontpage/thumbs/programs.jpg" alt="School Programs" />
						<span class="toolbar">
							<strong>School Programs</strong>
						</span>
					</a>
				</li>
				<li id="calendar_thumb">
					<a href="/calendar">
						<img src="<?php bloginfo('stylesheet_directory') ?>/images/frontpage/thumbs/calendar.jpg" alt="Calendar" />
						<span class="toolbar">
							<strong>Calendar</strong>
						</span>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="right">
		<div id="ios_projects">
			<div class="header">
				<div class="status_bar">
					<span>Happy Hearts Fund</span>
				</div>
				<div class="title_bar">
					<h2>Program Projects</h2>
				</div>
			</div>

			<div id="iphone_scroll">
				<div class="content">
					<div class="country">
						<div class="label">
							<h3>Haiti</h3>
						</div>
						<div class="title">
							<strong>Kindergarten at Ecole Nouvelle Zoranje</strong>
						</div>
						<table>
							<tr title="A pair of athletic shoes goes a long way in securing the health of these children that have so little.">
								<td class="type">
									Athletic Shoes
								</td>
								<td class="desc">
									<strong>$1020 USD</strong>
									<small>will provide footware for each student in the school</small>
								</td>
							</tr>
							<tr title="Open the minds and hearts if the students to the world of the arts through providing them with the basics to get started.">
								<td class="type">
									Arts and Music Programming
								</td>
								<td class="desc">
									<strong>$3500 USD</strong>
									<small>will provide arts, crafts or music education and materials for the school for 1 year</small>
								</td>
							</tr>
						</table>
					</div>
					<div class="country">
						<div class="label">
							<h3>Indonesia</h3>
						</div>
						<div class="title">
							<strong>All Indonesian Kindergartens</strong>
						</div>
						<table>
							<tr title="In a climate where the temperature averages close to 100 degrees, the breeze from a fan can help the children remain focused as they learn.">
								<td class="type">
									Fans
								</td>
								<td class="desc">
									<strong>$180 USD</strong>
									<small>will buy and deliver three fans, one for each classroom, to HHF schools.</small>
								</td>
							</tr>
							<tr title="Provide the students with educational materials that are relevant to their culture and communities to help ensure a good educational experience.">
								<td class="type">
									Books
								</td>
								<td class="desc">
									<strong>$125 USD</strong>
									<small>per kindergarten will supply about 50 books for children to read</small>
								</td>
							</tr>
							<tr title="Providing the students with drinking water keeps them refreshed and focused as they concentrate on their studies.">
								<td class="type">
									Drinking Water
								</td>
								<td class="desc">
									<strong>$55 USD</strong>
									<small>Water Dispenser to hold the aqua bottle</small>
								</td>
							</tr>
							<tr title="Providing the opportunity for students to purchase pencils, pens, notebooks, and other basics on campus produces revenue that benefits student programs.">
								<td class="type">
									Schools Supply Kiosk
								</td>
								<td class="desc">
									<strong>$350 USD</strong>
									<small>per kindergarten will buy initial supplies to set up kiosk</small>
								</td>
							</tr>
							</table>						
					</div>
					<div class="country">
						<div class="label">
							<h3>Mexico</h3>
						</div>
						<div class="title">
							<strong>All Mexico Schools</strong>
						</div>
						<table>
							<tr title="Stock the library with new books and provide the children with an enriched learning experience through reading.">
								<td class="type">
									Library Books
								</td>
								<td class="desc">
									<strong>$1000 USD</strong>
									<small>will buy 50 to 125 books, depending on age and grade level.</small>
								</td>
							</tr>
							<tr title="Your help with providing the basics will quickly translate into giving the students the opportunity to a stronger future.">
								<td class="type">
									School Supplies
								</td>
								<td class="desc">
									<strong>$300 USD</strong>
									<small>will bring useful supplies of pencils, erasers, paper, colors, art and study supplies</small>
								</td>
							</tr>
							<tr title="Your gift of backpacks will send the students out with confidence as they embrace the opportunities that come with an education.">
								<td class="type">
									Backpacks
								</td>
								<td class="desc">
									<strong>$2500 USD</strong>
									<small>will provide each student with a place to store and carry their books and school materials</small>
								</td>
							</tr>
							</table>						
					</div>
					<div class="country">
						<div class="label">
							<h3>Peru</h3>
						</div>
						<div class="title">
							<strong>All Peru Schools</strong>
						</div>
						<table>
							<tr title="Stock the library with new books and provide the children with an enriched learning experience through reading.">
								<td class="type">
									Library Books
								</td>
								<td class="desc">
									<strong>$1000 USD</strong>
									<small>will buy 50 to 125 books, depending on age and grade level.</small>
								</td>
							</tr>
						</table>						
					</div>
				</div>
			</div>

			<div class="toolbar">
				<ul>
					<li class="programs">
						<a href="/programs"><span>Programs</span></a>
					</li>
					<li class="exchange">
						<a href="http://www.xe.com/" title="Click to check price exchange rate."><span>Exchange</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>