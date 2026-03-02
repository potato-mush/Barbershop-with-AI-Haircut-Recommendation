<?php
session_start();
include "connect.php";

if(!isset($_SESSION['user_id'])){
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   GET CLIENT ID
========================= */

$stmtUser = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch();

if(!$user){
    die("User not found.");
}

$email = $user['email'];

$stmtClient = $con->prepare("SELECT client_id FROM clients WHERE client_email = ?");
$stmtClient->execute([$email]);
$client = $stmtClient->fetch();

if(!$client){
    die("No appointments found.");
}

$client_id = $client['client_id'];

/* =========================
   GET APPOINTMENTS
========================= */

$stmt = $con->prepare("
    SELECT * FROM appointments 
    WHERE client_id = ? 
    ORDER BY start_time DESC
");
$stmt->execute([$client_id]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body{
            font-family:Arial;
            padding:40px;
            background:#f8f9fc;
        }

        .back-btn{
            display:inline-block;
            margin-bottom:20px;
            padding:6px 12px;
            background:#36b9cc;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        .card{
            background:white;
            border:1px solid #ddd;
            padding:20px;
            margin-bottom:15px;
            border-radius:8px;
        }

        .status{
            font-weight:bold;
            margin-top:10px;
        }

        .cancel-btn{
            margin-top:10px;
            background:red;
            color:white;
            padding:6px 12px;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        .disabled-btn{
            margin-top:10px;
            background:gray;
            color:white;
            padding:6px 12px;
            border:none;
            border-radius:5px;
            cursor:not-allowed;
        }
    </style>
</head>

<body>

<a href="index.php" class="back-btn">← Back to Home</a>

<h2>My Appointments</h2>

<?php if(count($appointments) > 0): ?>

    <?php foreach($appointments as $appt): ?>

        <div class="card">

            <p><strong>Date:</strong> <?php echo $appt['start_time']; ?></p>

            <?php
                $now = new DateTime();
                $apptTime = new DateTime($appt['start_time']);
                $interval = $now->diff($apptTime);
                $hoursRemaining = ($interval->days * 24) + $interval->h;
            ?>

            <div class="status">
                Status:

<?php if($appt['canceled'] == 1): ?>

    <span style="color:red;">Cancelled</span>

    <?php if(!empty($appt['cancellation_reason'])): ?>
        <br>
        <small>
            Reason: 
            <?php echo htmlspecialchars($appt['cancellation_reason']); ?>
        </small>
    <?php endif; ?>

<?php elseif($appt['completed'] == 1): ?>

    <span style="color:blue;">Approved</span>

<?php else: ?>

    <span style="color:green;">Active</span>

<?php endif; ?>
            </div>

            <?php if($appt['canceled'] == 0 && $appt['completed'] == 0): ?>

                <?php if($apptTime > $now && $hoursRemaining >= 24): ?>

                    <button 
                        class="cancel-btn"
                        onclick="cancelAppointment(<?php echo $appt['appointment_id']; ?>)">
                        Cancel Appointment
                    </button>

                <?php else: ?>

                    <button class="disabled-btn" disabled>
                        Cannot Cancel (Less than 24h)
                    </button>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <p>No appointments found.</p>

<?php endif; ?>


<!-- Hidden Form for SweetAlert -->
<form id="cancelForm" method="POST" action="user-cancel.php">
    <input type="hidden" name="appointment_id" id="hiddenAppointmentId">
    <input type="hidden" name="reason" id="hiddenReason">
</form>


<script>
function cancelAppointment(id){

    Swal.fire({
        title: 'Cancel Appointment?',
        input: 'textarea',
        inputLabel: 'Reason for cancellation',
        inputPlaceholder: 'Type your reason here...',
        inputAttributes: {
            'aria-label': 'Type your reason here'
        },
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Cancel it!',
        preConfirm: (reason) => {
            if (!reason) {
                Swal.showValidationMessage('Reason is required')
            }
            return reason;
        }

    }).then((result) => {

        if (result.isConfirmed) {

            document.getElementById("hiddenAppointmentId").value = id;
            document.getElementById("hiddenReason").value = result.value;

            document.getElementById("cancelForm").submit();
        }
    });
}
</script>

</body>
</html>