<?php
// Error reporting for debugging (turn off in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection file
require_once 'db_connect.php';

// Configuration
$recipient_email = "support@yourdomain.com"; // Change this to your support email
$subject_prefix = "[Support Ticket] ";
$min_message_length = 10;
$max_message_length = 1000;

// Initialize variables
$errors = [];
$success = false;
$name = $email = $subject = $message = "";

// Process form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize inputs
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Validate inputs
    if (empty($name)) {
        $errors[] = "Please enter your name.";
    }
    
    if (empty($email)) {
        $errors[] = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (empty($subject)) {
        $errors[] = "Please enter a subject.";
    }
    
    if (empty($message)) {
        $errors[] = "Please enter your message.";
    } elseif (strlen($message) < $min_message_length) {
        $errors[] = "Message must be at least $min_message_length characters.";
    } elseif (strlen($message) > $max_message_length) {
        $errors[] = "Message must be less than $max_message_length characters.";
    }
    
    // Check for bot-like behavior (honeypot field)
    if (!empty($_POST["website"])) {
        $errors[] = "Spam detected.";
    }
    
    // If no errors, process the submission
    if (empty($errors)) {
        try {
            // Begin transaction
            $conn->beginTransaction();
            
            // 1. Save to database
            $stmt = $conn->prepare("INSERT INTO support_tickets 
                                   (name, email, subject, message, ip_address, created_at) 
                                   VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $subject, $message, $ip_address]);
            $ticket_id = $conn->lastInsertId();
            
            // 2. Send email
            $email_subject = $subject_prefix . "[Ticket #$ticket_id] " . $subject;
            $email_body = "You have received a new support request (Ticket #$ticket_id).\n\n".
                          "Name: $name\n".
                          "Email: $email\n".
                          "IP Address: $ip_address\n\n".
                          "Message:\n$message";
            $headers = "From: $name <$email>" . "\r\n" .
                       "Reply-To: $email" . "\r\n" .
                       "X-Mailer: PHP/" . phpversion();
            
            $mail_sent = mail($recipient_email, $email_subject, $email_body, $headers);
            
            if ($mail_sent) {
                $conn->commit();
                $success = true;
                // Clear form fields
                $name = $email = $subject = $message = "";
            } else {
                $conn->rollBack();
                $errors[] = "Message was saved but we couldn't send the confirmation email.";
            }
            
        } catch (PDOException $e) {
            $conn->rollBack();
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Support</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px; }
        .error { color: red; }
        .success { color: green; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; }
        textarea { height: 150px; }
        .honeypot { display: none; }
    </style>
</head>
<body>
    <h1>Contact Support</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="success">
            <p>Thank you! Your message has been sent successfully (Ticket #<?php echo $ticket_id; ?>). We'll get back to you soon.</p>
        </div>
    <?php endif; ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($subject); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required><?php echo htmlspecialchars($message); ?></textarea>
        </div>
        
        <!-- Honeypot field to catch bots -->
        <div class="honeypot">
            <label for="website">Website:</label>
            <input type="text" id="website" name="website">
        </div>
        
        <div class="form-group">
            <button type="submit">Send Message</button>
        </div>
    </form>
</body>
</html>