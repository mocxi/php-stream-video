<?php
include("VideoStream.php");
use thirdparty\VideoStream;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $name = $_GET['name'];
    if (!empty($name)) {
        $stream = new VideoStream($name);
        $stream->start();

    } else {
         echo "File name is empty!";

    }
}
echo "You are at pHub/phub";

?>
