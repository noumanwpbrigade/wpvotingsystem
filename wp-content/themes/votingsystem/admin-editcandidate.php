<?php 
ob_start();
session_start();
include 'header.php';

$id = $_GET['id'];

$get_sql = "SELECT * FROM `candidate` WHERE 	candidateID='{$id}'";
$get_query = mysqli_query($con, $get_sql);
$row = mysqli_fetch_assoc($get_query);

$_SESSION['image'] = $row['image'];


?>

<div class="container flex">
    <div class="right-sidebar">
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="main-content">
                <!-- Edit candidate -->
        <div class="edit-form" id="">
            <form action="" method="post" enctype="multipart/form-data">

                <h3 class="form-title " id="addnew">Edit Candidate</h3>
                <img id="crosse-btn" class="crosse-icon" onclick="closecandidateform();" src="../assets/images/crossicon.png" alt="crosse">

                <!-- Candidate Name -->
                <label for="" class="fb">Name</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/usericon.png" alt="img">
                    <input type="text" name="uname"  class="form-control" value="<?= $row['name']; ?>">
                </div>

                <!-- Candidate CNIC -->
                <label for="" class="fb">CNIC</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/cardicon.png" alt="img">
                    <input type="text" name="ucnic" class="form-control" pattern="^[0-9]{5}-[0-9]{7}-[0-9]{1}$" 
                    title="Type CNIC like 34504-1234567-1" required value="<?= $row['CNIC']; ?>">
                </div>

                <!-- Candidate Party Name -->
                <label for="" class="fb">Party Name</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/flag.png" alt="img">
                    <input type="text" name="upartyname" class="form-control" value="<?= $row['partyName']; ?>">
                </div>

                <!-- Candidate entakhabi neshan -->
                <label for="" class="fb">Entakhabi Neshan</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/imageicon.png" alt="img">
                    <input type="file" name="uimage" class="form-control">
                    <input type="hidden" name="current_image" value="<?= $row['image']; ?>">
                </div>
                <img src="<?= $row['image']; ?>" alt="image" class="edit-img">

                <input type="submit" name="update" class="form-btn" value="Update">
            </form>
        </div>
        <?php
        
        if (isset($_POST['update'])) {
            // collect values from form
            $name = $_POST['uname'];
            $candidatecnic = $_POST['ucnic'];
            $partyname = $_POST['upartyname'];

            $sql = "";
            // if user select new image
            if($_FILES['uimage']['name'] != ""){
                $candi_img = $_FILES['uimage'];

                $imagefilename = $candi_img['name'];
                $imagetmp_name = $candi_img['tmp_name'];

                $imagefile_separate = explode('.', $imagefilename);
                $file_extension = strtolower(end($imagefile_separate));
                $extensions = array('jpeg', 'jpg', 'png');
                if (in_array($file_extension, $extensions)) {
                    $upload_image = 'uploads/' . $imagefilename;
                    move_uploaded_file($imagetmp_name, $upload_image);

                    $sql = "UPDATE `candidate` SET `CNIC`='{$candidatecnic}',`name`='{$name}',
                    `partyName`='{$partyname}',`image`='{$upload_image}'
                    WHERE candidateID='{$id}'";
                    $result = mysqli_query($con, $sql);
                    
                }

                // debuging
                // echo "new image selected";
                // print_r($_FILES['uimage']);
                // echo "<br>";
                // echo $_FILES['uimage']['name'];

            // if user does not select image
            } else {
                $sql = "UPDATE `candidate` SET `CNIC`='{$candidatecnic}',`name`='{$name}',
                    `partyName`='{$partyname}'
                    WHERE candidateID='{$id}'"; 
                    $result = mysqli_query($con, $sql);

                // debuging
                // echo "user go with old image";
            }

            $result = mysqli_query($con, $sql);
    
                    if ($result) {
                        echo "Update data successfully.";
                        header("Location: http://localhost/votingsystem/admin/");
                        exit();
                    } else {
                        echo "Failed to insert data!";
                    } 
                   
                }
            
        ?>
    </div>
</div>







<?php include 'footer.php' ?>