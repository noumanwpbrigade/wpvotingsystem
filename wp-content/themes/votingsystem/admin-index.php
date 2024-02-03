<?php 
/* Template Name: Admin Panel*/

ob_start();
session_start();
wp_head();
if (!isset($_SESSION['user_data'])) {
    header("location: http://localhost/sitevoitngsystem/login-page-form/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voting sytem</title>
</head>
<body>

<nav>
    <div class="container flex">
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
        <div class="user-image flex">
            Hi,<?php echo $_SESSION['user_data']['username']; ?>
            <img  src="<?php echo get_template_directory_uri(); ?>/assets/images/usericon.png" alt="image" class="profile-image">
            
        </div>
    </div>
</nav>
<div style="height: 45px;"><!-- add this spacer div due to fixed position of nav --></div>

<div class="container admin-home-flex">
    <div class="right-sidebar">
    <?php 
        // $directory = get_template_directory_uri() . "/admin-sidebar.php";
        // include $directory;
    ?>
        <div class="sidebar-flex">
            <a href="http://localhost/sitevoitngsystem/admin-panel/">Manage Candidates</a>
            <hr>
            <a href="http://localhost/sitevoitngsystem/tracks-user/">Voters / Users</a>
        </div>

    </div>

    <div class="main-content">
       <div class="flex gap-10">
            <!-- Add new candidate -->
            <h3 class="color-heading" id="addnewbtn">Add New</h3>
            <!-- logout form -->
            <form method="post" class="m-0">
                <input type="submit" name="admin-logout" value="Logout" id="admin-logout">
            </form>
            <?php
                    if(isset($_POST['admin-logout'])) {
                        session_start();
                        session_unset();
                        session_destroy();
                        wp_redirect(home_url('/'));
                        exit();
                    }
                ?>
            <!-- logout form end-->
       </div>

        <div class="candidate-form" id="candidate-form">
            <form action="" method="post" enctype="multipart/form-data">

                <h3 class="form-title " id="addnew">Add New Candidate</h3>
                <img id="crosse-btn" class="crosse-icon" onclick="closecandidateform();" src="<?php echo get_template_directory_uri(); ?>/assets/images/crossicon.png" alt="crosse">

                <!-- Candidate Name -->
                <label for="" class="fb">Name</label>
                <div class="form-group">
                    <input type="text" name="candidate_name" class="form-control" placeholder="Enter email" required>
                </div>

                <!-- Candidate CNIC -->
                <label for="" class="fb">CNIC</label>
                <div class="form-group">
                    <input type="text" name="candidate_cnic" class="form-control" pattern="^[0-9]{5}-[0-9]{7}-[0-9]{1}$" 
                    title="Type CNIC like 34504-1234567-1" required placeholder="34501-1234567-1">
                </div>

                <!-- Candidate Party Name -->
                <label for="" class="fb">Party Name</label>
                <div class="form-group">
                    <input type="text" name="partyname" class="form-control" placeholder="Party Name" required>
                </div>

                <!-- Candidate entakhabi neshan -->
                <label for="" class="fb">Entakhabi Neshan</label>
                <div class="form-group">
                    <input type="file" name="entakhabineshan" class="form-control" required>
                </div>

                <input type="submit" name="addnew" class="form-btn" value="Add New">
            </form>
        </div>
        <?php
            if (isset($_POST['addnew'])) {
                // Sanitize and validate form data
                $candidate_name = sanitize_text_field($_POST['candidate_name']);
                $candidate_cnic = sanitize_text_field($_POST['candidate_cnic']);
                $partyname = sanitize_text_field($_POST['partyname']);

                global $wpdb;

                // CNIC already exists or not
                $existing_cnic = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}candidates WHERE candidate_cnic = %s", $candidate_cnic));

                if ($existing_cnic > 0) {
                    echo "<div class=\"flex sms-danger gap-10\" id='message-div'>
                            <p>CNIC already registered, try again !</p>
                            <img onclick=\"closemessage();\" src=\"" . get_template_directory_uri() . "/assets/images/menu-close-icon.png\" alt=\"close\">
                        </div>";
                } else {
                    // Handle file upload
                    $upload_dir = wp_upload_dir();
                    $upload_subdir = '/' . date('Y/m');

                    // Create the full path for the uploaded image
                    $full_path = $upload_dir['basedir'] . $upload_subdir; // Used $upload_dir['basedir'] instead of $upload_dir['path'] to get the full server path.
                    if (!file_exists($full_path)) {
                        wp_mkdir_p($full_path); 
                    }

                    $entakhabineshan = $upload_dir['baseurl'] . $upload_subdir . '/' . basename($_FILES['entakhabineshan']['name']);
                    move_uploaded_file($_FILES['entakhabineshan']['tmp_name'], $full_path . '/' . basename($_FILES['entakhabineshan']['name']));

                    // Insert data into custom table
                    $wpdb->insert(
                        $wpdb->prefix . 'candidates',
                        array(
                            'candidate_name'    => $candidate_name,
                            'candidate_cnic'    => $candidate_cnic,
                            'partyname'         => $partyname,
                            'entakhabineshan'   => $entakhabineshan,
                        )
                    );

                    // Redirect after successful insertion
                    $redirect_url = home_url('/'); // Change this to the desired success page URL
                    header("Location: http://localhost/sitevoitngsystem/admin-panel/");
                    exit();
                    echo "<div class=\"flex sms-success gap-10\" id='message-div'>
                            <p>Candidate Add Successfully.</p>
                            <img onclick=\"closemessage();\" src=\"<?php echo get_template_directory_uri(); ?>/assets/images/menu-close-icon.png\" alt=\"close\">
                        </div>";
                }
            }
        ?>
            
        <hr>
        <!-- Candidate list -->
        <h3 class="color-heading">List of All Candidate</h3>

        <table>
            <thead>
                <th>Sr</th>
                <th>ID</th>
                <th>Name</th>
                <th>CNIC</th>
                <th>Part Name</th>
                <th>Image</th>
                <th>Votes Received</th>
                <th>Operation</th>
            </thead>
            <tbody>
           <?php
            $candidates = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}candidates" );
            $counter = 0;

            foreach ( $candidates as $candidate ) {
                // Display candidate information
                $counter++;

                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$candidate->candidateID }</td>
                        <td>{$candidate->candidate_name}</td>
                        <td>{$candidate->candidate_cnic}</td>
                        <td>{$candidate->partyname}</td>
                        <td><img src='{$candidate->entakhabineshan	}' alt='Entakhabi Neshan' width='50px' height='50px'></td>
                        <td>{$candidate->votesReceived}</td>
                        <td>
                            <form class='m-0' action=\"\" method='post' onsubmit='return confirm(\"Are you sure, you want to delete this candidate !\")'>
                                <input type='hidden' name='deleteid' value='" . $candidate->candidateID . "'>
                                <input type='submit' name='deletecandi' value='Delete' class='btn-danger'>
                            </form>
                        </td>
                    </tr>";
            }
            if(isset($_POST['deletecandi'])){
                $id = $_POST['deleteid'];
                $delete_sql =$wpdb->get_results("DELETE FROM {$wpdb->prefix}candidates WHERE candidateID = '$id'");
                header("Location: http://localhost/sitevoitngsystem/admin-panel/");
            }
            

            ?>
           </tbody>
           
           
        </table>
        
    </div>
</div>


<footer>
    <div class="container t-center">
        <p>
        Copyrights &#169; <?php echo date("Y"); ?> . All rights reserved. Developed by: Team WPBrigade
        </p>
    </div>
</footer>

<script>
    // show hide Add New Candidat form
    let addbutton = document.getElementById('addnewbtn');
    let candidateform = document.getElementById('candidate-form');

    addbutton.addEventListener('click', () => {
        candidateform.classList.add('candidate-active');
    });

    // close button
    function closecandidateform() {
        candidateform.classList.remove('candidate-active');
    }
    // close success, failed message

    var messagediv = document.getElementById('message-div');

    function closemessage() {
        messagediv.style.display = 'none';
    }
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/admin-script.js"></script>


    </body>
    </html>