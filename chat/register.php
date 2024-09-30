<?php 

session_start();
include('db.php');

if (isset($_SESSION['username'])) {
    header("Location: chat.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username already exists";
        } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit();
        } else {
            $error = "Registration failed";
        }

        }
        $stmt->close();

}
$conn->close();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" href="favicon-32x32.png" type="image/png" />
</head>
<body>
    <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
body {
    display: flex;
    padding-left: 5vw;
    align-items: center;
    min-height: 100vh;
    background-color: black;
    background-size: cover;
    background-position: center;
}
video{
    -moz-transform:scale(2);
    -webkit-transform:scale(2);
    -o-transform:scale(2);
    -ms-transform:scale(2);
    transform:scale(2);
  }
  video {
    display: flex;
    width: 55%;
    padding-bottom: 10vh;
    justify-content: left;
    
  }
.form {
    width: 420px;
    background: transparent;
    border: 2px solid white;
    backdrop-filter: blur(9px);
    color: #fff;
    border-radius: 12px;
    padding: 30px 40px;
}
.form h1 {
   background-clip: text;
    font-size: 36px;
    text-align: center;
    font-family: "Pacifico", cursive;
    font-weight: 400;
    font-style: normal;
    background-image: linear-gradient(
      to right,
      rgb(28, 222, 28),
      rgb(219, 12, 12)
    );
    color: transparent;
}
.form .input-box {
    position: relative;
    width: 100%;
    height: 50px;
    margin: 30px 0;
}
.input-box input {
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 40px;
    font-size: 16px;
    color: #fff;
    padding: 1.042vw 2.344vw 1.042vw 1.042vw;
}
.input-box input::placeholder {
    color: #fff;
}
.input-box i {
    position: absolute;
    right: 20px;
    top: 30%;
    transform: translate(-50%);
    font-size: 20px;
}
.form .remember-forgot {
    display: flex;
    justify-content: space-between;
    font-size: 14.5px;
    margin: -15px 0 15px;
}
.remember-forgot label input {
    accent-color: #fff;
    margin-right: 3px;
}
.remember-forgot a {
    color: #fff;
    text-decoration: none;
}
.remember-forgot a:hover {
    text-decoration: underline;
}
.form .btn {
    width: 100%;
    height: 45px;
    background: #fff;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    font-size: 16px;
    color: #333;
    font-weight: 600;
}
.btn:hover {
    text-decoration: underline;
}
.form .register-link {
    font-size: 14.5px;
    text-align: center;
    margin: 20px 0 15px;
}
.register-link p a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
}
.register-link p a:hover {
    text-decoration: underline;
}
@media (max-width: 1000px) {
    .img {
      display: none;
    }
    body {
      flex-direction: column;
      background-image: url(melon.png);
      background-repeat: no-repeat;
      padding-top: 20vh;
    }
    .form {
      backdrop-filter: blur(15px);
    }
}

</style>
<video  autoplay  muted playsinline>
    <source src="logovideo.mp4">
</video>
    <div class="form">
  
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form id="loginForm" method="post">
          <h1>Melon</h1>
          <div class="input-box">
          <input type="text" id="username" name="username" placeholder="USERNAME"required>
          <i class="bx bxs-user"></i>
          </div>
          <div class="input-box">
        <input type="password" id="password" name="password" placeholder="PASSWORD"required>

            <i class="bx bxs-lock-alt"></i>
          </div>
          <button type="submit" class="btn">Register</button>


          <div class="register-link">
          <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>



    
        </form>
    </div>
</body>
</html>