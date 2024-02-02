<?php
/* Template Name: Registration Page */

ob_start();
get_header();

?>

<div class="container">
    <form  method="post" class="form">
    <h3 class="tc-primary">Registraion Form</h3>
        <!-- user name -->
        <div class="form-group">
            <label for="name">Username</label> <br>
            <input type="text" name="uname" id="name" required >
        </div>

        <!-- user email -->
        <div class="form-group">
            <label for="email">Email</label> <br>
            <input type="email" name="uemail" id="email" required >
        </div>

        <!-- user cnic -->
        <div class="form-group">
            <label for="cnic">CNIC</label> <br>
            <input type="text" name="cnic" class="form-control" id="cnic"
                pattern="^[0-9]{5}-[0-9]{7}-[0-9]{1}$" title="Type CNIC like 34504-1234567-1" required
                placeholder="34501-1234567-1">
        </div>

        <!-- password -->
        <div class="form-group">
            <label for="password">Password</label> <br>
            <input type="password" name="upassword" id="password" required >
        </div>

        <!-- Confirm password -->
        <div class="form-group">
            <label for="confirmpw">Confirm Password</label> <br>
            <input type="password" name="confirmpw" id="confirmpw" required >
        </div>
        <input type="submit" name="registerbtn" value="Register" class="submit-btn">
    </form>
</div>

<?php
get_footer();

// steps: 1. Assign template to page ✔
// 2. Registration form design and write
// 3. form validation
// 4. create wp user
// $username = sanitize_text_field($_POST['name']);

// form validation
if (isset($_POST['registerbtn'])) {
    $username = $_POST['uname'];
    $email = $_POST['uemail'];
    $cnic = $_POST['cnic'];
    $password = sha1($_POST['upassword']);
    $confirmpw = sha1($_POST['confirmpw']);

    global $wpdb;
    $table_name = $wpdb->prefix . 'voter';

    // CNIC already exists or not
    $existing_cnic = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE cnic = %s", $cnic));

    if ($existing_cnic > 0) {
        echo "<script>alert('CNIC already registered, try again !')</script>";
    } else {
        if ($password !== $confirmpw) {
            echo "<script>alert('Passwords do not match, try agin !')</script>";
        } else {
            // Passwords match, proceed with insertion
            $data = array(
                'username' => $username,
                'email'    => $email,
                'cnic'     => $cnic,
                'password' => $password,
            );

            // Insert data into the table
            $result = $wpdb->insert($table_name, $data);

            if ($result) {
                echo "<script>alert('Your registration is done successfully. Now you can login... ')</script>";
            } else {
                echo "<script>alert('Data not inserted: " . $wpdb->last_error . "')</script>";
                $wpdb->print_error();
            }
        }
    }
}

?>


