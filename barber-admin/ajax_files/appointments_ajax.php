
<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php

/* ================= CANCEL ================= */
if(isset($_POST['do']) && $_POST['do'] == "Cancel Appointment")
{
    $appointment_id = $_POST['appointment_id'];
    $cancellation_reason = test_input($_POST['cancellation_reason']);

    // Update appointment
    $stmt = $con->prepare("UPDATE appointments 
                           SET canceled = 1, cancellation_reason = ? 
                           WHERE appointment_id = ?");
    $stmt->execute([$cancellation_reason, $appointment_id]);
     echo "canceled";
    // Get client_id
    $stmtClient = $con->prepare("SELECT client_id FROM appointments WHERE appointment_id = ?");
    $stmtClient->execute([$appointment_id]);
    $client = $stmtClient->fetch(PDO::FETCH_ASSOC);

    if($client)
{
    $client_id = $client['client_id'];

    // Get client email
    $stmtEmail = $con->prepare("SELECT client_email FROM clients WHERE client_id = ?");
    $stmtEmail->execute([$client_id]);
    $clientData = $stmtEmail->fetch(PDO::FETCH_ASSOC);

    if($clientData)
    {
        $email = $clientData['client_email'];

        // Get real user id
        $stmtUser = $con->prepare("SELECT id FROM users WHERE email = ?");
        $stmtUser->execute([$email]);
        $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if($userData)
        {
            $real_user_id = $userData['id'];

            $notif_stmt = $con->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $notif_stmt->execute([$real_user_id, "Your appointment has been cancelled."]);
        }
    }
}
}


//* ================= CONFIRM ================= */
if(isset($_POST['do']) && $_POST['do'] == "Confirm Appointment")
{
    $appointment_id = $_POST['appointment_id'];

    // Update appointment
    $stmt = $con->prepare("UPDATE appointments SET completed = 1 WHERE appointment_id = ?");
    $stmt->execute([$appointment_id]);

    // Get client_id
    $stmtClient = $con->prepare("SELECT client_id FROM appointments WHERE appointment_id = ?");
    $stmtClient->execute([$appointment_id]);
    $client = $stmtClient->fetch(PDO::FETCH_ASSOC);

    if($client)
{
    $client_id = $client['client_id'];

    // Get client email
    $stmtEmail = $con->prepare("SELECT client_email FROM clients WHERE client_id = ?");
    $stmtEmail->execute([$client_id]);
    $clientData = $stmtEmail->fetch(PDO::FETCH_ASSOC);

    if($clientData)
    {
        $email = $clientData['client_email'];

        // Get real user id
        $stmtUser = $con->prepare("SELECT id FROM users WHERE email = ?");
        $stmtUser->execute([$email]);
        $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if($userData)
        {
            $real_user_id = $userData['id'];

            $stmtNotif = $con->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $stmtNotif->execute([$real_user_id, "Your appointment has been approved."]);
        }
    }
}
}
?>