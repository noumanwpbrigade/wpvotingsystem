<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voting sytem</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<nav>
    <div class="container flex">
        <div class="">
        &nbsp;
        </div>
        <div class="user-image flex">
            Hi,<?php ?>
            <img src="../assets/images/dropdown.png" alt="asdf" class="dropdown" onclick="showbtn();">
            <a href="logout.php" id="logoutbtn">Logout</a>
            <img  src="../assets/images/usericon.png" alt="image" class="profile-image">
            <!-- <img src="<?php ?>" alt="image" class="profile-image"> -->
        </div>
    </div>
</nav>
<div style="height: 45px;"><!-- add this spacer div due to fixed position of nav --></div>


    


