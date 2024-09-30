<?php
session_start();
require 'db.php';

// Example user ID, this would typically come from a login system
$user_id = 1;

// Fetch user data
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch followers count
$followers_stmt = $pdo->prepare('SELECT COUNT(*) FROM followers WHERE user_id = ?');
$followers_stmt->execute([$user_id]);
$followers_count = $followers_stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-pic">
                <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <p><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                <p><strong>Followers:</strong> <?php echo $followers_count; ?></p>
            </div>
        </div>

        <div class="edit-profile">
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="profile_pic">Change Profile Picture:</label>
                <input type="file" name="profile_pic" id="profile_pic">
                
                <label for="bio">Edit Bio:</label>
                <textarea name="bio" id="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
