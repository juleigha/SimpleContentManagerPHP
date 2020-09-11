
window.console = window.console || function (t) {
    };

$(document).ready(function(){
    $('.target-title1').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target
                || $('[name=' + this.hash.slice(1) +']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body')
                    .animate({scrollTop: targetOffset}, 2000);
                return false;
            }
        }
    });
});
$(document).ready(function(){
    $('.alc-link').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target
                || $('[name=' + this.hash.slice(1) +']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body')
                    .animate({scrollTop: targetOffset}, 2000);
                return false;
            }
        }
    });
});
//////////////////////////

$(document).ready(function(){
    // alert("pageload event fired!");
    $('.active').removeClass('active');

});

///////////carousel///////////////
$(document).ready(function () {
    $('#content-slider').lightSlider({
        item: 1,
        loop: true,
        auto: true,
        easing: 'linear',
        cssEasing: 'ease',
        pause:5000,
        pauseOnHover:true,
        animateOut: 'slideOutUp',
        slideMove:1,
        speed:700,
        spager: 2,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    item: 1,
                    slideMove: 1,
                    slideMargin: 6,
                }
            },

            {
                breakpoint: 767,
                settings: {
                    item: 1,
                    slideMove: 1
                }
            }]
    });
})

$(document).ready(function () {
    $('#content-slider-text').lightSlider({
        item: 1,
        loop: true,
        pause:5000,
        auto: true,
        pauseOnHover:true,
        speed: 900,
        mode: "string",
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        lspager: 2,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    item: 2,
                    slideMove: 1,
                    slideMargin: 6,
                }
            },

            {
                breakpoint: 767,
                settings: {
                    item: 1,
                    slideMove: 1
                }
            }]
    });
})
$(document).ready(function () {
    $('#product-slider').lightSlider({
        item: 2,
        loop: true,
        pause:5000,
        auto: true,
        pauseOnHover:true,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed: 600,
        lspager: 2,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    item: 2,
                    slideMove: 1,
                    slideMargin: 6,
                }
            },

            {
                breakpoint: 767,
                settings: {
                    item: 1,
                    slideMove: 1
                }
            }]
    });
})

$(document).ready(function () {
    $('#product-slider-box').lightSlider({
        item: 3,
        loop: true,
        auto: true,
        pause:6000,
        pauseOnHover:true,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed: 600,
        lspager:7,
        responsive: [
            //{
            //    breakpoint: 1200,
            //    settings: {
            //        item: 3,
            //        slideMove: 1,
            //        slideMargin: 6,
            //    }
            //},

            {
                breakpoint: 767,
                settings: {
                    item: 1,
                    slideMove: 1
                }
            }]
    });

})




function scrollWaypointInit( items, trigger ) {
    items.each( function() {
        var element = $(this),
            osAnimationClass = element.data("animation"),
            osAnimationDelay = element.attr('data-animation-delay');

        element.css({
            '-webkit-animation-delay':  osAnimationDelay,
            '-moz-animation-delay':     osAnimationDelay,
            'animation-delay':          osAnimationDelay
        });

        var trigger = ( trigger ) ? trigger : element;

        trigger.waypoint(function() {
            element.addClass('animated').addClass(osAnimationClass);
        },{
            // triggerOnce: true,
            offset: '80%'
        });
    });
}

//Call the init

$(document).ready(function(){

    scrollWaypointInit( $('.animateMe') );

});


//////////////////hamburger//////////////////
var toggles = document.querySelectorAll(".c-hamburger");

for (var i = toggles.length - 1; i >= 0; i--) {if (window.CP.shouldStopExecution(0)) break;
  var toggle = toggles[i];
  toggleHandler(toggle);
}
//window.CP.exitedLoop(0);;

function toggleHandler(toggle) {
  toggle.addEventListener("click", function (e) {
    e.preventDefault();
    if (this.classList.contains("is-active") === true) {
      this.classList.remove("is-active");
      $('.open').removeClass('oppenned');
    } else {
      this.classList.add("is-active");
      $(".open").addClass('oppenned');
    }
  });
}
$(".sub-menu li a").click(function (event) {
  $(".open").removeClass('oppenned');
  $(".c-hamburger").removeClass('is-active');
});



////////////////////slide down/////////////////



$(document).ready(function(){

    $(".generic-slider").slick({
        autoplay:true,
        autoplaySpeed:10000,
        speed:600,
        height:700,
        slidesToShow:1,
        slidesToScroll:1,
        pauseOnHover:false,
        dots:true,
        pauseOnDotsHover:true,
        cssEase:'linear',
        fade:true,
        draggable:false,
        prevArrow:'<button class="PrevArrow"></button>',
        nextArrow:'<button class="NextArrow"></button>',
    });

})










