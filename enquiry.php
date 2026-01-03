<?php
if (isset($_POST['submit'])) {

    // 1. Sanitize and Strip Tags
    $name    = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mobile  = htmlspecialchars(strip_tags(trim($_POST['mobile'])));
    $service = htmlspecialchars(strip_tags(trim($_POST['service'])));
    $message = nl2br(htmlspecialchars(strip_tags(trim($_POST['message']))));

    // 2. Basic validation
    if (empty($name) || empty($email) || empty($mobile) || empty($service) || empty($message)) {
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

    // Headers (Note: Use your domain email in 'From' to avoid spam filters)
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Solven Hub Office <customersupport@solvenhub.com>\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";

    $body = "
    <h2>New Contact Enquiry</h2>
    <p><strong>Name:</strong> {$name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Mobile:</strong> {$mobile}</p>
    <p><strong>Service:</strong> {$service}</p>
    <p><strong>Message:</strong><br>{$message}</p>
    ";

    // Send mail
    if (mail($to, $subject, $body, $headers)) {
        
        // Auto-reply
        $userSubject = "Thank You for Contacting Solven Hub Office";
        $userBody = "<p>Dear {$name},</p><p>We have received your enquiry and will contact you shortly.</p>";
        $userHeaders = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: Solven Hub Office <customersupport@solvenhub.com>\r\n";
        
        mail($email, $userSubject, $userBody, $userHeaders);

        echo "<script>alert('Thank you! Message sent.'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Server error. Please try again later.'); window.history.back();</script>";
    }
}
?>
