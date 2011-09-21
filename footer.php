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
			<?php
				function load_backbone($type)
				{
					$ret = array();
					$script_dir = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
					$js_dir = $script_dir.'/wp-content/themes/schoolsconnect/js/social/'.$type;
					if ($handle = opendir($js_dir)) {
					    while (false !== ($file = readdir($handle))) {
					    	if ($file != '.' && $file != '..' && $file != '.DS_Store') {
						        $ret[] = 'social/'.$type.'/'.$file;
					    	}
					    }
					}
					return implode(',', $ret);
				}
			?>
			<script src="<?php bloginfo('stylesheet_directory') ?>/min/?b=wp-content/themes/schoolsconnect/js&amp;f=backbone.js,libs/json2.js,fileuploader.js,tinymce.js,masonry.js,social/app.js,<?php echo load_backbone('models'); ?>,<?php echo load_backbone('collections'); ?>,<?php echo load_backbone('views'); ?>,<?php echo load_backbone('routers'); ?>"></script>
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