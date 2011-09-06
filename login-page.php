<?php
/**
 * Template Name: Login Page
 *
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

if (is_user_logged_in()) {
  wp_redirect( home_url() );
  exit;
}

get_header(); ?>

    <div id="container">
      <div id="content" class="login" role="main">
        <?php
            $url = get_bloginfo('url'); // used here and in the logout
            $post_to = $url.'/login';

            if ($_GET['next']) {
              $redirect_to = '/'.$_GET['next'];
              $post_to .= '?next='.$_GET['next'];
            }
            else
            {
              $redirect_to = $url;
            }

            if (!is_user_logged_in()){ ?>
              <?php if ($wpmem_regchk == 'loginfailed' && $_POST['slog'] == 'true') { ?>
                <p class="err">
                  <?php _e('Login Failed!<br />You entered an invalid username or password.', 'wp-members'); ?>
                </p>
            <?php }?>
            <fieldset>
              <form name="form" method="post" action="<?php echo $post_to; ?>">
                <p>
                  <label for="username"><?php _e('Username'); ?></label>
                  <input type="text" name="log" class="username" id="username" />
                </p>

                <p>
                  <label for="password"><?php _e('Password'); ?></label>
                  <input type="password" name="pwd" class="password" id="password" />
                </p>

                <input type="hidden" name="rememberme" value="forever" />
                <input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
                <input type="hidden" name="a" value="login" />
                <input type="hidden" name="slog" value="true" />

                <p>
                  <input type="submit" name="Submit" class="buttons" value="<?php _e('login', 'wp-members'); ?>" />
                </p>
                <?php     
                if ( WPMEM_MSURL != null ) { 
                  $link = wpmem_chk_qstr( WPMEM_MSURL ); ?>
                  <a href="<?php echo $link; ?>a=pwdreset"><?php _e('Forgot?', 'wp-members'); ?></a>&nbsp;
                <?php }       
                if ( WPMEM_REGURL != null ) { 
                  $link = wpmem_chk_qstr( WPMEM_REGURL ); ?>
                  <a href="<?php echo $link; ?>"><?php _e('Register', 'wp-members'); ?></a>
                <?php } ?></div>
              </form>
            </fieldset>
          <?php } else { 
            $logout = $url."/?a=logout";
            /*
            This is the displayed when the user is logged in.
            You may edit below this line, but do not
            change the <?php ?> tags or their contents */ ?>
            <p>
              <?php printf(__('You are logged in as %s', 'wp-members'), $user_login );?><br />
              <a href="<?php echo $logout;?>"><?php _e('click here to logout', 'wp-members'); ?></a>
            </p>
          <?php } ?>
      </div><!-- #content -->
    </div><!-- #container -->

<?php get_footer(); ?>
