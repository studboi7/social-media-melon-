

<?php
session_start();
error_reporting(0);
?>
<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$username = $_SESSION['username'];
$selectedUser = '';



if (isset($_GET['user'])) {
    $selectedUser = $_GET['user'];
    $selectedUser    = mysqli_real_escape_string($conn, $selectedUser);
    $showChatBox = true; 
} else {
    $showChatBox = false; 
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melon Media</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link rel="stylesheet" href="home.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    lin
</head>
<style>
@import url("https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400&family=Poppins:wght@300;400;500;600&family=Roboto:wght@500&display=swap");
@import url('https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Pacifico&display=swap');
:root {
  --color-primary-hue: 255;
  --light-color-lightness: 95%;
  --dark-color-lightness: 17%;
  --white-color-lightness: 100%;

  --color-dark: hsl(252, 30%, var(--dark-color-lightness));
  --color-light: hsl(252, 30%, var(--light-color-lightness));
  --color-white: hsl(252, 30%, var(--white-color-lightness));
  --color-primary: hsl(var(--color-primary-hue), 75%, 60%);
  --color-gray: hsl(var(--color-primary-hue), 15%, 65%);
  --color-secondary: hsl(252, 100%, 90%);
  --color-success: hsl(120, 95%, 65%);
  --color-danger: hsl(0, 95%, 65%);
  --color-black: hsl(252, 30%, 10%);

  --border-radious: 2rem;
  --card-border-radius: 1rem;
  --btn-padding: 0.6rem 2rem;
  --search-padding: 0.6rem 1rem;
  --card-padding: 1rem;

  --sticky-top-left: 5.4rem;
  --sticky-top-right: -18rem;
}

*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  outline: 0;
  box-sizing: border-box;
  text-decoration: none;
  list-style: none;
  border: none;
}

body {
  font-family: "Poppins", sans-serif;
  color: var(--color-dark);
  background: var(--color-light);
  overflow-x: hidden;
}

.container {
  width: 80%;
  margin: 0 auto;
}

.profile-photo {
  width: 2.7rem;
  aspect-ratio: 1/1;
  border-radius: 50%;
  overflow: hidden;
}

img {
  display: block;
  width: 100%;
}
.logo{
  width: 5rem;
  cursor: pointer;
  
}

.text-bold {
  font-weight: 500;
}

.text-muted {
  color: var(--color-gray);
}

/* ---- Navbar ---- */

nav {
  width: 100%;
  background: var(--color-white);
  position: fixed;
  top: 0;
  z-index: 10;
}
.log{
  -webkit-background-clip: text;
font-size: 36px;
text-align: center;
font-family: "Pacifico", cursive;
font-weight: 300;
font-style: normal;
background-image: linear-gradient(
  to right,
  rgb(108, 186, 108),
  rgb(219, 12, 12)
);
color: transparent;

}
nav .container {
  display: flex;
  
  align-items: center;
  justify-content: space-between;
}

.search-bar {
  justify-content:right ;
  background: var(--color-light);
  border-radius: var(--border-radious);
  padding: var(--search-padding);
  
}

.search-bar input[type="search"] {
  background: transparent;
  width: 30vw;
  margin-left: 1rem;
  font-size: 0.9rem;
  color: var(--color-dark);
}

nav .search-bar input[type="search"]::placeholder {
  color: var(--color-gray);
}

/* ------ Main ----- */

main {
  position: relative;
  top: 5rem;
}

main .container {
  display: grid;
  grid-template-columns: 18vw auto 20vw;
  column-gap: 2rem;
  position: relative;
}

main .container .left {
  height: max-content;
  position: sticky;
  top: var(--sticky-top-left);
}

main .container .left .profile {
  padding: var(--card-padding);
  background: var(--color-white);
  border-radius: var(--card-border-radius);
  display: flex;
  align-items: center;
  column-gap: 1rem;
  width: 100%;
  cursor: pointer;
}

/* ---- Sidebar ---- */

.left .sidebar {
  margin-top: 1rem;
  background: var(--color-white);
  border-radius: var(--card-border-radius);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1)
}

.left .sidebar .menu-item {
  display: flex;
  align-items: center;
  height: 3.6rem;
  cursor: pointer;
  transition: all 300ms ease;
  position: relative;
}

.left .sidebar .menu-item:hover {
  background: var(--color-light);
}

.left .sidebar i {
  font-size: 1.4rem;
  color: var(--color-gray);
  margin-left: 2rem;
  position: relative;
}

