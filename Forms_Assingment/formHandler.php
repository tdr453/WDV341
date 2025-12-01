<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 4-1 formHandler</title>
<style>
form {
    width:700px;
    margin:auto;
    background-color:lightblue;	
    padding-left: 20px;
}

form legend {
    font-size:larger;
    text-align:center;
}

body {
    font-family: Arial, sans-serif;
    background-color: lightyellow;
    margin: 2rem auto;
    max-width: 1000px;
}

h1, h2 {
    color: darkblue;
}

.checkbox-list {
  margin: 0.5rem 0 1.5rem 2rem;
  padding: 0;
  list-style-type: disc;
}

.checkbox-list li {
  margin-bottom: 0.5rem;
}

</style>

</head>

<body>
<h1>WDV341 Intro to PHP</h1>
<h2>4-1 HTML Form Processor</h2>

<?php
// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // honeypot check
  if (!empty($_POST['honeypot'])) {
      die("Spam detected. Submission rejected.");
  }

  // Collect the values
  $firstName = $_POST['first_name'];
  $lastName  = $_POST['last_name'];   // <-- Added
  $email     = $_POST['customer_email'];
  $standing  = $_POST['academic_standing'];
  $major     = $_POST['program'];
  $comments  = $_POST['comments'];
  $contactInfo    = isset($_POST['contact_info']) ? "Please contact me with program information<br>" : "";
  $contactAdvisor = isset($_POST['contact_advisor']) ? "I would like to contact a program advisor<br>" : "";

  // Success message
  echo "<p>Thank you $firstName $lastName</p>";
  echo "<p>A signup confirmation has been sent to $email. Thank you for your support!</p>";

} else {
  echo "Invalid request. Please submit the form.";
}
?>

<p>
  Dear <?php echo $firstName;?>,
</p>

<p>
  Thank you for your interest in DMACC.
</p>

<p>
  We have you listed as a <?php echo $standing;?> starting this fall.
</p>

<p>
  You have declared <?php echo $major;?> as your major.
</p>

<p>
  Based upon your responses we will provide the following information in our confirmation email to you at 
  <?php echo $email;?>.<br>
</p>

<?php if ($contactInfo || $contactAdvisor):?>
  <ul class="checkbox-list">
    <?php if ($contactInfo): ?>
      <li>Please contact me with program information</li>
    <?php endif; ?>
    <?php if ($contactAdvisor): ?>
      <li>I would like to contact a program advisor</li>
    <?php endif;?>
  </ul>
<?php endif;?>


<p>
  You have shared the following comments which we will review:
  <?php echo $comments;?>
</p>

</body>
</html>
