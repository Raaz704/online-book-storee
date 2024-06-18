<?php
include('db.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM signup WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this email.";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800;900&family=Syne:wght@800&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #23242a;
    }

    .box {
      position: relative;
      width: 400px;
      height: 430px;
      background: #1c1c1c;
      border-radius: 18px;
      overflow: hidden;
    }

    .box::before {
      content: "";
      position: absolute;
      width: 4000px;
      height: 470px;
      top: -50%;
      left: -50%;
      background: linear-gradient(0deg,
          transparent,
          transparent,
          #45f3ff,
          #45f3ff,
          #45f3ff);
      z-index: 1;
      transform-origin: bottom right;
      animation: animate 6s linear infinite;
    }

    .box::after {
      content: "";
      position: absolute;
      width: 400px;
      height: 470px;
      top: -50%;
      left: -50%;
      background: linear-gradient(0deg,
          transparent,
          transparent,
          #ffff00,
          #ffff00,
          #ffff00);
      z-index: 1;
      transform-origin: bottom right;
      animation: animate 6s linear infinite;
      animation-delay: -3s;
    }

    .borderLine {
      position: absolute;
      top: 0;
      inset: 0;
    }

    .borderLine::before {
      content: "";
      position: absolute;
      width: 400px;
      height: 470px;
      top: -50%;
      left: -50%;
      background: linear-gradient(0deg,
          transparent,
          transparent,
          #fc0f8d,
          #fc0f8d,
          #fc0f8d);
      z-index: 1;
      transform-origin: bottom right;
      animation: animate 6s linear infinite;
    }

    @keyframes animate {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .box form {
      position: absolute;
      inset: 4px;
      background: #222;
      padding: 50px 40px;
      border-radius: 18px;
      z-index: 2;
      display: flex;
      flex-direction: column;
    }

    .box form h2 {
      color: #fff;
      font-weight: 500;
      text-align: center;
      letter-spacing: 0.1em;
    }

    .box form .inputBox {
      position: relative;
      width: 300px;
      margin-top: 35px;
    }

    .box form .inputBox input {
      position: relative;
      width: 100%;
      padding: 20px 10px 10px;
      background: transparent;
      outline: none;
      border: none;
      box-shadow: none;
      color: #23242a;
      font-size: 1em;
      letter-spacing: 0.05em;
      transition: 0.5s;
      z-index: 10;
    }

    .box form .inputBox span {
      position: absolute;
      left: 0;
      padding: 20px 0px 10px;
      pointer-events: none;
      color: #8f8f8f;
      font-size: 1em;
      letter-spacing: 0.05em;
      transition: 0.5s;
    }

    .box form .inputBox input:valid~span,
    .box form .inputBox input:focus~span {
      color: #fff;
      font-size: 0.75em;
      transform: translateY(-34px);
    }

    .box form .inputBox i {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      height: 2px;
      background: #fff;
      border-radius: 7px;
      overflow: hidden;
      transition: 0.5s;
      pointer-events: none;
    }

    .box form .inputBox input:valid~i,
    .box form .inputBox input:focus~i {
      height: 44px;
    }

    .box form .links {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .box form .links a {
      margin: 15px 12px 20px 0;
      font-size: 0.75em;
      color: #8f8f8f;
      text-decoration: none;
    }

    .box form .links a:hover,
    .box form .links a:nth-child(2) {
      color: #fff;
    }

    .box form input[type="submit"] {
      border: none;
      outline: none;
      padding: 9px 25px;
      background: #fff;
      cursor: pointer;
      font-size: 0.9em;
      border-radius: 7px;
      font-weight: 600;
      width: 100px;
      margin-top: 10px;
      transition: 0.6s;
    }

    .box form input[type="submit"]:hover {
      background-color: #31e1f7;
    }

    .box form input[type="submit"]:active {
      opacity: 0.8;
    }
  </style>
</head>

<body>
  <div class="box">
    <span class="borderLine"></span>
    <form method="post">
      <h2>Log In</h2>
      <div class="inputBox">
        <input type="email" name="email" required="required">
        <span>Email</span>
        <i></i>
      </div>
      <div class="inputBox">
        <input type="password" name="password" required="required">
        <span>Password</span>
        <i></i>
      </div>
      <div class="links">
        <a href="#">Forgot Password</a>
        <a href="signup.php">Signup</a>
      </div>
      <input type="submit" value="Login">
      <?php
      if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
      }
      ?>
    </form>
  </div>
</body>

</html>