<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {

        // SMTP CONFIG (same as your verification setup)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cuttrendz@gmail.com'; // YOUR GMAIL
        $mail->Password   = 'zkmj ervv ckhk hxkn'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Receiver
        $mail->setFrom('lancemontefalco069@gmail.com', 'Trendz-Cut Website');
        $mail->addAddress('cuttrendz@gmail.com'); // Admin receives message

        // Optional: reply to user
        $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message: " . $subject;

        $mail->Body = "
            <h3>New Message from Website</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        $mail->send();

        echo "<script>alert('Message sent successfully!'); window.location.href='index.php';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent.'); window.history.back();</script>";
    }
}
?>