<?php
global $path, $temp;

include_once 'lib/doslib.php';

$path = "A:/Games/LaunchBox/Games/MS-DOS";
$temp = __DIR__ .'./temp/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS-DOS Games</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <h1>MS-DOS Games</h1>
    <div class="conBox">
    <?php
        $options = getOptions($path);
        echo assembleForm($options, 'game', 20);

        if (isset($_POST['game'])) {
            $isUnziped = unzipGame($_POST['game']);
        }
        
        if (isset($_POST['execute'])) {
            global $temp;
        
            $game = '\\temp\\' . $_POST['execute'];
            $output = exec(__DIR__.'./dosbox/DOSBox.exe '. $game);
        }
    ?>
    </div>
</body>
</html>
