<?php
if (isset($_POST['submit'])) {

    // Sanitize inputs
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $mobile  = trim($_POST['mobile']);
    $service = trim($_POST['service']);
    $message = trim($_POST['message']);

    // Basic validation
    if ($name == '' || $email == '' || $mobile == '' || $service == '' || $message == '') {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address.'); window.history.back();</script>";
        exit;
    }

    // Email settings
    $to = "customersupport@solvenhub.com";
    $subject = "New Enquiry - Solven Hub Office";

    $body = "
    <h2>New Contact Enquiry</h2>
    <p><strong>Company:</strong> Solven Hub Office</p>
    <p><strong>Name:</strong> {$name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Mobile:</strong> {$mobile}</p>
    <p><strong>Service:</strong> {$service}</p>
    <p><strong>Message:</strong><br>{$message}</p>
    <hr>
    <p>
        <strong>Contact Details:</strong><br>
        📧 customersupport@solvenhub.com<br>
        📞 +91 9152727611<br>
        📞 +1 645 246 4218
    </p>
    ";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Solven Hub Office <customersupport@solvenhub.com>\r\n";
    $headers .= "Reply-To: {$email}\r\n";

    // Send mail
    if (mail($to, $subject, $body, $headers)) {

        // Auto-reply to user
        $userSubject = "Thank You for Contacting Solven Hub Office";
        $userBody = "
        <p>Dear {$name},</p>
        <p>Thank you for contacting <strong>Solven Hub Office</strong>.</p>
        <p>We have received your enquiry regarding <strong>{$service}</strong>. Our team will contact you shortly.</p>
        <p>
            📧 customersupport@solvenhub.com<br>
            📞 +91 9152727611<br>
            📞 +1 645 246 4218
        </p>
        <p style='font-size:12px;color:#777;'>This is an automated email. Please do not reply.</p>
        ";

        $userHeaders  = "MIME-Version: 1.0\r\n";
        $userHeaders .= "Content-type: text/html; charset=UTF-8\r\n";
        $userHeaders .= "From: Solven Hub Office <customersupport@solvenhub.com>\r\n";

        mail($email, $userSubject, $userBody, $userHeaders);

        echo "<script>alert('Thank you! Your message has been sent successfully.'); window.location.href='contact.html';</script>";

    } else {
        echo "<script>alert('Something went wrong. Please try again later.'); window.history.back();</script>";
    }
}
?>
