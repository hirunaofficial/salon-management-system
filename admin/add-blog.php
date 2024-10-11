<?php
include '../dbconnect.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Function to send blog notification email to multiple recipients
function sendBlogNotificationEmail($title, $content, $tags, $subscribers) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->setFrom($_ENV['SMTP_USER'], 'Glamour Salon');

        // Add all subscriber emails
        foreach ($subscribers as $subscriber) {
            $mail->addAddress($subscriber['email']);
        }

        $mail->isHTML(true);
        $mail->Subject = 'New Blog Post: ' . $title;
        $mail->Body = "<h2>New Blog Post Published</h2>
                       <p><strong>$title</strong></p>
                       <p>$content</p>
                       <p>Tags: $tags</p>
                       <p>Check out the latest blog post on Glamour Salon!</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    
    $target_dir = "../images/blog/";
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imagePath = $target_dir . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
        $imagePath = 'images/blog/' . basename($image['name']);
    }

    try {
        // Insert the blog post including the image, category, and tags
        $stmt = $pdo->prepare("INSERT INTO blog (title, content, image, post_date, category, tags) VALUES (:title, :content, :image, CURDATE(), :category, :tags)");
        $stmt->execute(['title' => $title, 'content' => $content, 'image' => $imagePath, 'category' => $category, 'tags' => $tags]);

        // Fetch all emails from newsletter_subscribers table
        $stmt_subscribers = $pdo->prepare("SELECT email FROM newsletter_subscribers");
        $stmt_subscribers->execute();
        $subscribers = $stmt_subscribers->fetchAll(PDO::FETCH_ASSOC);

        if (sendBlogNotificationEmail($title, $content, $tags, $subscribers)) {
            header('Location: manage-blog.php?added=success');
        } else {
            header('Location: manage-blog.php?added=success&mail=failed');
        }
    } catch (Exception $e) {
        header('Location: manage-blog.php?added=error');
    }
    exit;
}