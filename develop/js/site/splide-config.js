document.addEventListener('DOMContentLoaded', function() {
    const splideElements = document.querySelectorAll('.splide:not(#home-hero-splide)');
  
    splideElements.forEach(function(splideElement) {
        var splide = new Splide(splideElement);
  
        splide.mount();
    });
});
