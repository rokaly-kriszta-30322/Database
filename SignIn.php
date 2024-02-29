<?php
require 'init.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM user WHERE user_name = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $_SESSION['Role'] = $user['Role'];
		$_SESSION['User_Id'] = $user['User_Id'];

        header("Location: Main.php");
        exit();
    } else {

        echo "<script>
            alert('Invalid username or password');
            window.location.href = 'LogIn.html';
          </script>";
        exit();
    }
}
?>


