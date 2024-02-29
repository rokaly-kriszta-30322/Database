<?php
require 'init.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $medium = $_POST['medium'];
    $genre = $_POST['genre'];
    $score = $_POST['score'];

    $selectQuery = "
        SELECT Shows.Shows_Id, Shows.Title
        FROM Shows
        INNER JOIN Genres ON Shows.Genre_Id = Genres.Genre_Id
        INNER JOIN Medium ON Shows.Medium_Id = Medium.Med_Id
        WHERE Medium.Type = '$medium' AND Genres.Genre_Name = '$genre' AND Shows.Score >= '$score'
    ";

    $result = $conn->query($selectQuery);

    if ($result && $result->num_rows > 0) {
        $shows = $result->fetch_all(MYSQLI_ASSOC);

        $userId = $_SESSION['User_Id'];

		foreach ($shows as $show) {

            $insertQuery = "INSERT INTO Recommendations (User_Id, Show_Id) VALUES ('$userId', '".$show['Shows_Id']."')";
            $insertResult = $conn->query($insertQuery);

            if (!$insertResult) {
                echo "Error inserting recommendation into the database: " . $conn->error;
                exit();
            }
        }

        header("Location: Recommendations.php?medium=" . urlencode($medium) . "&genre=" . urlencode($genre) . "&score=" . urlencode($score));
        exit();
    } else {
        echo "<script>
            alert('No recommendations found.');
            window.location.href = 'Main.php';
          </script>";
    }
}
?>