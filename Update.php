<?php
require 'init.php';
session_start();

if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'administrator') {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $title = $_POST["title"];
        $medium = $_POST["medium"];
        $genre = $_POST["genre"];
        $score = $_POST["score"];

        $mediumQuery = "SELECT Med_Id FROM medium WHERE Type = '$medium'";
        $genreQuery = "SELECT Genre_Id FROM genres WHERE Genre_Name = '$genre'";

        $mediumResult = $conn->query($mediumQuery);
        $genreResult = $conn->query($genreQuery);

        if ($mediumResult->num_rows > 0 && $genreResult->num_rows > 0) {
            $mediumRow = $mediumResult->fetch_assoc();
            $genreRow = $genreResult->fetch_assoc();
            $mediumId = $mediumRow['Med_Id'];
            $genreId = $genreRow['Genre_Id'];

            $updateQuery = "UPDATE shows SET Medium_Id = '$mediumId', Genre_Id = '$genreId', Score = '$score' WHERE Title = '$title'";
            $updateResult = $conn->query($updateQuery);
			if ($conn->affected_rows > 0) {
                echo '<script>alert("Show updated successfully.");</script>';
            } else {
                echo '<script>alert("Title not found.");</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Show</title>
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
            echo '<a href="Main.php">Quiz</a>';
            echo '<a href="Insert.php">Insert</a>';
            echo '<a href="Update.php">Update</a>';
            echo '<a href="Delete.php">Delete</a>';
            echo '<a href="Select.php">Select</a>';
        }
        ?>
    </div>

    <form action="update.php" method="post">
        <h2>Update Show</h2>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>

        <label for="medium">Medium:</label>
        <select id="medium" name="medium" onchange="updateGenreOptions()" required>
            <option value="traditional">Traditional TV</option>
            <option value="animation">Animation</option>
            <option value="anime">Anime</option>
        </select>
        <br><br>

        <label for="genre">Genre:</label>
        <select id="genre" name="genre" required>
        </select>
        <br><br>

        <label for="score">Score:</label>
        <input type="number" id="score" name="score" placeholder="Enter exact score" min="1" max="10" step="0.1" required>
        <br><br>

        <input type="submit" value="Update">
    </form>

    <script>
        function updateGenreOptions() {
            var mediumSelect = document.getElementById("medium");
            var genreSelect = document.getElementById("genre");
            genreSelect.innerHTML = "";

            if (mediumSelect.value === "traditional") {
                addGenreOption("crime", "Crime");
                addGenreOption("comedy", "Comedy");
                addGenreOption("drama", "Drama");
                addGenreOption("history", "History");
                addGenreOption("fantasy", "Fantasy");
                addGenreOption("scifi", "Sci-fi");
            } else if (mediumSelect.value === "animation") {
                addGenreOption("forchildren", "For Children");
                addGenreOption("forteens", "For Teens");
                addGenreOption("foryoungadults", "For Young Adults");
            } else if (mediumSelect.value === "anime") {
                addGenreOption("shounen", "Shounen");
                addGenreOption("mindgame", "MindGame");
                addGenreOption("fantasy+", "Fantasy+");
                addGenreOption("scifi+", "Sci-fi+");
            }
        }

        function addGenreOption(value, label) {
            var genreSelect = document.getElementById("genre");
            var option = document.createElement("option");
            option.value = value;
            option.text = label;
            genreSelect.add(option);
        }
    </script>
</body>
</html>
