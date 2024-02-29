<!DOCTYPE html>
<html>
<head>
  <title>Watch Later</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style_watch.css">
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
  </body>
</html>

  <div class="watchlist-container">
    <div class="watchlist-form">
    <h2>Watch Later</h2>
	<form action="update_watchlist.php" method="post">
    <?php
    require 'init.php';
    session_start();

    $userId = $_SESSION['User_Id'];

    $selectQuery = "
      SELECT DISTINCT Shows.Shows_Id, Shows.Title, Medium.Type, Genres.Genre_Name, Shows.Score
      FROM Recommendations
      INNER JOIN Shows ON Recommendations.Show_Id = Shows.Shows_Id
      INNER JOIN Medium ON Shows.Medium_Id = Medium.Med_Id
      INNER JOIN Genres ON Shows.Genre_Id = Genres.Genre_Id
      WHERE Recommendations.User_Id = '$userId' AND Recommendations.Recommended = 1
      ORDER BY Shows.Title ASC
    ";

    $result = $conn->query($selectQuery);

    if ($result && $result->num_rows > 0) {

      echo "<table class='watchlist-table'>";
      echo "<tr><th>Title</th><th>Medium</th><th>Genre</th><th>Score</th><th>Watched Now</th></tr>";

      while ($row = $result->fetch_assoc()) {
		$showId = $row['Shows_Id'];
        echo "<tr>";
        echo "<td>" . $row['Title'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Genre_Name'] . "</td>";
        echo "<td>" . $row['Score'] . "</td>";
		echo "<td><input type='checkbox' name='removeRecommendations[]' value='$showId'></td>";
        echo "</tr>";
      }
      echo "</table>";
	  echo "<div class='button'>";
          echo "<input type='submit' value='Update Watch Later'>";
          echo "</div>";
    } else {
      echo "No shows in the watch list.";
    }
    ?>
	</form>
	</div>
  </div>