.left .sidebar h3 {
  margin-left: 1.5rem;
  font-size: 1rem;
}


/* ---- Feeds ---- */

.middle .feeds .feed {
  background: var(--color-white);
  border-radius: var(--card-border-radius);
  padding: var(--card-padding);
  font-size: 0.85rem;
  line-height: 1.5;
}

.middle .feed .head {
  display: flex;
  justify-content: space-between;
}

.middle .feed .user {
  display: flex;
  gap: 1rem;
}

.middle .feed .photo {
  border-radius: var(--card-border-radius);
  overflow: hidden;
  margin: 0.7rem 0;
}

.middle .feed .action-buttons {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 1.4rem;
  margin: 0.6rem;
}

.middle .liked-by {
  display: flex;
}

.middle .liked-by span {
  width: 1.4rem;
  height: 1.4rem;
  display: block;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid var(--color-white);
  margin-left: -0.6rem;
}

.middle .liked-by span:first-child {
  margin: 0;
}

.middle .liked-by {
  margin-left: 0.5rem;
}

/* ----- RIGHT ----- */

main .container .right {
  height: max-content;
  position: sticky;
  top: var(--sticky-top-right);
  bottom: 0;
}

.right .messages {
  background: var(--color-white);
  border-radius: var(--card-border-radius);
  padding: var(--card-padding);
}

.right .messages .heading {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
}

.right .messages i {
  font-size: 1rem;
}

.right .messages .search-bar {
  display: flex;
  margin-bottom: 1rem;
}

.right .messages .message {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  align-items: start;
}

.right .message .profile-photo {
  position: relative;
  overflow: visible;
}

.right .profile-photo img {
  border-radius: 50%;
}

.right .messages .message:last-child {
  margin: 0;
}

.right .messages .message p {
  font-size: 0.8rem;
}

.right .messages .message .profile-photo .active {
  width: 0.8rem;
  height: 0.8rem;
  border-radius: 50%;
  border: 3px solid var(--color-white);
  background: var(--color-success);
  position: absolute;
  bottom: 0;
  right: 0;
}
.message-body ul {
  text-align:center;
  text-decoration:none;
  padding-left:4em
  
}
/* ==== Theme Customization ==== */

.customize-theme {
  background: rgb(255, 255, 255, 0.5);
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  text-align: center;
  display: grid;
  place-items: center;
  font-size: 0.9rem;
  display: none;
}

.customize-theme .card {
  background: var(--color-white);
  padding: 3rem;
  border-radius: var(--card-border-radius);
  width: 50%;
  box-shadow: 0 0 1rem var(--color-primary);
}

/* ----- Color ----- */

.customize-theme .color {
  margin-top: 2rem;
}

