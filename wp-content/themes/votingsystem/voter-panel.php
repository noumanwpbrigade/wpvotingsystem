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
                <span class="c-red"><?php echo $_SESSION['user_data']['hasvoted']; ?></span>
            </div>
        </div>

    </fieldset>
</div>
<!-- Candidate list -->
<div class="container">
    <h2 class="my-15">Candidate List</h2>
    <div class="flex flex-wrap">
        <?php 
        $candidates = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}candidates");
        
        foreach ($candidates as $candidate) { ?>
            <div class="canWrapper flex-column center-center w-50" data-aos="flip-left" data-aos-duration="1000">
                <div class="symbol">
                    <img src="<?php echo $candidate->entakhabineshan; ?>" alt="Neshan">
                </div>
                <div class="party-name my-10"><?php echo $candidate->partyname; ?></div>
                <div class="candidate-name my-10"><?php echo $candidate->candidate_name; ?></div>
                <div class="candidate-name my-10"><?php echo $candidate->votesReceived; ?></div>
                <form action="" method="post" class="m-0" onsubmit="return confirm('After casting your vote, you cannot vote again, and editing your vote. Please confirm by pressing OK.')">
                    <input type="hidden" name="canID" value="<?php echo $candidate->candidateID; ?>">
                    <input type="hidden" name="votes" value="<?php echo $candidate->votesReceived; ?>">
                    <?php if (!isset($_SESSION['hasvoted'])) { ?>
                        <input type="submit" name="vote" value="Vote" class="vote-btn">
                    <?php } else { ?>
                        <button disabled class="vote-btn">Vote</button>
                    <?php } ?>
                </form>
            </div>
        <?php } ?>

        <?php
        if (isset($_POST['vote'])) {
            global $wpdb;

            $id = $_POST['canID'];
            $votevalue = $_POST['votes'];
            $totalVotes = $votevalue + 1;

            // Update the database
            $result = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}candidates SET `votesReceived`='%d' WHERE candidateID = %d", $totalVotes, $id));

            if ($result !== false) {
                // Update session variable
                $_SESSION['hasvoted'] = "yes";

                // update voter status in DB
                $voter_id = $_SESSION['user_data']['id'];
                $update_status = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}voter SET `hasvoted`='Voted' WHERE id = %d", $voter_id));

                // update status in profile
                $_SESSION['user_data']['hasvoted'] = 'Voted';

                // Redirect to the voter panel
                header("Location: http://localhost/sitevoitngsystem/voter-panel/");
                exit(); 
            } else {
                echo "Failed to update votes.";
            }
        }
        ?>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
<?php
get_footer();
?>