<?php
require 'init.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedRecommendations = $_POST['removeRecommendations'];

    if (!empty($selectedRecommendations)) {
        $recommendationIds = implode(",", $selectedRecommendations);
		
		echo "Selected show IDs: " . $recommendationIds;

        $updateQuery = "UPDATE Recommendations SET Recommended = 0 WHERE Show_Id IN ($recommendationIds)";
        $updateResult = $conn->query($updateQuery);

        if ($updateResult) {
            header("Location: WatchLater.php");
        } else {
            echo "Error updating watchlist: " . $conn->error;
        }
    } else {
        echo "<script>
            alert('No recommendations selected');
            window.location.href = 'WatchLater.php';
          </script>";
    }
} 
?>
