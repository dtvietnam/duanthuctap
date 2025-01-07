const containerheader = document.querySelector('.container-header');
const homeimage = document.querySelectorAll('.home-image');

const navigationslider = document.querySelector('.navigation-slider');
let currentSlide = 0;
let interver 
    const startInterval = () =>{
        interver = setInterval(() => {
            let width = containerheader.clientWidth;
            currentSlide = (currentSlide + 1) % homeimage.length;
            homeimage.forEach((image) => {
                image.style.transform = `translateX(-${width * currentSlide}px)`;
            });
        }, 5000);
    }
    
   
const nextSlide = () => {
    clearInterval(interver);
    let width = containerheader.clientWidth;
    currentSlide = (currentSlide + 1) % homeimage.length;
    homeimage.forEach((image) => {
        image.style.transform = `translateX(-${width * currentSlide}px)`;
    });
    startInterval();
}
const prevSlide = () => {
    clearInterval(interver);
    let width = containerheader.clientWidth;
    currentSlide = (currentSlide - 1 + homeimage.length) % homeimage.length;
    homeimage.forEach((image) => {
        image.style.transform = `translateX(-${width * currentSlide}px)`;
    });
    startInterval();
}


startInterval();