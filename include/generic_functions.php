<?php

function recursiveScanDirectory($directory)
{
    global $global_video_data;
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveScanDirectory($file);
        } else {
            if (isVAlidVideo($file)){
                $human_size = human_filesize(filesize($file));
                $global_video_data[] = array(
                    "file" => $file,
                    "size" => $human_size,
                    "show_name" => basename($file)
                );
                // echo printVideoUrl($file, $human_size, basename($file));

            }
        }
    }
}

function isValidVideo($i_video_name) {
    global $VIDEO_CONFIG;

    $exts = $VIDEO_CONFIG['exts'];
    foreach ($exts as $ext) {
        $pos = strpos($i_video_name, $ext);
        if($pos == (strlen($i_video_name) - strlen($ext))) {
            return true;
        }
    }
    return false;
}

function printVideoUrl($i_video_path, $i_size ="0 Byte", $i_show_name = "unknown") {

    echo "<div>";
    echo "<a href='play.php?name=$i_video_path'> $i_show_name</a><a> [size: $i_size] </a>";
    echo "</div>";
    echo "</br>";
}

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

function refresh_global_video_data() {
    global $VIDEO_CONFIG;
    global $global_video_data;
    $global_video_data = [];

    echo "refresh_global_video_data";
    foreach ($VIDEO_CONFIG['dirs'] as $dir) {
        recursiveScanDirectory($dir);
    }
    foreach ($VIDEO_CONFIG['nas'] as $nas) {
        try {
            // recursiveScanDirectory('\\\\TS-XL7AA\\Mocxi\\Steam');
            recursiveScanDirectory('$nas');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}

function save_global_video_data() {
    global $global_video_data;
    $fp = fopen(CUSTOM_CONFIG_FOLDER."/global_video_data.json", 'w');
    fwrite($fp, json_encode($global_video_data));
    fclose($fp);

}

function print_global_video_data() {
    global $global_video_data;
    foreach ($global_video_data as $video_data) {
        echo printVideoUrl($video_data['file'], $video_data['size'], $video_data['show_name']);
    }
}
?>