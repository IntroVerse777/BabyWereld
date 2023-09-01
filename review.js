// Load reviews from the JSON file
fetch('reviews.json')
    .then(response => response.json())
    .then(reviews => {
        const reviewsContainer = document.getElementById('customer-reviews');

        // Loop through the reviews and create HTML elements for each
        reviews.forEach(reviewData => {
            const reviewElement = document.createElement('div');
            reviewElement.classList.add('review');

            const reviewText = document.createElement('p');
            reviewText.innerHTML = `<strong>Review:</strong> ${reviewData.text}`;
            reviewElement.appendChild(reviewText);

            if (reviewData.photo) {
                const reviewImage = document.createElement('img');
                reviewImage.src = reviewData.photo;
                reviewElement.appendChild(reviewImage);
            }

            // Append the review element to the reviews container
            reviewsContainer.appendChild(reviewElement);
        });
    })
    .catch(error => console.error('Error loading reviews:', error));
