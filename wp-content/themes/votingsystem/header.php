<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package votingsystem
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<header id="masthead" class="site-header">
	<nav>
        <div class="container flex">
            <div class="navigation flex">
                <div class="logo">
					<?php if (has_custom_logo()) {
						$custom_logo_id = get_theme_mod('custom_logo');
						$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
						if ($logo) {
							echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '"></a>';
						}
					} else { ?>
						<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt=""></a>
					<?php } ?>
				</div>

                <ul>
                </ul>
            </div>

            <div class="nav-btns">
                <a href="http://localhost/sitevoitngsystem/login-page-form/" id="login-btn" class="btn btn-login t-white btn-2490">Login</a>
                <a href="http://localhost/sitevoitngsystem/registration-form/" class="btn btn-register t-white">Register</a>
            </div>
        </div>
    </nav>
    <div style="height: 80px;"><!-- add this spacer div due to fixed position of nav --></div>
	</header>
