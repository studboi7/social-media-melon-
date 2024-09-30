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
    <title>Melon</title>
    <!-- <link rel="stylesheet" href="style.css"> -->

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
    /* margin: 20px auto; */

    background-color: black;
    border: 3px solid white;
    overflow: hidden; 
    position: relative;
}
.header {
    background-color:grey;
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
.chat-box {
    display: block;
    position: fixed;
    bottom: 50px;
    right: 100px;
    width: 50em;
    height: 45em;
    border-radius: 10px;
    background-color: black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
   border:2px solid white;
}
.chat-box-header {
    background-color: white;
    color: black;
    padding: 15px;
    border:1px solid white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-box-header h2 {
    margin: 0;
}
.close-btn {
    color: black;
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 30px;
}
.close-btn:hover {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
}
.chat-box-body {
    padding: 20px;
    overflow-y: auto;
    height: 300px;
    height: 65%;
}
.message {
    background-color: #f2f2f2;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 10px;
    max-width: 80%;
    word-wrap: break-word;
}
.message p {
    margin: 5px 0;
}
.chat-form {
    padding: 10px;
    border-top: 1px solid #ccc;
    background-color: #f9f9f9;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    bottom: 0;
    width: calc(100% - 20px);
    left: 0px;
}
.chat-form input[type="text"] {
    width: calc(100% - 70px);
    padding: 10px;
    margin-right: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.chat-form button {
    background-color: #0084ff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}
.chat-form button:hover {
    background-color: #0056b3;
}

@media only screen and (max-width: 600px) {
    .container {
        max-width: 100%;
        border-radius: 0;
    }
    .header {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .chat-box {
        width: calc(100% - 40px);
        left: 20px;
        right: auto;
    }
    .chat-form {
        width: calc(100% - 20px);
        left: 10px;
    }
}

.chat-box-body::-webkit-scrollbar {
    display: none;
}

.account-info {
    padding: 20px;
    background-color: black;
    border-radius: 10px;
    margin-bottom: 20px;
}



.user-list h2 {
    margin-top: 20px;
    margin-bottom: 10px;
    color: white;
}

.user-list ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.user-list ul li {
    margin-bottom: 10px;
    background-color: black;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.user-list ul li:hover {
    transform: translateY(-3px);
}

.user-list ul li a {
    display: block;
    padding: 15px;
    text-decoration: none;
    color: white;
    font-size:1.5em
}

.user-list ul li a:hover {
    background-color: #5a5050;
}


    </style>
    
<div class="container">
    <div class="header">
        <h1><?php echo ucfirst($username); ?></h1>
        <a href="home1.php" class="logout">Back</a>
    </div>
    <div class="account-info">
      
        <div class="user-list">
            <h2>Messages:</h2>
            <ul>
                <?php 
                $sql = "SELECT username FROM users WHERE username != '$username'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $user = $row['username'];
                        $user = ucfirst($user);
                        echo "<li><a href='chat.php?user=$user'>$user</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <?php if ($showChatBox): ?>
    <div class="chat-box" id="chat-box">
        <div class="chat-box-header">
            <h2><?php echo ucfirst($selectedUser); ?></h2>
            <button class="close-btn" onclick="closeChat()">✖</button>
        </div>
        <div class="chat-box-body" id="chat-box-body">
        </div>
        <form class="chat-form" id="chat-form">
            <input type="hidden" id="sender" value="<?php echo $username; ?>">
            <input type="hidden" id="receiver" value="<?php echo $selectedUser; ?>">
            <input type="text" id="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</div>
<?php endif; ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    function closeChat() {
        document.getElementById("chat-box").style.display = "none";
    }


    function toggleChatBox() {
    var chatBox = document.getElementById("chat-box");
    if (chatBox.style.display === "none") {
        chatBox.style.display = "block"; 
    } else {
        chatBox.style.display = "none"; 
    }
}


function fetchMessages() {
            var sender = $('#sender').val();
            var receiver = $('#receiver').val();
            
            $.ajax({
                url: 'fetch_messages.php',
                type: 'POST',
                data: {sender: sender, receiver: receiver},
                success: function(data) {
                    $('#chat-box-body').html(data);
                    scrollChatToBottom();
                }
            });
        }


        function scrollChatToBottom() {
            var chatBox = $('#chat-box-body');
            chatBox.scrollTop(chatBox.prop("scrollHeight"));
        }

 
        
        $(document).ready(function() {
            
            fetchMessages();
            setInterval(fetchMessages, 3000);
        });


            $('#chat-form').submit(function(e) {
            e.preventDefault();
            var sender = $('#sender').val();
            var receiver = $('#receiver').val();
            var message = $('#message').val();

            $.ajax({
                url: 'submit_message.php',
                type: 'POST',
                data: {sender: sender, receiver: receiver, message: message},
                success: function() {
                    $('#message').val('');
                    fetchMessages(); 
                }
            });

            });


</script>
    
</body>
</html>