<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the email input
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if ($email) {
        try {
            $sql = "SELECT COUNT(*) FROM newsletter_subscribers WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();

            if ($emailExists > 0) {
                echo "<script type='text/javascript'>
                        alert('This email is already subscribed to our newsletter.');
                        window.history.back(); // Redirects back to the form
                      </script>";
            } else {
                $sql = "INSERT INTO newsletter_subscribers (email) VALUES (:email)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email);

                if ($stmt->execute()) {
                    echo "<script type='text/javascript'>
                            alert('Thank you for subscribing to our newsletter!');
                            window.history.back(); // Redirects back to the previous page
                          </script>";
                } else {
                    echo "<script type='text/javascript'>
                            alert('Failed to subscribe. Please try again.');
                            window.history.back(); // Redirect back in case of failure
                          </script>";
                }
            }
        } catch (PDOException $e) {
            echo "<script type='text/javascript'>
                    alert('Error: " . $e->getMessage() . "');
                    window.history.back(); // Redirect back if an error occurs
                  </script>";
        }
    } else {
        echo "<script type='text/javascript'>
                alert('Please enter a valid email address.');
                window.history.back(); // Redirect back to the form
              </script>";
    }
}
?>