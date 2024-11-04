(function ($) {
  ("use strict");
    
   
     const counters = document.querySelectorAll(".counter");

counters.forEach((counter) => {
  counter.innerText = "0";

  const updateCounter = () => {
    const target = +counter.getAttribute("data-target");
    const c = +counter.innerText;

    const increment = target / 200;
    console.log(increment);

    if (c < target) {
      counter.innerText = `${Math.ceil(c + increment)}`;
      setTimeout(updateCounter, 1);
    } else {
      counter.innerText = target;
    }
  };

  updateCounter();
});

    
    
   
    $(".has-child a").on('mouseenter', function(){

        $(this).next(".dropdown_menu").toggleClass('active')
    })
    
     $("li.menu-item.has-child").on('mouseleave', function(){
        $(".dropdown_menu").removeClass('active')
    })
    $(".toggle_mobile").on('click', function(){
        $(".menu").toggleClass('open')
    })
    $(".mobile_menu_top").on('click', function(){
        $(".menu").toggleClass('open')
    })
    
    // work landing page sliders

      var swiper = new Swiper(".work", {
      slidesPerView: 1,
      spaceBetween: 0,
                 speed: 1000,
    loop: true,
                autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
navigation: {
        nextEl: ".swiper--next",
        prevEl: ".swiper--prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
               820: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
             912: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
          
            1190: {
          slidesPerView: 3,
          spaceBetween: 0,
        }
      },
    });
    
      var swiper3 = new Swiper(".about_slide", {
      slidesPerView: 1,
      spaceBetween: 20,
                 speed: 1000,
    loop: true,
          
            autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
             1300: {
          slidesPerView: 5,
          spaceBetween: 20,
        },
            1440: {
          slidesPerView: 5,
          spaceBetween: 20,
        },
             1920: {
          slidesPerView: 6,
          spaceBetween: 10,
        },
          
      },
    });
    
          var swiper2 = new Swiper(".services", {
      slidesPerView: 1,
      spaceBetween: 20,
               speed: 1000,
    loop: true,
                  autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
navigation: {
        nextEl: ".swiper--next",
        prevEl: ".swiper--prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
           820: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
          
            1190: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
            1280: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
           
            1440: {
          slidesPerView: 4,
          spaceBetween: 0,
        },
           1500: {
          slidesPerView: 5,
          spaceBetween: 0,
        },
      },
    });  
    
    var swiper3 = new Swiper(".tech-slider", {
      slidesPerView: 1,
      spaceBetween: 0,
               speed: 1000,
    loop: true,
                     autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
navigation: {
        nextEl: ".swiper--next",
        prevEl: ".swiper--prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
           820: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
          
            1190: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
            1280: {
          slidesPerView: 4,
          spaceBetween: 0,
        },
            1440: {
          slidesPerView: 4,
          spaceBetween: 0,
        },
      },
    });
    
$('#OpenImgUpload').click(function(){ $('#file').trigger('click'); })
    

	$("#mobile_code").intlTelInput({
		initialCountry: "us",
		separateDialCode: true,
	});
   
 

    
      // End of use strict
})(jQuery);



AOS.init({
	delay: 200,
	duration: 700
});




document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('wpcf7submit', function(event) {
        var dialCodeElement = document.querySelector('.iti__selected-dial-code');
        if (dialCodeElement) {
            var dialCode = dialCodeElement.innerText.trim();
            var phoneCountryCodeInput = document.getElementById('phone_country_code');
            if (phoneCountryCodeInput) {
                phoneCountryCodeInput.value = dialCode;
            }
        }
    }, false);
});
