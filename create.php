<!-- create.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueID = uniqid();
    $folderName = date("Y-m-d");
    $folderPath = "flashbriefing/" . $folderName;
    $filePath = $folderPath . "/" . $uniqueID . ".txt";
    
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
    
    file_put_contents($filePath, "");
    
    header("Location: ./$folderName/$uniqueID");
    exit();
}
?>
