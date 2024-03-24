<?php
$uniqueID = $content = $folderName = "";
$errorMessage = "";

// Process POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueID = $_POST["id"];
    $content = $_POST["content"];
    $folderName = $_POST["date"];
    $filePath = "flashbriefing/" . $folderName . "/" . $uniqueID . ".txt";

    if (!preg_match('/^[a-zA-Z0-9]+$/', $uniqueID) || !preg_match('/^\d{4}-\d{2}-\d{2}+$/', $folderName)) {
        $errorMessage = "<p>Invalid Date or ID</p>";
    } else if (strlen($content) > 50 * 1024) {
        // If content is too large, prepare an error message.
        $errorMessage = "<p style='color:red;'>Content exceeds the maximum allowed size of 50KB.</p>";
    } else {
        // Save the content and redirect.
        file_put_contents($filePath, $content);
        header("Location: ../$uniqueID");
        exit();
    }
} else if (isset($_GET["id"]) && isset($_GET["date"])) {
    // Process GET request
    $uniqueID = $_GET["id"];
    $folderName = $_GET["date"];
    $filePath = "flashbriefing/" . $folderName . "/" . $uniqueID . ".txt";

    if (!preg_match('/^[a-zA-Z0-9]+$/', $uniqueID) || !preg_match('/^\d{4}-\d{2}-\d{2}+$/', $folderName)) {
        $errorMessage = "<p>Invalid Date or ID</p>";
    } else if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
    } else {
        $errorMessage = "<p>Flash Briefing not found.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Flash Briefing</title>
    <script>
function calculateByteSize(str) {
  // Encode the string as UTF-8 and create a Blob to measure its size
  const size = new Blob([str]).size;
  return size;
}

function updateSizeAndLineCount() {
  var content = document.getElementById("content").value;
  var byteSize = calculateByteSize(content);
  var lineCount = content.split("\n").length;

  document.getElementById("lineCount").textContent = "Number of lines: " + lineCount;
  document.getElementById("byteSize").textContent = "Approx. size: " + byteSize + " bytes";
}

    </script>
</head>
<body>
    <h1>Edit Flash Briefing</h1>
    <?= $errorMessage ?>
    <p>Each entry should be on a new line.</p>
    <p>
	<strong>NOTE:</strong> If you plan to use <strong>One Response Per Day</strong>, then add 31 lines, one for each day of the month of the month.
    </p>
    <p id='lineCount'>Number of lines: </p>
    <p id='byteSize'>Approx. size: </p>

    <form action='./edit' method='post'>
        <input type='hidden' name='id' value='<?= htmlspecialchars($uniqueID) ?>'>
        <input type='hidden' name='date' value='<?= htmlspecialchars($folderName) ?>'>
        <textarea autocomplete="off" id='content' name='content' style="width:80%;height:200px;" oninput='updateSizeAndLineCount()'><?= htmlspecialchars($content) ?></textarea><br>
	<input type='submit' value='Save'> <a href="../<?php echo $uniqueID;?>">Cancel</a>
    </form>

    <script>
    // Run once on page load
    updateSizeAndLineCount();
    </script>

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

