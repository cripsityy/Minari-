document.addEventListener('DOMContentLoaded', () => {

    const stars = document.querySelectorAll('.star');
    const commentInput = document.getElementById('comment');
    const submitBtn = document.getElementById('submitRatingBtn');
    const hideCheck = document.getElementById('hideUsername');

    let rating = 0;

    stars.forEach(star => {
        star.addEventListener('click', () => {
            rating = parseInt(star.getAttribute('data-value'));
            updateStars(rating);
        });
    });

    function updateStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));
            star.style.color = starValue <= value ? '#e5a391' : '#ddd';
        });
    }

    submitBtn.addEventListener('click', () => {
        const comment = commentInput.value.trim();
        const hideUser = hideCheck.checked;

        if (rating === 0) {
            alert('Silakan pilih rating bintang terlebih dahulu.');
            return;
        }

        if (comment === '') {
            alert('Tolong isi kolom komentar.');
            return;
        }

        alert(`Terima kasih!\nRating: ${rating} ★\nKomentar: ${comment}\nHide Username: ${hideUser ? 'Ya' : 'Tidak'}`);

        window.location.href = window.ROUTE_HOME;
    });

});
