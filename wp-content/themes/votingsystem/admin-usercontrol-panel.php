<?php 
/* Template Name: Admin user control panel*/

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
    <title>Voting System</title>
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
            Hi,
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/usericon.png" alt="image" class="profile-image">
        </div>
    </div>
</nav>
<div style="height: 70px;"></div>

<div class="container admin-home-flex">
    <div class="right-sidebar">
        <div class="sidebar-flex">
            <a href="http://localhost/sitevoitngsystem/admin-panel/">Manage Candidates</a>
            <hr>
            <a href="http://localhost/votingsystem/admin/users.php">Voters / Users</a>
        </div>
    </div>

    <div class="main-content">
        <div class="flex">

            <div class="total-users flex"> 
                <div class=" ">
                    <div class="number" data-target="<?php echo $_SESSION['total_voters']; ?>">
                        <?php
                         global $wpdb;
                         $table_name = $wpdb->prefix . 'voter';
                         
                         $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name"));
                         
                         $total_voters = count($results);
                         $_SESSION['total_voters'] = $total_voters;
                         echo $total_voters; // total voted voters
                        ?>
                    </div>               
                </div> 
                <div class="">
                    Total Voter
                </div>
                
            </div> &nbsp; &nbsp;

            <span class="mth-symbol"> - </span> &nbsp; &nbsp;

            <div class="voted-user flex">
                <div class="">
                    <div class="number" data-target="<?php echo $_SESSION['voted_voters']; ?>">
                        <?php
                         global $wpdb;
                         $table_name = $wpdb->prefix . 'voter';
                         
                         $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE hasvoted = %s",'Voted'));
                         
                         $num_rows = count($results);
                         $_SESSION['voted_voters'] = $num_rows;
                         echo $num_rows; // total voted voters
                        ?>
                    </div> 
                </div>
                <div class="">voted</div>
            </div> &nbsp; &nbsp; 

            <span class="mth-symbol"> = </span> &nbsp; &nbsp;

            <div class="remaing-user flex">
                <div class="">
                <div class="number" data-target="<?php 
                                                    $total = $_SESSION['total_voters'];
                                                    $votedd = $_SESSION['voted_voters'];
                                                    $remainings = $total - $votedd ;
                                                    echo $remainings ; ?>" >
                        <?php echo $remainings; ?>
                    </div> 
                </div>
                <div class="">
                    Remaing user
                </div>
            </div> 

        </div>
        <hr>
        <h3 class="color-heading">User Table</h3>

        <table>
            <thead>
                <th>Sr</th>
                <th>ID</th>
                <th>Name</th>
                <th>CNIC</th>
                <th>Password</th>
                <th>Has voted</th>
                <th>Operation</th>
            </thead>
            <tbody>
            <?php
            $voters = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}voter");
            $counter = 0;

            foreach ($voters as $voter) {
                // Display voter information
                $counter++;

                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$voter->id}</td>
                        <td>{$voter->username}</td>
                        <td>{$voter->cnic}</td>
                        <td>{$voter->password}</td>
                        <form action=\"\" method='post' onsubmit='return confirm(\"Are you sure, you want to delete this voter !\")'  class='m-0'>
                        <td>{$voter->hasvoted}</td>
                        <td>
                                <input type='hidden' name='deleteid' value='" . $voter->id . "'>
                                <input type='submit' name='deletecandi' value='Delete' class='btn-danger'>
                            </form>
                        </td>
                    </tr>";
                    $_SESSION['counter'] = $counter;
            }


            if (isset($_POST['deletecandi'])) {
                $id = $_POST['deleteid'];
                $delete_sql = $wpdb->get_results("DELETE FROM {$wpdb->prefix}voter WHERE id = '$id'");
                header("Location: http://localhost/sitevoitngsystem/tracks-user/");
            }

            ?>
            </tbody>

        </table>
    </div>
</div>


</body>
</html>



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

<!-- counter -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const numbers = document.querySelectorAll(".number");
        const speed = 10;

        numbers.forEach(element => {
            const endValue = +element.getAttribute("data-target");
            const increment = Math.ceil(endValue / speed);
            animateCounter(element, endValue, increment);
        });

        function animateCounter(elem, endValue, increment) {
            let currentValue = 0;

            const interval = setInterval(() => {
                currentValue += increment;
                elem.innerText = currentValue;

                if (currentValue >= endValue) {
                    elem.innerText = endValue;
                    clearInterval(interval);
                }
            }, 200); // Adjusted the interval for smoother animation
        }
    });
</script>


    </body>
    </html>