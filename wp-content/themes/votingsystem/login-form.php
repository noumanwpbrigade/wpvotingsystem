<?php
/* Template Name: Login Page */

ob_start();
get_header();
session_start();

if (isset($_SESSION['user_data'])) {
    header("location: http://localhost/sitevoitngsystem/voter-panel/");
    exit();
}

?>

<div class="container">
    <form  method="post" class="form">
    <h3 class="tc-primary">Login Form</h3>
    <p class="description">Login here Using Email & Password</p>

        <!-- user email -->
        <div class="form-group">
            <label for="email">Email</label> <br>
            <input type="text" name="lemail" id="email" required >
        </div>

        <!-- password -->
        <div class="form-group">
            <label for="password">Password</label> <br>
            <input type="password" name="lpassword" id="password" required >
        </div>

        <div class="form-group">
            <label for="radio">Login as a</label> <br>
            <select name="role" id="">
                <option value="voter">Voter</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <input type="submit" name="loginbtn" value="Login" class="submit-btn">
    </form>
</div>

<?php
get_footer();

if (isset($_POST['loginbtn'])) {
    $lemail = sanitize_text_field($_POST['lemail']);
    $lpassword = sanitize_text_field(sha1($_POST['lpassword']));
    $role = sanitize_text_field($_POST['role']);


    global $wpdb;
    $table_name = $wpdb->prefix . 'voter';

    if( $role == 'voter') {

        $sql_email_pw = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s AND password = %s", $lemail, $lpassword));

        if ($sql_email_pw) {
            // Login successful

            // Make an array to store specific user data id, name, email, pw then save it in session variable to disply in voter panel
            $user_data = array(
                'id' => $sql_email_pw->id,
                'username' => $sql_email_pw->username,
                'email' => $sql_email_pw->email,
                'cnic' => $sql_email_pw->cnic,
                'password' => $sql_email_pw->password,
                'hasvoted' => $sql_email_pw->hasvoted,
                'role' => $sql_email_pw->role
            );

            $_SESSION['user_data'] = $user_data;
            
            header("location: http://localhost/sitevoitngsystem/voter-panel/");
            exit(); 
        } else {
            // Invalid email or password
            echo '<p class="error-message">Invalid email or password. Please try again.</p>';
        }
    } elseif( $role == 'admin' )  {
        // admin login
        $admin_role = 1;
        $sql_email_pw = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s AND password = %s AND role = %s", $lemail, $lpassword, $admin_role));

        if ($sql_email_pw) {
            // Login successful

            // Make an array to store specific user data id, name, email, pw then save it in session variable to disply in voter panel
            $user_data = array(
                'id' => $sql_email_pw->id,
                'username' => $sql_email_pw->username,
                'email' => $sql_email_pw->email,
                'cnic' => $sql_email_pw->cnic,
                'password' => $sql_email_pw->password,
                'hasvoted' => $sql_email_pw->hasvoted,
                'role' => $sql_email_pw->role

            );

            $_SESSION['user_data'] = $user_data;
            
            $adminpanel = get_template_directory_uri() . "/admin-index.php";
            // header("location: {$adminpanel}");
            header("location: http://localhost/sitevoitngsystem/admin-panel/");

        } else {
            // Invalid email or password
            echo '<p class="error-message">Admin, Invalid email or password. Please try again.</p>';
        }
        
    }
}
