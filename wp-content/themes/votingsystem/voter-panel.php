<?php
/* Template Name: Voter Panel */

ob_start();
wp_head();
session_start();
 
if (!isset($_SESSION['user_data'])) {
    header("location: http://localhost/sitevoitngsystem/login-page-form/");
    exit();
}
?>

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

            <div class="nav-btns flex">
                <p>Hello,
                    <?php 
                    if(isset($_SESSION['user_data'])) {
                        echo $_SESSION['user_data']['username'];
                    }
                    ?>
                </p>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dropdown.png" alt="asdf" class="dropdown" onclick="showbtn();">
                <form method="post" id="logout-form">
                    <button type="submit" name="logout" id="logoutbtn">Logout</button>
                </form>
                <img src="" alt="" class="profile-picture">

                <!-- logout code -->
                <?php
                if(isset($_POST['logout'])) {
                    session_start();
                    session_unset();
                    session_destroy();
                    wp_redirect(home_url('/'));
                    exit();
                }
                ?>
            </div>

        </div>
    </nav>
    <div style="height: 80px;"><!-- add this spacer div due to fixed position of nav --></div>
</header>

<!-- profile section  -->
<div class="container">
    <fieldset class="flex">
        <legend>Profile</legend>
        <div class="profile-left">
            <img src="" alt="img" class="second-profile-img">
        </div>
        <div class="profile-right">
            <div class="detail-group">
                <span class="fb">User Name:</span>
                <span><?php echo $_SESSION['user_data']['username']; ?></span>
            </div>

            <div class="detail-group">
                <span class="fb">User Email:</span>
                <span><?php echo $_SESSION['user_data']['email']; ?></span>
            </div>

            <div class="detail-group">
                <span class="fb">Registered CNIC:</span>
                <span><?php echo $_SESSION['user_data']['cnic']; ?></span>
            </div>

            <div class="detail-group">
                <span class="fb">Status:</span>
                <span><?php echo $_SESSION['user_data']['hasvoted']; ?></span>
            </div>
        </div>

    </fieldset>
</div>

<!-- candidate list -->

<?php
get_footer();
?>
