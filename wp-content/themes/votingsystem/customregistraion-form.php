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
            <input type="text" name="name" id="name">
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





<?php get_footer(); ?>

