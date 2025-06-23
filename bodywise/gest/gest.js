// Animation d'apparition des sections
document.addEventListener('scroll', () => {
    const infoSection = document.getElementById('informations');
    const sectionPosition = infoSection.getBoundingClientRect().top;
    const screenHeight = window.innerHeight;

    if (sectionPosition < screenHeight) {
        infoSection.style.opacity = 1;
        infoSection.style.transform = 'translateY(0)';
    }
});

/
// services
let currentIndex = 0;
const totalItems = 6; // Total d'éléments dans le carousel
const visibleItems = 2; // Nombre d'éléments visibles
const carousel = document.querySelector('.carousel');

function updateCarousel() {
  const offset = -currentIndex * 100 / visibleItems;
  carousel.style.transform = `translateX(${offset}%)`;
}

function nextSlide() {
  if (currentIndex < totalItems / visibleItems - 1) {
    currentIndex++;
  } else {
    currentIndex = 0; // Revenir au début
  }
  updateCarousel();
}

function prevSlide() {
  if (currentIndex > 0) {
    currentIndex--;
  } else {
    currentIndex = totalItems / visibleItems - 1; // Aller à la fin
  }
  updateCarousel();
}
// Navigation automatique
function startAutoSlide() {
    setInterval(nextSlide, 5000); // Changer de slide toutes les 5 secondes
  }
  
  // Initialisation de la navigation automatique
  startAutoSlide();

  document.addEventListener("DOMContentLoaded", () => {
    const heroImage = document.querySelector(".hero-image");
    const shimmerTexts = document.querySelectorAll(".shimmer-text");
    const button = document.querySelector(".sign-up-btn");
  
    // Animation d'apparition pour l'image
    heroImage.style.opacity = "1";
    heroImage.style.transform = "scale(1)";
  
    // Animation pour le texte
    shimmerTexts.forEach((text, index) => {
      setTimeout(() => {
        text.style.opacity = "1";
      }, index * 500);
    });
  
    // Animation du bouton
    setTimeout(() => {
      button.style.transform = "scale(1.1)";
    }, 1000);
  });
  
