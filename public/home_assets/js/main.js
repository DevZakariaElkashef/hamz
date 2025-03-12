$(document).ready(function(){

  "use strict";

  AOS.init();

  $(".owl-carousel").owlCarousel({
    autoplay: true,
    loop: true,
    margin: 0,
    responsiveClass: true,
    nav:false,
    responsive: {
      0: {
        items: 1.5,
        nav: true,
      },
      600: {
        items: 3,
        nav: false,
      },
      1000: {
        items: 5,
        nav: true,
        loop: false,
      },
    },
  });

})