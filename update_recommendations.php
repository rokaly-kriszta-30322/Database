<?php
require 'init.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedShows = $_POST['recommendations'];

    if (!empty($selectedShows)) {
        $showIds = implode(",", $selectedShows);
		
		echo "Selected show IDs: " . $showIds;

        $updateQuery = "UPDATE Recommendations SET Recommended = 1 WHERE Show_Id IN ($showIds)";
        $updateResult = $conn->query($updateQuery);

        if ($updateResult) {
            header("Location: WatchLater.php");
        } else {
            echo "Error updating recommendations: " . $conn->error;
        }
    } else {
        echo "<script>
            alert('No recommendations selected');
            window.location.href = 'Main.php';
          </script>";
    }
} 
?>