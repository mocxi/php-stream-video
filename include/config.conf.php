<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));
define('PROJECT_NAME', basename(APPLICATION_PATH));
define('CUSTOM_CONFIG_FOLDER', realpath(dirname(__FILE__) . '/../../')."/config/".PROJECT_NAME);

$VIDEO_CONFIG = include("video.config.php");
require_once APPLICATION_PATH . '/include/generic_functions.php';

$global_video_data = [];

if (!file_exists(CUSTOM_CONFIG_FOLDER)) {
    mkdir(CUSTOM_CONFIG_FOLDER);
}
try {
    $file_data = file_get_contents(CUSTOM_CONFIG_FOLDER."/global_video_data.json");
    if ($file_data) {
        $json_a = json_decode($file_data, true);
        if ($json_a != NULL) {
            $global_video_data = $json_a;
        }
    }
} catch (Exception $e) {
    // do nothing
    // echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>