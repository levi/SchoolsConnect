			</div><!-- #main -->
		</div><!-- #wrapper -->

		<div id="footer" role="contentinfo">
			<div class="wrapper">
				<div id="colophon">
					<div id="footer_content">
						<div id="footerlogo"></div>
						<div id="footeraddress">
							2011 SchoolsConnect. All Rights Reserved.<br />
							<strong>Happy Hearts Fund, P.O Box 725. New York, NY 10014</strong>
						</div>
					</div>

					<ul id="footer_links">
						<li>
							<a href="/privacy-policy">Privacy Policy</a>
						</li>
						<li>
							<a href="/blog">Blog</a>
						</li>
						<li>
							<a href="http://happyheartsfund.org/contact.php">Contact Us</a>
						</li>
					</ul>
				</div><!-- #colophon -->
			</div><!-- #wrapper -->
		</div><!-- #footer -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php bloginfo('stylesheet_directory') ?>/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
		<?php wp_footer(); ?>

		<script src="<?php bloginfo('stylesheet_directory') ?>/js/plugins.js"></script>

		<?php if (is_user_logged_in()): ?>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/backbone.js"></script>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/libs/json2.js"></script>
		<?php
			function load_backbone($type)
			{
				$script_dir = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
				$js_dir = $script_dir.'/wp-content/themes/schoolsconnect/js/social/'.$type;
				if ($handle = opendir($js_dir)) {
				    while (false !== ($file = readdir($handle))) {
				    	if ($file != '.' && $file != '..') {
					        echo '<script src="'.get_bloginfo('stylesheet_directory').'/js/social/'.$type.'/'.$file.'"></script>'."\n";
				    	}
				    }
				}
			}
		?>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/fileuploader.js"></script>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/tinymce.js"></script>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/simplemodal.js"></script>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/social/app.js"></script>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/masonry.js"></script>
		<?php load_backbone('models'); ?>
		<?php load_backbone('collections'); ?>
		<?php load_backbone('views'); ?>
		<?php load_backbone('routers'); ?>
		<?php endif ?>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/tooltip.js"></script>
		<script src="<?php bloginfo('stylesheet_directory') ?>/js/common.js"></script>
		<script async src="http://serv1.freetellafriend.com/share_addon.js"></script>

		<?php echo $GLOBALS['footer_inline'] ?>

		<script>
		  var _gaq=[['_setAccount','UA-25176380-1'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>

		<!--[if lt IE 7 ]>
			<script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
			<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
	</body>
</html>