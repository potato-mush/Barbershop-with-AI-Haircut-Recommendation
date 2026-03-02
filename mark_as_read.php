<?php
session_start();
include "connect.php";

if(isset($_POST['notif_id'])){

    $notif_id = $_POST['notif_id'];

    $stmt = $con->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->execute([$notif_id]);

}
?>