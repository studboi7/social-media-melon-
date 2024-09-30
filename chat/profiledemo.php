<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user data from the database
$sql = "SELECT * FROM user_profiles WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $bio = $row['bio'];
} else {
    // Handle case where user is not found (unlikely if the session is correct)
    $bio = "Bio not found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melon</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: black;
    overflow-x: hidden;

}
.container {
    max-width: 500px;
    margin: 20px auto;

    background-color: black;
  
    overflow: hidden; 
    position: relative;
}
.header {
  
    color: #fff;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header h1 {
    margin: 0;
}
.logout {
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    background-color: #0056b3;
    transition: background-color 0.3s;
}
.logout:hover {
    background-color: #004080;
}
#setting{
    font-size:2em;
}
h2{
    color:white;
    padding-left:1em;
}
    </style>
    

<div class="container">
    <div class="header">
        <h1><?php echo ucfirst($username); ?></h1> 
        <a href="profiledetails.php" class="logout">Edit Profile</a>
        <i id="setting" class="fa-solid nav__link-icon fa-gear"></i>
    </div>
    <h2><?php echo ucfirst($bio); ?></h2> <!-- Display the bio here -->
</div>

</body>
</html>
