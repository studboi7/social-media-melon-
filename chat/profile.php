<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user details
$sql = "SELECT profile_pic, status FROM users WHERE username='$username'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error fetching user details: " . $conn->error;
}

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a real image
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_pic"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            // Update the profile picture URL in the database
            $profilePicUrl = mysqli_real_escape_string($conn, $target_file);
            $sql = "UPDATE users SET profile_pic='$profilePicUrl' WHERE username='$username'";
            if ($conn->query($sql)) {
                // Update the user profile data
                $user['profile_pic'] = $profilePicUrl;
            } else {
                echo "Error updating profile picture: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $sql = "UPDATE users SET status='$status' WHERE username='$username'";
    if ($conn->query($sql)) {
        // Update the user profile data
        $user['status'] = $status;
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Melon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="home.css"> <!-- Include sidebar styles -->
</head>
<body>
    <nav class="nav">
        <h1 class="logo">Melon</h1>
        <ul class="nav__list">
            <li class="nav__item">
                <a class="nav__link" href="home.php" id="homeLink">
                    <i class="fa-solid nav__link-icon fa-home"></i>
                    <span class="nav__link-txt">Home</span>
                </a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="chat.php" id="openChat">
                    <i class="fa-solid nav__link-icon fa-comment"></i>
                    <span class="nav__link-txt">Messages</span>
                </a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="#">
                    <i class="fa-solid nav__link-icon fa-circle-plus"></i>
                    <span class="nav__link-txt">Post</span>
                </a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="profile.php">
                    <i class="fa-solid nav__link-icon fa-user"></i>
                    <span class="nav__link-txt">Profile</span>
                </a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="#">
                    <i class="fa-solid nav__link-icon fa-gear"></i>
                    <span class="nav__link-txt">Settings</span>
                </a>
            </li>
        </ul>
        <ul class="nav__list nav__list_bottom">
            <li class="nav__item">
                <a class="nav__link" href="logout.php">
                    <i class="fa-solid nav__link-icon fa-right-from-bracket"></i>
                    <span class="nav__link-txt">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="page">
        <div id="root">
            <div class="img-wrap">
                <form method="POST" enctype="multipart/form-data">
                    <label class="img-upload" for="upload">
                        <input id="upload" type="file" name="profile_pic" accept="image/*" />
                        <img src="<?php echo htmlspecialchars($user['profile_pic']) ?: 'https://via.placeholder.com/200'; ?>" alt="Profile Picture" />
                    </label>
                    <button type="submit" class="edit">Upload Picture</button>
                </form>
            </div>
            <div class="field">
                <form method="POST">
                    <input type="text" name="status" placeholder="Status" value="<?php echo htmlspecialchars($user['status']); ?>" />
                    <button type="submit" class="edit">Update Status</button>
                </form>
            </div>
            <div class="name">
                <strong>Username:</strong> <?php echo htmlspecialchars($username); ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
    <script type="text/babel" src="profile.js"></script>
</body>
</html>
