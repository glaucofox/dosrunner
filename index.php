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
    <title>DOS Runner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <h1>MS-DOS Games</h1>
    <div class="conBox">
        <?php bootstrap(); ?>
    </div>
</body>
</html>