.customize-theme .choose-color {
  background: var(--color-light);
  padding: var(--search-padding);
  border-radius: var(--card-border-radius);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.customize-theme .choose-color span {
  width: 2.2rem;
  height: 2.2rem;
  border-radius: 50%;
}

.customize-theme .choose-color span:nth-child(1) {
  background: hsl(252, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(2) {
  background: hsl(52, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(3) {
  background: hsl(352, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(4) {
  background: hsl(152, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(5) {
  background: hsl(202, 75%, 60%);
}

.customize-theme .choose-color span.active {
  border: 5px solid white;
}

/* ---- Background ---- */

.customize-theme .background {
  margin-top: 2rem;
}

.customize-theme .choose-bg {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
}

.customize-theme .choose-bg > div {
  padding: var(--card-padding);
  width: 100%;
  display: flex;
  align-items: center;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 0.4rem;
  cursor: pointer;
}

.customize-theme .choose-bg > div.active {
  border: 2px solid var(--color-primary);
}

.customize-theme .choose-bg .bg-1 {
  background: white;
  color: hsl(252, 30%, 10%);
}

.customize-theme .choose-bg .bg-2 {
  background: hsl(255, 30%, 17%);
  color: white;
}

.customize-theme .choose-bg .bg-3 {
  background: hsl(255, 30%, 10%);
  color: white;
}

.customize-theme .choose-bg > div span {
  width: 2rem;
  height: 2rem;
  border: 2px solid var(--color-gray);
  border-radius: 50%;
  margin-right: 1rem;
}


        /* User list styles */
        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
            background-color: #333;
            border-radius: 8px;
            padding: 10px;
        }

        ul li a {
            color: white;
            text-decoration: none;
        }

        /* Chat box styles */
        .chat-box {
            position: fixed;
            bottom: 0;
            right: -400px; /* Initially off-screen */
            width: 400px;
            height: 500px;
            background-color: white;
            border: 2px solid black;
            border-radius: 10px;
            transition: right 0.5s ease;
            display: none; /* Hidden initially */
        }

        /* Chat header */
        .chat-box-header {
            background-color: grey;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            
        }

        .close-btn {
            background-color: transparent;
            border: none;
            color: black;
            font-size: 30px;
            cursor: pointer;
        }
  .chat-box-body {
    padding: 10px;
    overflow-y: auto;
    max-height: 300px;

}

.message-sent {
    background-color: red;
    margin: 5px 0;
    padding: 10px;
    border-radius: 5px;
    text-align: right;
    
}

.message-received {
    background-color: #f1f1f1;
    margin: 5px 0;
    padding: 5px;
    border-radius: 5px;
    text-align: left;
}

/* Chat Box Body */
.chat-box-body {
    padding: 10px;
    overflow-y: auto;
    max-height: 300px;
    display: flex; /* Enable flexbox for layout */
    flex-direction: column; /* Stack messages vertically */
}

/* Chat Form */
.chat-form {
    padding: 10px;
    background-color: #fff;
    border: 2px solid black;
    border-radius: 7px;
    position: relative; /* Relative positioning to avoid fixed issues */
    bottom: 0;
}

/* Input Styles */
.chat-form input[type="text"] {
    width: 80%; /* Takes 80% of form width */
    padding: 5px;
}

/* Button Styles */
.chat-form button {
    padding: 5px 10px; /* Add padding to button */
}


/* ===== Media Queries for-> 992px ===== */

@media screen and (max-width: 992px) {
  nav .search-bar {
    display: none;
  }
  .left {
    width: 5rem;
    z-index: 5;
  }

  main .container .left .profile {
    display: none;
  }

  .sidebar h3 {
    display: none;
  }

  .left .btn {
    display: none;
  }

  main .container {
    grid-template-columns: 0 auto 1rem;
    gap: 0;
  }

  main .container .left {
    grid-column: 1/4;
    position: fixed;
    bottom: 0;
    left: 0;
  }

  /* ----- Notification Popup ----- */

  .left .notifications-popup {
    position: absolute;
    left: -20rem;
    width: 20rem;
  }

  .left .notifications-popup::before {
    display: absolute;
    top: 1.3rem;
    left: calc(20rem - 0.6rem);
    display: block;
  }

  main .container .middle {
    grid-column: 1/3;
  }

  main .container .right {
    display: none;
  }

  .customize-theme .card {
    width: 92vw;
  }
}
</style>
<body>
   
    <nav>
        <div class="container">
            
            <img src="melon_nobg.png" alt="logo" class="logo">
            <h2 class="log">
                Melon
            </h2>
        
            <div class="search-bar">
                <i class="uil uil-search"></i>
                <input type="search" placeholder="search for creators, inspirations, and projects">
            </div>
            
            </div>
        </div>
    </nav>

    <!-- Main section -->

    <main>
        <div class="container">
            <div class="left">
                <a class="profile" href="profile.php">
                    <div class="profile-photo">
                        <img src="profile-1.jpg" alt="">
                    </div>
                    <div class="handle">
                        <h4><?php $name =  $_SESSION['username'];
                        echo $name;?></h4>
                        <p class="text-muted"><?php $user =  $_SESSION['username'].'@'.strlen($name);
                        echo $user; ?></p>
                    </div>
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                    <a class="menu-item" href="home.php">
                        <span><i class="uil uil-home"></i></span><h3>Home</h3> 
                    </a>
        
                    <a class="menu-item" id="messages-notification" href="chat.php">
                        <span><i class="uil uil-envelope"></i></span><h3>Messages</h3>
                    </a> 
                  
                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span><h3>Theme</h3>
                    </a>
                    <a class="menu-item" name="setting">
                        <span><i class="uil uil-setting"></i></span><h3>Settings</h3>
                    </a>      
                    <a class="menu-item" href="logout.php">
                        <span><i class="uil uil-sign-in-alt"></i></span><h3>Logout</h3>
                    </a>   
                    
                </div>               
            </div>

            <div class="middle"><?php
            $images = [
   "feed-1.jpg",
   "feed-2.jpg",
   "feed-3.jpg",
   "feed-4.jpg",
   "feed-5.jpg",
   "feed-6.jpg",
   "feed-7.jpg"
];

$randomImage = $images[array_rand($images)];
$randomImage1 = $images[array_rand($images)];
$randomImage2 = $images[array_rand($images)];
$randomImage3 = $images[array_rand($images)];
$randomImage4 = $images[array_rand($images)];
$randomImage5 = $images[array_rand($images)];
$randomImage6 = $images[array_rand($images)];
$randomImage7 = $images[array_rand($images)];

// Display the random image

?>

                <!-- Feeds -->
                <div class="feeds">
                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-12.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Lana Rose</h3>
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage . '";"'; ?> >
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                                <span id="heart1" onclick="toggle1()"><i class="uil uil-heart"></i></span>
                                
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-10.jpg"></span>
                            <span><img src="profile-4.jpg"></span>
                            <span><img src="profile-15.jpg"></span>
                            <p>liked-by <b>2,323 </b></p>
                        </div>
                       
                        <div class="comments text-muted">View all 277 comments</div>
                    </div>

                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-14.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Kumar Boss</h3>
                                    
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage1 . '";"'; ?>>
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                            <span id="heart2" onclick="toggle2()"><i class="uil uil-heart"></i></span>
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-12.jpg"></span>
                            <span><img src="profile-14.jpg"></span>
                            <span><img src="profile-10.jpg"></span>
                            <p>liked-by <b>5,15 </b></p>
                        </div>
                       
                        <div class="comments text-muted">View all 52 comments</div>
                    </div>

                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-2.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Jasmin Roy</h3>
                                    
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage2 . '" ;"'; ?>>
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                            <span id="heart3" onclick="toggle3()"><i class="uil uil-heart"></i></span>
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-5.jpg"></span>
                            <span><img src="profile-6.jpg"></span>
                            <span><img src="profile-7.jpg"></span>
                            <p>liked-by  <b>1,303 </b></p>
                        </div>
                        
                        <div class="comments text-muted">View all 177 comments</div>
                    </div>

                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-16.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Mrinal Santos</h3>
                                   
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage3 . '" ;"'; ?>>
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                            <span id="heart4" onclick="toggle4()"><i class="uil uil-heart"></i></span>
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-10.jpg"></span>
                            <span><img src="profile-4.jpg"></span>
                            <span><img src="profile-15.jpg"></span>
                            <p>liked-by <b>2,023 </b></p>
                        </div>
                        
                        <div class="comments text-muted">View all 270 comments</div>
                    </div>

                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-17.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Samoli Das</h3>
                                    
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage4 . '" ;"'; ?>>
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                            <span id="heart5" onclick="toggle5()"><i class="uil uil-heart"></i></span>
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-10.jpg"></span>
                            <span><img src="profile-12.jpg"></span>
                            <span><img src="profile-5.jpg"></span>
                            <p>liked-by  <b>1,123 </b></p>
                        </div>
                    
                        <div class="comments text-muted">View all 717 comments</div>
                    </div>

                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-18.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Rohon Roy</h3>
                                    
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage5 . '" ;"'; ?>>
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                            <span id="heart6" onclick="toggle6()"><i class="uil uil-heart"></i></span>
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-5.jpg"></span>
                            <span><img src="profile-4.jpg"></span>
                            <span><img src="profile-1.jpg"></span>
                            <p>liked-by <b>2,323 </b></p>
                        </div>
                       
                        <div class="comments text-muted">View all 555 comments</div>
                    </div>

                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <img src="profile-19.jpg" alt="pic">
                                </div>
                                <div class="info">
                                    <h3>Bhola Rose</h3>
                                    
                                </div>
                            </div>
                            <span class="edit">
                                <i class="uil uil-ellipsis-h"></i>
                            </span>
                        </div>

                        <div class="photo">
                            <img <?php echo '<img src="' . $randomImage6 . '" ;"'; ?>>
                        </div>

                        <div class="action-buttons">
                            <div class="interaction-buttons">
                            <span id="heart7" onclick="toggle7()"><i class="uil uil-heart"></i></span>
                                <span><i class="uil uil-comment-dots"></i></span>
                                <span><i class="uil uil-share-alt"></i></span>
                            </div>
                            <div class="bookmark">
                                <span><i class="uil uil-bookmark-full"></i></span>
                            </div>
                        </div>

                        <div class="liked-by">
                            <span><img src="profile-10.jpg"></span>
                            <span><img src="profile-4.jpg"></span>
                            <span><img src="profile-1.jpg"></span>
                            <p>liked-by<b>2,323 </b></p>
                        </div>
                        
                        <div class="comments text-muted">View all 277 comments</div>
                    </div>
                </div>

            </div>

            <div class="right">
                <div class="messages">
                    <div class="heading">
                        <h4>Messages</h4>
                    </div>
                    <!-- search bar -->
                    <div class="search-bar">
                        <i class="uil uil-search"></i>
                        <input type="search" placeholder="Search messages" id="message-search">
                    </div>
                    
                    <!-- message -->
                    <div class="message">
                      
                     
                  
<div class="container1">
    <div class="account-info">
        <div class="user-list">
            <div class="message-body">
                <ul>
                    <?php 
                    $sql = "SELECT username FROM users WHERE username != '$username'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $user = $row['username'];
                            $user = ucfirst($user);
                            echo "<li><a href='#' onclick='openChatBox(\"$user\")'>$user</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </divf>
    </div>
</div>

<!-- Chat Box -->
<div class="chat-box" id="chat-box" style="display: none; right: -400px;">
    <div class="chat-box-header">
        <h2 id="chat-username"></h2>
        <button class="close-btn" onclick="closeChatBox()">✖</button>
    </div>

    <div class="chat-box-body" id="chat-box-body" style="overflow-y: auto; max-height: 300px;">
        <!-- Messages will be appended here -->
    </div>

    <!-- Message input form fixed at the bottom -->
    <form class="chat-form" id="chat-form" style="position: fixed; bottom: 0; width: calc(400px - 20px); padding: 10px;">
        <input type="hidden" id="sender" value="<?php echo $username; ?>">
        <input type="hidden" id="receiver" value="">
        <input type="text" id="message" placeholder="Type your message..." required style="width: 80%;">
        <button type="submit" style="padding: 5px 10px;">Send</button>
    </form>
</div>






    <!-- Theme Customization -->

    <div class="customize-theme">
        <div class="card">
            <h2>Customize your view</h2>
            <p class="text-muted">Manage your font size, color, and background.</p>

          

            <!-- Primary colors -->
            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>

            <!-- Background colors -->
            <div class="background">
                <h4>Background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5>Dim</h5> <!--  for="bg-2" -->
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Lights out</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>

   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    // Function to open the chat box
    function openChatBox(username) {
        // Set the chat box username
        document.getElementById('chat-username').textContent = username;
        document.getElementById('receiver').value = username; // Set receiver

        // Display the chat box and slide it in
        let chatBox = document.getElementById('chat-box');
        chatBox.style.display = 'block'; // Make it visible
        chatBox.style.right = '0'; // Slide in from the right

        // Fetch messages when the chat is opened
        fetchMessages();
    }

    // Function to close the chat box
    function closeChatBox() {
        let chatBox = document.getElementById('chat-box');
        chatBox.style.right = '-400px'; // Slide back out to the right
        setTimeout(() => {
            chatBox.style.display = 'none'; // Hide after sliding out
        }, 500); // Wait for the sliding animation to finish
    }

    // Function to fetch messages
    function fetchMessages() {
        let sender = $('#sender').val();
        let receiver = $('#receiver').val();
        
        if (receiver !== '') {
            $.ajax({
                url: 'fetch_messages.php',
                type: 'POST',
                data: { sender: sender, receiver: receiver },
                success: function(data) {
                    $('#chat-box-body').html(data); // Insert messages
                    scrollChatToBottom(); // Scroll to bottom
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching messages: " + error);
                }
            });
        }
    }

    // Function to scroll the chat to the bottom
    function scrollChatToBottom() {
        let chatBox = $('#chat-box-body');
        chatBox.scrollTop(chatBox.prop("scrollHeight"));
    }

    // Submit form to send a message
    $('#chat-form').submit(function(e) {
        e.preventDefault(); // Prevent form submission refresh
        let sender = $('#sender').val();
        let receiver = $('#receiver').val();
        let message = $('#message').val();

        if (message.trim() !== '') {
            $.ajax({
                url: 'submit_message.php',
                type: 'POST',
                data: { sender: sender, receiver: receiver, message: message },
                success: function() {
                    $('#message').val(''); // Clear input field after sending
                    fetchMessages(); // Fetch messages again after sending
                },
                error: function(xhr, status, error) {
                    console.error("Error sending message: " + error);
                }
            });
        } else {
            alert('Please enter a message before sending.');
        }
    });

    // Ensure messages are fetched every 3 seconds
    $(document).ready(function() {
        setInterval(fetchMessages, 3000);
    });
</script>


    <script src="home.js" ></script>
    
   
</body>
</html>