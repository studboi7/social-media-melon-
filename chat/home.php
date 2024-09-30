<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Melon</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body class="page">
    <nav class="nav page__nav">
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
                <a class="nav__link" href="#" data-bs-toggle="modal" data-bs-target="#addpost">
                    <i class="fa-solid nav__link-icon fa-circle-plus"></i>
                    <span class="nav__link-txt">Post</span>
                </a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="profiledemo.php">
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

    <!-- Modal -->
    <div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add a Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
               <form id="postForm" method="POST" action="add_post.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="postImage" class="form-label">Image</label>
        <input type="file" class="form-control" id="postImage" name="image" accept="image/*" required>
        <img id="imagePreview" style="display:none;" />
    </div>
    <!-- <div class="mb-3">
        <label for="postBio" class="form-label">Bio</label>
        <textarea class="form-control" id="postBio" name="bio" rows="3" required></textarea>
    </div> -->
    <button type="submit" class="btn btn-primary">Post</button>
</form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <main class="page__main">
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, image, bio FROM posts ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        
        if (!empty($row["image"])) {
            echo "<img src='" . htmlspecialchars($row["image"] ?? '') . "' class='post-image' alt='Post Image'>";
        }
        
        echo "<p class='post-bio'>" . nl2br(htmlspecialchars($row["bio"] ?? '')) . "</p>";
        
        echo "</div>";
    }
} else {
    echo "No posts found.";
}

$conn->close();
?>


    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
