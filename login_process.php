<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Create connection
    $conn = pg_connect("host=localhost dbname=userdb user=postgres password=123");

    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    // Retrieve user data from the database using parameterized query
    $query = "SELECT id, name, password FROM users WHERE email = $1";
    $result = pg_query_params($conn, $query, array($email));

    if ($result) {
        $user = pg_fetch_assoc($result);

        // Directly compare the plain text password with the stored password
        if ($user && $password === $user['password']) {
            // Set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: index.html");
            exit();
        } else {
            header("Location: loginfail.html");
        }
    } else {
        echo "Error: " . pg_last_error($conn);
    }

    // Close connection
    pg_close($conn);
}
?>
