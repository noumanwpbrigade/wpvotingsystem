<?php
/* Template Name: Registraion Page */

// steps: 1. Assign template to page ✔
// 2. Registration form design and write
// 3. form validation
// 4. create wp user


get_header();
?>

<div class="container">
    <form action="" method="post" class="form">
        <h3 class="tc-primary">Registraion Form</h3>
        <!-- user name -->
        <div class="form-group">
            <label for="name">Username</label> <br>
            <input type="text" name="name" id="name" placeholder="Without Space">
        </div>

        <!-- user email -->
        <div class="form-group">
            <label for="email">Email</label> <br>
            <input type="text" name="email" id="email">
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
            <input type="password" name="password" id="password">
        </div>

        <!-- Confirm password -->
        <div class="form-group">
            <label for="confirmpw">Confirm Password</label> <br>
            <input type="password" name="confirmpw" id="confirmpw">
        </div>

        <input type="submit" name="registerbtn" value="Register" class="submit-btn">

    </form>
</div>

<?php get_footer(); 
// form validation

global $wpdb;

if (isset($_POST['registerbtn'])) {
    // $username = sanitize_text_field($_POST['name']);
    $username = $_POST['name'];
    $email = $_POST['email'];
    $cnic = $_POST['cnic'];
    $password = $_POST['password'];
    $confPassword = $_POST['confirmpw'];

    

    $table_name = $wpdb->prefix . 'voter';

    // Prepare data as an associative array
    $data = array(
        'username' => $username,
        'email'    => $email,
        'cnic'     => $cnic,
        'password' => $password,
    );
    
    // Insert data into the table
    $result = $wpdb->insert($table_name, $data);

    if ($result) {
        echo "<script>alert('Data inserted')</script>";
    } else {
        echo "<script>alert('Data not inserted')</script>";
    }
}


// In WordPress, you don't typically use mysqli_real_escape_string directly because WordPress provides its own database abstraction layer through the global $wpdb object. The $wpdb object includes a method called prepare that you can use to safely prepare SQL queries


?>

