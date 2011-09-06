<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
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
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/plugins.js"></script>

<?php if (is_user_logged_in()): ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/backbone.js"></script>
<?php
	function load_backbone($type)
	{
		$script_dir = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
		$js_dir = $script_dir.'/wp-content/themes/schoolsconnect/js/social/'.$type;
		if ($handle = opendir($js_dir)) {
		    while (false !== ($file = readdir($handle))) {
		    	if ($file != '.' && $file != '..') {
			        echo '<script type="text/javascript" src="'.get_bloginfo('stylesheet_directory').'/js/social/'.$type.'/'.$file.'"></script>'."\n";
		    	}
		    }
		}
	}
?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/fileuploader.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/tinymce.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/simplemodal.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/social/app.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/masonry.js"></script>
<?php load_backbone('models'); ?>
<?php load_backbone('collections'); ?>
<?php load_backbone('views'); ?>
<?php load_backbone('routers'); ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/social/init.js"></script>
<?php endif ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/tooltip.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/common.js"></script>
<script type="text/javascript" async src="http://serv1.freetellafriend.com/share_addon.js"></script>

<?php echo $GLOBALS['footer_inline'] ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25176380-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
