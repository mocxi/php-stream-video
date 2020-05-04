<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET'&& isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
    case "refresh":
        break;
    default:
        break;
    }
}

$config = include("config.php");
function recursiveScanDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveScanDirectory($file);
        } else {
            if (isVAlidVideo($file)){
                echo "<div>";
                echo printVideoUrl($file, basename($file));
                echo "</div>";
                echo "</br>";
            }
        }
    }
}

function isValidVideo($i_video_name) {
    global $config;

    $exts = $config['exts'];
    foreach ($exts as $ext) {
        $pos = strpos($i_video_name, $ext);
        if($pos == (strlen($i_video_name) - strlen($ext))) {
            return true;
        }
    }
    return false;
}

function printVideoUrl($i_video_path, $i_show_name = "unknown") {
    $human_size = human_filesize(filesize($i_video_path));
    echo "<a href='play.php?name=$i_video_path'> $i_show_name</a><a> [size: $human_size] </a>";
}

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

$dirs = $config['dirs'];
foreach ($dirs as $dir) {
    recursiveScanDirectory($dir);
}
echo "reading from nas";
foreach ($config['nas'] as $nas) {
    try {
        // recursiveScanDirectory('\\\\TS-XL7AA\\Mocxi\\Steam');
        recursiveScanDirectory('$nas');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
