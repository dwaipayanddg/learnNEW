<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampppp\htdocs\SumedhaShivani\PHPMailer-master\src\Exception.php';
require 'C:\xampppp\htdocs\SumedhaShivani\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampppp\htdocs\SumedhaShivani\PHPMailer-master\src\SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    

    

    // Create connection
    $conn = pg_connect("host=localhost dbname=userdb user=postgres password=123");

    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    // Insert user data into the database
    $query = "INSERT INTO users (name, email, password) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($name, $email, $password));

    if ($result) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->Debugoutput = 'html'; // Output format
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'dwaipayanddg@gmail.com'; // Replace with your SMTP username
            $mail->Password = 'unjv jmfu fstg fbyq'; // Replace with your SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('your_email@gmail.com', 'Mailer'); // Replace with your "from" email
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Our Service';
            $mail->Body    = "Hello $name,<br><br>Thank you for registering at our site.<br><br>Best regards,<br>The Team";

            $mail->send();
            header("Location: register_success.html");
        } catch (Exception $e) {
            echo "Registration successful, but email sending failed: {$mail->ErrorInfo}";
        }
    } else {
        header("Location:register_Fail.html");
    }

    // Close connection
    pg_close($conn);
}
?>
