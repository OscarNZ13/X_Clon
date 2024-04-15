
document.addEventListener('DOMContentLoaded', function () {
    const tweetButton = document.getElementById('tweetButton');
    const tweetBox = document.getElementById('tweetBox');

    tweetButton.addEventListener('click', function () {
        if (tweetBox.style.display === 'none' || tweetBox.style.display === '') {
            tweetBox.style.display = 'block';
        } else {
            tweetBox.style.display = 'none';
        }
    });
});

