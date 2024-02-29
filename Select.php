<?php
require 'init.php';
session_start();
$showSelected = false;
if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'administrator') {

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$title = $_POST["title"];

		$query = "SELECT shows.Title, medium.Type, genres.Genre_Name, shows.Score
				  FROM shows
				  JOIN medium ON shows.Medium_Id = medium.Med_Id
				  JOIN genres ON shows.Genre_Id = genres.Genre_Id
				  WHERE shows.Title = '$title'";
		$result = $conn->query($query);

		if ($result->num_rows > 0) {
			$showSelected = true;

			echo '<form action="select.php" method="post">';
            echo '<h2>Show Details</h2>';
			
            while ($row = $result->fetch_assoc()) {
                echo '<label><strong>Title:</strong> ' . $row['Title'] . '</label><br>';
                echo '<label><strong>Medium:</strong> ' . $row['Type'] . '</label><br>';
                echo '<label><strong>Genre:</strong> ' . $row['Genre_Name'] . '</label><br>';
                echo '<label><strong>Score:</strong> ' . $row['Score'] . '</label><br>';
            }
            echo '</form>';
		} else {

            echo '<script>alert("Show not found.");</script>';
        }
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Details</title>
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
    <?php

	if (!$showSelected) {
		echo '
			<form action="select.php" method="post">
				<h2>Search for Show</h2>
				<label for="title">Title:</label>
				<input type="text" id="title" name="title" placeholder="Enter show title" required>
				<br><br>
				<input type="submit" value="Search">
			</form>
		';
	}
	?>
</body>
</html>
