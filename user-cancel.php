<?php
session_start();
include "connect.php";

if(!isset($_POST['appointment_id'])){
    header("Location: appointment_status.php");
    exit();
}

$appointment_id = $_POST['appointment_id'];
$reason = $_POST['reason'];

// Cancel appointment
$stmt = $con->prepare("
    UPDATE appointments 
    SET canceled = 1, cancellation_reason = ?
    WHERE appointment_id = ?
");
$stmt->execute([$reason, $appointment_id]);

// Notify admin
$admin_id = 1;
$message = "User cancelled appointment. Reason: " . $reason;

$stmtNotif = $con->prepare("
    INSERT INTO notifications (user_id, message)
    VALUES (?, ?)
");
$stmtNotif->execute([$admin_id, $message]);

header("Location: appointment_status.php");
exit();
?>