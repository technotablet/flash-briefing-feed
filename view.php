<!-- view.php -->
<!DOCTYPE html>
<html>
<head>
    <title>View Flash Briefing Content</title>
</head>
<body>
    <h1>Flash Briefing Content</h1>
    <?php
    if (isset($_GET["id"]) && isset($_GET["date"])) {
        $uniqueID = $_GET["id"];
        $folderName = $_GET["date"];
	$filePath = "flashbriefing/" . $folderName . "/" . $uniqueID . ".txt";

	if (!preg_match('/^[a-zA-Z0-9]+$/', $uniqueID) || !preg_match('/^\d{4}-\d{2}-\d{2}+$/', $folderName)) {
            echo "<p>Invalid Date or ID</p>";
            exit();
        }

        
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            echo "<pre>" . htmlspecialchars($content) . "</pre>";
        } else {
            echo "<p>Flash Briefing not found.</p>";
        }
    } else {
        echo "<p>Invalid Flash Briefing ID.</p>";
    }
    ?>
</body>
</html>
