<?php
require 'init.php';

session_start();
if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'administrator') {

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$title = $_POST["title"];

		$query = "DELETE FROM shows WHERE Title = '$title'";
		$result = $conn->query($query);
		if ($conn->affected_rows > 0) {
            echo '<script>alert("Show deleted successfully.");</script>';
        } else {
            echo '<script>alert("Show not found.");</script>';
        }
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Show</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
    <a href="LogIn.html">Log Out</a>
    <?php
        if ($_SESSION['Role'] == 'administrator') {
            echo '<a href="WatchLater.php">Watch Later</a>';
            echo '<a href="Main.html">Quiz</a>';
            echo '<a href="Insert.php">Insert</a>';
            echo '<a href="Update.php">Update</a>';
            echo '<a href="Delete.php">Delete</a>';
            echo '<a href="Select.php">Select</a>';
        }
	?>
</div>

<form action="delete.php" method="post">
    <h2>Delete Show</h2>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" placeholder="Enter show title" required>
    <br><br>
    <input type="submit" value="Delete">
</form>

</body>
</html>
