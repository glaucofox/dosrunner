<?php

global $path, $temp;

function bootstrap() {
    global $path;

    $options = getOptions($path);
    echo assembleForm($options, 'game', 20);

    if (isset($_POST['game'])) {
        unzipGame($_POST['game']);
    }

    if (isset($_POST['execute'])) {
        $game = '\\temp\\' . $_POST['execute'];
        exec(__DIR__.'./dosbox/DOSBox.exe '. $game);
    }
}

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
