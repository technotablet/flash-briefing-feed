<?php

header('Content-Type: application/json');

if (isset($_GET["id"]) && isset($_GET["date"])) {
        $uniqueID = $_GET["id"];
        $folderName = $_GET["date"];
        $filePath = "flashbriefing/" . $folderName . "/" . $uniqueID . ".txt";

        if (!preg_match('/^[a-zA-Z0-9]+$/', $uniqueID) || !preg_match('/^\d{4}-\d{2}-\d{2}+$/', $folderName)) {
            echo "<p>Invalid Date or ID</p>";
            exit();
	}

	if (!file_exists($filePath)) {
	    echo "<p>File Does not exist</p>";
	    exit();
	}
}

// convert the file separated by newlines into an array
$fileData = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// By default choose a random item (tip, fact, etc.)
$itemIndex = rand(0,sizeof($fileData)-1);

// If the user has mentioned the type to be onceDaily then choose the index item of that day
if (isset($_GET['frequency']) && trim($_GET['frequency']) === "onceDaily") {
	$itemIndex = date("j") - 1; // day of the month without leading 0, and subtracting 1 as $fileData is an array
}

// By default text response. If the user has asked for audio, then use audio
$briefingFormat = "text";
if (isset($_GET['format']) && trim($_GET['format']) === "audio") {
	$briefingFormat = "audio";
}

// the tip or the fact
if (!isset($fileData[$itemIndex])) {
	echo "Item doesn't exist. Probably the line ". ($itemIndex + 1) ." (today's date) does not exist";
	exit();
}
$getItem = $fileData[$itemIndex];

// Current date in ISO 8601 format and UTC timezone for the updateDate field
$date = new DateTime("now", new DateTimeZone("UTC"));
$updateDate = $date->format('Y-m-d\TH:i:s\Z');

// Generate the JSON content
// Base Template
$flashBriefing = [
	"uid" => "item-id-".rand()."-".md5($getItem),
	"updateDate" => $updateDate,
	"titleText" => "Flash Briefing",
	"redirectionUrl" => "https://google.com"
];

// Enrich the message
if ($briefingFormat === "text") {
	$flashBriefing["mainText"] = "$getItem";
} else if ($briefingFormat === "audio") {
	$flashBriefing["mainText"] = "";
	$scriptPath = dirname($_SERVER['PHP_SELF']);
	$audioURL = "https://".$_SERVER['HTTP_HOST'] . $scriptPath;
	$flashBriefing["streamUrl"] = $audioURL . "/audio/$folderName/$uniqueID/" . md5($getItem)."_with_effects.mp3";
}

echo json_encode($flashBriefing);
