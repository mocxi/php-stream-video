<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div id="video_list">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET'&& isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
    case "refresh":
        refresh_global_video_data();
        break;
    default:
        break;
    }
}
refresh_global_video_data();

print_global_video_data();
save_global_video_data();
?>
</div>
</body>
</html>
