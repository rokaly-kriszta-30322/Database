<!DOCTYPE html>
<html>
  <head>
    <title>User Preferences</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
  </head>
  <body>
	  <div class="navbar">
		<a href="LogIn.html">Log Out</a>
		<?php

        session_start();

        if (isset($_SESSION['Role'])) {

            if ($_SESSION['Role'] == 'administrator') {
                echo '<a href="WatchLater.php">Watch Later</a>';
                echo '<a href="Main.php">Quiz</a>';
				echo '<a href="Insert.php">Insert</a>';
				echo '<a href="Update.php">Update</a>';
				echo '<a href="Delete.php">Delete</a>';
				echo '<a href="Select.php">Select</a>';
            } else {

                echo '<a href="WatchLater.php">Watch Later</a>';
                echo '<a href="Main.php">Quiz</a>';
            }
        } else {

            header("Location: LogIn.html");
            exit();
        }
        ?>
	  </div>
    <form action="process_preferences.php" method="post">
	  <h2>User Preferences</h2>
	  <p> Welcome to the website!</p>
	  <p> In order to find you the perfect tv show for your current mood, please enter the desired medium, genre and the minimum IMDb score!</p>
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
      <input type="number" id="score" name="score" placeholder="Enter desired score" min="7" max="10" step="0.1" required>
      
      <br><br>
      
      <input type="submit" value="Submit">
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