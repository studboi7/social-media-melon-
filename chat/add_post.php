<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif','mp4'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $fileName;

            if (file_exists($uploadFileDir) && is_writable($uploadFileDir)) {
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "chat";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $imagePath = $dest_path;

                    $sql = "INSERT INTO posts (title, content, image) VALUES ('$title', '$content', '$imagePath')";

                    $conn->query($sql);
                    $conn->close();
                }
            }
        }
    }
    header("Location: home.php");
    exit();
}
?>
