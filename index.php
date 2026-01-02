<?php
session_start();
include "config/db.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Online Examination System - Login</title>
  <link rel="stylesheet" type="text/css" href="slide navbar style.css">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
  <style>
body{ margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: 'Jost', sans-serif; background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e); } .main{ width: 350px; height: 500px; background: red; overflow: hidden; background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover; border-radius: 10px; box-shadow: 5px 20px 50px #000; } #chk{ display: none; } .signup{ position: relative; width:100%; height: 100%; } label{ color: #fff; font-size: 2.3em; justify-content: center; display: flex; margin: 50px; font-weight: bold; cursor: pointer; transition: .5s ease-in-out; } input{ width: 60%; height: 10px; background: #e0dede; justify-content: center; display: flex; margin: 20px auto; padding: 12px; border: none; outline: none; border-radius: 5px; } button{ width: 60%; height: 40px; margin: 10px auto; justify-content: center; display: block; color: #fff; background: #573b8a; font-size: 1em; font-weight: bold; margin-top: 30px; outline: none; border: none; border-radius: 5px; transition: .2s ease-in; cursor: pointer; } button:hover{ background: #6d44b8; } .login{ height: 460px; background: #eee; border-radius: 60% / 10%; transform: translateY(-180px); transition: .8s ease-in-out; } .login label{ color: #573b8a; transform: scale(.6); } #chk:checked ~ .login{ transform: translateY(-500px); } #chk:checked ~ .login label{ transform: scale(1); } #chk:checked ~ .signup label{ transform: scale(.6); }
</style>
</head>

<body>
  <div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <!-- TEACHER LOGIN -->
    <div class="signup">
      <form method="post">
        <label for="chk" aria-hidden="true">Teacher Login</label>

        <input type="email" name="teacher_email" placeholder="Email" required>
        <input type="password" name="teacher_password" placeholder="Password" required>

        <button type="submit" name="teacher_login">Login</button>
      </form>
    </div>

    <!-- STUDENT LOGIN -->
    <div class="login">
      <form method="post">
        <label for="chk" aria-hidden="true">Student Login</label>

        <input type="text" name="student_username" placeholder="Register No" required>
        <input type="password" name="student_password" placeholder="Password" required>

        <button type="submit" name="student_login">Login</button>
      </form>
    </div>
  </div>

<?php
/* STUDENT LOGIN LOGIC */
if (isset($_POST['student_login'])) {

    $username = $_POST['student_username'];
    $password = $_POST['student_password'];

    $query = mysqli_query($conn,
        "SELECT * FROM students 
         WHERE register_no='$username' AND password='$password'"
    );

    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['student_id'] = $row['student_id'];
        header("Location: student/dashboard.php");
        exit;
    } else {
        echo "<script>alert('Invalid Student Login');</script>";
    }
}

/* TEACHER LOGIN LOGIC */
if (isset($_POST['teacher_login'])) {

    $email = $_POST['teacher_email'];
    $password = $_POST['teacher_password'];

    $query = mysqli_query($conn,
        "SELECT * FROM teachers 
         WHERE email='$email' AND password='$password'"
    );

    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['teacher_id'] = $row['teacher_id'];
        header("Location: admin/dashboard.php");
        exit;
    } else {
        echo "<script>alert('Invalid Teacher Login');</script>";
    }
}
?>

</body>
</html>
