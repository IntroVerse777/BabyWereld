<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $review = $_POST["review"];
    $uploadedPhoto = $_FILES["photo"];

    // Check if a photo was uploaded
    if ($uploadedPhoto["error"] === UPLOAD_ERR_OK) {
        $targetDir = "customer_photos/";
        $targetFile = $targetDir . basename($uploadedPhoto["name"]);

        // Check if the file already exists
        if (!file_exists($targetFile)) {
            // Move the uploaded photo to the "customer_photos" folder
            if (move_uploaded_file($uploadedPhoto["tmp_name"], $targetFile)) {
                // Photo was successfully uploaded
                $reviewData = [
                    'text' => $review,
                    'photo' => $targetFile
                ];

                // Load existing reviews from JSON file
                $existingReviews = json_decode(file_get_contents('reviews.json'), true);

                // Add the new review data to the array
                $existingReviews[] = $reviewData;

                // Save the updated reviews back to the JSON file
                file_put_contents('reviews.json', json_encode($existingReviews));

                echo "Review submitted with photo.";
            } else {
                // Failed to move the uploaded photo
                echo "Error uploading photo.";
            }
        } else {
            // File with the same name already exists
            echo "A file with the same name already exists.";
        }
    } else {
        // No photo was uploaded or an error occurred during upload
        $reviewData = [
            'text' => $review,
            'photo' => null
        ];

        // Load existing reviews from JSON file
        $existingReviews = json_decode(file_get_contents('reviews.json'), true);

        // Add the new review data to the array
        $existingReviews[] = $reviewData;

        // Save the updated reviews back to the JSON file
        file_put_contents('reviews.json', json_encode($existingReviews));

        echo "Review submitted without a photo.";
    }
} else {
    // Invalid request method
    echo "Invalid request.";
}
?>
