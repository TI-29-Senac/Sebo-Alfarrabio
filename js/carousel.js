const images = [
    'img/espaco1.jpg',
    'img/espaco2.jpg',
    'img/espaco3.jpg'
];

let currentIndex = 0;

const imgElement = document.querySelector('.carousel-image');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

function updateImage() {
    imgElement.src = images[currentIndex];
}

function showNextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
}

function showPrevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage();
}

nextButton.addEventListener('click', showNextImage);
prevButton.addEventListener('click', showPrevImage);

// Initialize the carousel with the first image
updateImage();