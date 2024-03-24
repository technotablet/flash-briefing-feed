<!-- dashboard.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Flash Briefing Dashboard</title>
</head>
<body>
    <h1>Flash Briefing Dashboard</h1>
    <?php
    if (isset($_GET["id"]) && isset($_GET['date'])) {
        $uniqueID = $_GET["id"];
        $folderName = $_GET['date']; //date("Y-m-d");
        $filePath = "flashbriefing/" . $folderName . "/" . $uniqueID . ".txt";

        if (!preg_match('/^[a-zA-Z0-9]+$/', $uniqueID) || !preg_match('/^\d{4}-\d{2}-\d{2}+$/', $folderName)) {
            echo "<p>Invalid Date or ID</p>";
            exit();
        }
	
        if (file_exists($filePath)) {
	    $lineCount = count(file($filePath));

	    $mainLink = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            echo "<p>Number of lines: " . $lineCount . " <a href='./$uniqueID/view' target='_blank'>View</a></p>";
            echo "<p><h3><a href='./$uniqueID/edit'>Edit Responses</a></h3></p>";
            echo "<p><strong>Bookmark this link (it's the same link as in the address bar):<BR><a href='$mainLink'>$mainLink</a></strong></p><hr size=1>";
?>

<h2>JSON Response Options for Flash Briefing</h2>

<UL>
<LI><strong>Randomized Response</strong><BR>
Obtain a randomly selected line from the briefing. This option is perfect for varying the content your audience receives. You can have any number of lines (upto a limit of 50KB approx).<p>
<?php echo "Link:<BR><a href='$mainLink/jsonRandom'>$mainLink/jsonRandom</a></p>"; ?>
</LI>
<LI><strong>One Response Per Day</strong><BR>
Receive the line that corresponds to the current day of the month. For example, if today is the 24th, line number 24 will be selected. This method ensures a unique but consistent message for each day. However, a maximum of 31 lines will be used depending on the month, and hence adding more than 31 lines in your briefing may not help.<p>
<?php echo "Link:<BR><a href='$mainLink/jsonOneDaily'>$mainLink/jsonOneDaily</a></p>"; ?>
</LI>
</UL>
<?php
        } else {
            echo "<p>Flash Briefing not found.</p>";
        }
    } else {
        echo "<p>Invalid Flash Briefing ID.</p>";
    }
    ?>
<hr>
<h2>Disclaimer</h2>
<ul>
        <li>You are responsible for the unique ID and the link. Anyone who knows the link can edit it, so keep it secure.</li>
        <li>This is a free service provided as part of the Alexa course hosted at <a href="https://alexa.technotablet.com">https://alexa.technotablet.com</a>. It is intended for testing and experimentation purposes only and should not be used for serving data in a production environment.</li>
        <li>No warranty or uptime guarantees or SLAs are provided.</li>
        <li>All code for creating this application is available in the GitHub repository at <a href="https://github.com/technotablet/flash-briefing-feed">https://github.com/technotablet/flash-briefing-feed</a>. You can deploy and protect it in your own environment. Instructions are available in the GitHub repository.</li>
    </ul>

</body>
</html>
