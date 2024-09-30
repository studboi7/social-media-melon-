<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $follower_id = $_POST['follower_id'];

    // Check if the user is already following
    $stmt = $pdo->prepare('SELECT * FROM followers WHERE user_id = ? AND follower_id = ?');
    $stmt->execute([$user_id, $follower_id]);

    if ($stmt->rowCount() > 0) {
        // Unfollow
        $stmt = $pdo->prepare('DELETE FROM followers WHERE user_id = ? AND follower_id = ?');
        $stmt->execute([$user_id, $follower_id]);
    } else {
        // Follow
        $stmt = $pdo->prepare('INSERT INTO followers (user_id, follower_id) VALUES (?, ?)');
        $stmt->execute([$user_id, $follower_id]);
    }
}
