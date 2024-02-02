<?php 
ob_start();
include(get_template_directory_uri() . "/admin/header.php");


?>

<div class="container admin-home-flex">
    <div class="right-sidebar">
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="main-content">
        <!-- Add new candidate -->
        <h3 class="color-heading" id="addnewbtn">Add New</h3>
        <div class="candidate-form" id="candidate-form">
            <form action="" method="post" enctype="multipart/form-data">

                <h3 class="form-title " id="addnew">Add New Candidate</h3>
                <img id="crosse-btn" class="crosse-icon" onclick="closecandidateform();" src="../assets/images/crossicon.png" alt="crosse">

                <!-- Candidate Name -->
                <label for="" class="fb">Name</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/usericon.png" alt="img">
                    <input type="text" name="candidate_name" class="form-control" placeholder="Enter email">
                </div>

                <!-- Candidate CNIC -->
                <label for="" class="fb">CNIC</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/cardicon.png" alt="img">
                    <input type="text" name="candidate_cnic" class="form-control" pattern="^[0-9]{5}-[0-9]{7}-[0-9]{1}$" 
                    title="Type CNIC like 34504-1234567-1" required placeholder="34501-1234567-1">
                </div>

                <!-- Candidate Party Name -->
                <label for="" class="fb">Party Name</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/flag.png" alt="img">
                    <input type="text" name="partyname" class="form-control" placeholder="Party Name">
                </div>

                <!-- Candidate entakhabi neshan -->
                <label for="" class="fb">Entakhabi Neshan</label>
                <div class="form-group">
                    <img class="icon" src="../assets/images/imageicon.png" alt="img">
                    <input type="file" name="entakhabineshan" class="form-control">
                </div>

                <input type="submit" name="addnew" class="form-btn" value="Add New">
            </form>
        </div>
        <?php
        
        if (isset($_POST['addnew'])) {
            // collect values from form
            $name = $_POST['candidate_name'];
            $candidatecnic = $_POST['candidate_cnic'];
            $partyname = $_POST['partyname'];

            $candi_img = $_FILES['entakhabineshan'];

            $imagefilename = $candi_img['name'];
            $imagetmp_name = $candi_img['tmp_name'];

            $imagefile_separate = explode('.', $imagefilename);
            $file_extension = strtolower(end($imagefile_separate));

            // CNIC verification
            $sql_cnic = "SELECT * FROM `candidate` WHERE CNIC='$candidatecnic'";           
            $run_cnic = mysqli_query($con, $sql_cnic);
            $row_cnic = mysqli_num_rows($run_cnic);

            if(!$row_cnic){
                $extensions = array('jpeg', 'jpg', 'png');
                if (in_array($file_extension, $extensions)) {
                    $upload_image = 'uploads/' . $imagefilename;
                    move_uploaded_file($imagetmp_name, $upload_image);
    
                    $sql = "INSERT INTO `candidate`(`CNIC`, `name`, `partyName`, `image`) 
                    VALUES ('$candidatecnic','$name','$partyname','$upload_image')";
                    $result = mysqli_query($con, $sql);
    
                    if ($result) {
                        echo "Data inserted successfully.";
                        // Redirect to prevent form resubmission
                        header("Location: index.php");
                        exit();
                        // The exit() function is then called to ensure that no further code on the current page is executed
                    } else {
                        echo "Data failed to insert!";
                    }
                }
            }
            else {
                echo "<div style='display:inline-block;' id='error-sms-container'>
                        <span>CNIC already exists</span>
                        <img id='close-error' class='crosse-icon' src=\"../assets/images/menu-close-icon.png\" alt='close'>
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
                <th>Operations</th>
            </thead>
            <tbody>
            <?php
            $sql_candidate = "SELECT * FROM `candidate`";
            $run_candidate = mysqli_query($con, $sql_candidate);
            $rows_candidate = mysqli_num_rows($run_candidate);

                if($rows_candidate) {
                    $counter = 1;
                    while($data = mysqli_fetch_assoc($run_candidate)){
                        echo "<tr>
                        <td>" . $counter++ . "</td>
                        <td>" . $data['candidateID'] . "</td>
                        <td>" . $data['name'] . "</td>
                        <td>" . $data['CNIC'] . "</td>
                        <td>" . $data['partyName'] . "</td>
                        <td><img src='" . $data['image'] . "' alt='img' class='symbol_image'></td>
                        <td>" . $data['votesReceived'] . "</td>
                        <td><a href='editcandidate.php?id=" . $data['candidateID'] . "' class='btn-primary'>Edit</a>

                        <form action=\"\" method='post' onsubmit='return confirm(\"Are you sure, you want to delete this candidate !\")' style='display:inline-block;'>
                            <input type='hidden' name='deleteid' value='" . $data['candidateID'] . "'>
                            <input type='submit' name='deletecandi' value='Delete' class='btn-danger'>
                        </form>
                    </tr>";
                    }
                    if(isset($_POST['deletecandi'])){
                        $id = $_POST['deleteid'];
                        $delete_sql ="DELETE FROM `candidate` WHERE 	candidateID = '$id'";
                        $delete_query = mysqli_query($con, $delete_sql);
                        if ($delete_query) {
                            header('Location: index.php');
                            exit(); // prevent further execution
                        }
                        
                    }
                }
                else {
                    echo "<tr>
                            <td colspan=\"7\">No Data Found</td>
                          </tr>";
                }
            ?>
                
            </tbody>
        </table>
        
    </div>
</div>







<?php include 'footer.php'; ?>