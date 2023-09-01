<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the review text
    $reviewText = $_POST["review"];

    // Check if a photo was uploaded
    $photoUploaded = isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK;

    // Store the review data (text and photo status) in an array
    $reviewData = [
        'text' => $reviewText,
        'photoUploaded' => $photoUploaded,
    ];

    // Load existing reviews from a JSON file (create 'reviews.json' if it doesn't exist)
    $existingReviews = file_exists('reviews.json') ? json_decode(file_get_contents('reviews.json'), true) : [];

    // Add the new review data to the array
    $existingReviews[] = $reviewData;

    // Save the updated reviews back to the JSON file
    file_put_contents('reviews.json', json_encode($existingReviews));

    // Email configuration
    $toEmail = "your_email@example.com"; // Replace with your email address
    $subject = "New Review Submitted";
    $message = "A new review has been submitted:\n\n";
    $message .= "Review Text: " . $reviewText . "\n";
    if ($photoUploaded) {
        $message .= "A photo was uploaded with the review.";
    } else {
        $message .= "No photo was uploaded with the review.";
    }

    // Send the email
    mail($toEmail, $subject, $message);

    // Provide a success message
    echo "Review submitted successfully!";
} else {
    // Invalid request method
    echo "Invalid request.";
}
?>
