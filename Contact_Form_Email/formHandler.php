<?php
//Call PHPMailer (sendEmail.php)
require __DIR__ . '/sendEmail.php';

// Honeypot check
if (!empty($_POST['honeypot'])) {
    // Send alert email to site owner
    $date = date('m/d/Y H:i:s');
    $subjectAlert = "Honeypot Triggered - Bot Attempt";
    $plainAlert   = "A bot attempted to submit the contact form on {$date}.";
    $htmlAlert    = "<html><body><h2>Honeypot Triggered</h2><p>A bot attempted to submit the contact form on {$date}.</p></body></html>";

    sendMail('trpk152@gmail.com','Site Owner',$subjectAlert,$htmlAlert,$plainAlert);

    // Stop normal processing
    die("<h2>Invalid submission detected.</h2>");
}

//Collect inputs, filter, and trim
$contactName  = htmlspecialchars(trim($_POST['contact_name']   ?? ''));
$contactEmail = filter_var($_POST['contact_email'] ?? '', FILTER_SANITIZE_EMAIL);
$reason       = htmlspecialchars(trim($_POST['reason']         ?? ''));
$comments     = htmlspecialchars(trim($_POST['comments']       ?? ''));

//Validate required fields
$errors = [];
if (!$contactName) {
    $errors[] = 'Contact Name is required.';
}
if (!$contactEmail || !filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid contact email address is required.';
}
if (!$reason) {
    $errors[] = 'Please select a reason for contact.';
}

if ($errors) {
    echo '<h2>Form Errors</h2><ul>';
    foreach ($errors as $e) {
        echo "<li>{$e}</li>";
    }
    echo '</ul><p><a href="EmailInputForm.html">Back to form</a></p>';
    exit;
}

//current date
$date = date('m/d/Y');

//Customer message body
//HEREDOC block enabling HTML and CSS within my php message body for consistent styling
$messageCust  = <<<HTML
<html>
<head>
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: lightgrey;
    margin: 2rem auto;
    max-width: 700px;
    color: #333;
    text-align: center;
    padding-bottom: 80px; /*space for footer*/
    }
    .container {
      width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h1, h2 {
      color: #003366;
      text-align: center;
    }
    .company-banner {
      background-color: #003366;
      color: #ffffff;
      font-family: 'Georgia', serif;
      font-size: 2rem;
      text-align: center;
      padding: 40px 20px;
      letter-spacing: 2px;
      margin-top: 30px;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Thank you, {$contactName}</h1>
    <p>We received your message on <strong>{$date}</strong>. Below is your contact reason:</p>
    <p><strong>Reason:</strong> {$reason}</p>
    <p><strong>Comments:</strong> {$comments}</p>
    <p>We'll review your request and be in touch soon.</p>
    <footer class="company-banner">
      Atlas Group Incorporated
    </footer>
  </div>
</body>
</html>
HTML;

//Owner message body
//Note: no styling for the internal message owner
//nl2br before comments preserves line breaks
$messageOwn  = "
<html>
<body>
  <h2>Contact Submission Details</h2>
  <ul>
    <li><strong>Date:</strong> {$date}</li>
    <li><strong>Name:</strong> {$contactName}</li>
    <li><strong>Email:</strong> {$contactEmail}</li>
    <li><strong>Reason:</strong> {$reason}</li>
    <li><strong>Comments:</strong><br>" . nl2br($comments) . "</li>
  </ul>
</body>
</html>";

//Message subject and plain text version (alt body)
//Note: use "" if not defining alt body
$subjectCust = 'Thank you for contacting Atlas Group Incorporated';
$plainCust   = "Hi {$contactName},\nWe received your message on {$date}.\nReason: {$reason}\nComments:\n{$comments}";

$subjectOwn  = "New Contact Form Submission: {$contactName}";
$plainOwn    = "New Contact Submission\nDate: {$date}\nName: {$contactName}\nEmail: {$contactEmail}\nReason: {$reason}\nComments:\n{$comments}";

//Send emails
sendMail($contactEmail, $contactName, $subjectCust, $messageCust, $plainCust);
sendMail('trpk152@gmail.com','Site Owner', $subjectOwn, $messageOwn, $plainOwn);

//Brwser confirmation message
echo '<h1>Thank You!</h1>';
echo "<p>A confirmation email has been sent to <strong>{$contactEmail}</strong>, we will be in touch soon.</p>";
?>

