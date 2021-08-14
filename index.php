<?php

global $path, $temp;

$path = "A:/Games/LaunchBox/Games/MS-DOS";
$temp = __DIR__ .'./temp/';

function unzipGame($file) {
    global $temp, $path;
    
    cleanUpTempDir($temp);
    $unzip = unzipFileToTemp($path .'/'. $file, $temp);
    if ($unzip) {
        $executables = getExecutables($temp);
        echo "<h3>". $_POST['game'] ."</h3>";
        echo assembleForm($executables, 'execute');
    }

    return true;
}

function assembleForm($options, $name, $size = 5) {
    $form = "<div class='item'>";
    $form .= "<form action='index.php' method='post'><select id='$name' name='$name' size='$size' onchange='this.form.submit()' columns='60'>";
    $form .= $options;
    $form .= "</select></form></div>";

    return $form;
}


function unzipFileToTemp($path, $temp) {
    $result = false;
    $temp = makeTempDir($temp);
    $zip = new ZipArchive;
    if ($zip->open($path) === TRUE) {
        $zip->extractTo($temp);
        $zip->close();
        $result = true;
    }

    return $result;
}

function makeTempDir($temp) {
    if (!is_dir($temp)) { mkdir($temp, 0777, true); }

    return $temp;
}

function cleanUpTempDir($temp) {
    recursiveRemove($temp);
}

function recursiveRemove($dir) {
    $structure = glob(rtrim($dir, "/").'/*');
    if (is_array($structure)) {
        foreach($structure as $file) {
            if (is_dir($file)) recursiveRemove($file);
            elseif (is_file($file)) unlink($file);
        }
    }
    rmdir($dir);
}

function getOptions($path) {
    $diretorio = dir($path);
    $options = "";
    while ($arquivo = $diretorio->read())
    {
        $selected = ($arquivo === $_POST['game']) ?  ' selected' : '';
        if (strlen($arquivo) > 4) {
            $options .= "<option value='$arquivo' $selected>$arquivo</option>";
        }
    }
    $diretorio -> close();

    return $options;
}

function getExecutables($path)
{
    $options = '';
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read())
    {
        if (in_array(strtolower(substr($arquivo, -4)), ['.bat', '.exe', '.com'])) {
            $options .= "<option value='$arquivo'>$arquivo</option>";
        }
    }

    return $options;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS-DOS Games</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style type="text/css">
        .conBox {
            display: flex;
            flex-flow: column wrap;
            align-items: center;
            align-content: center;
            height: 100%;
            width: 100%;
        }

        .item {
            margin: auto;
        }
    </style>
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
