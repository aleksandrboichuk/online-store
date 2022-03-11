if ($.fn.slider) {
  $("#sl2").slider();
}
var RGBChange = function () {
  $("#RGB").css(
    "background",
    "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
  );
};
$(window).on('load', function () {
  $('body').addClass('loaded_hiding');
  window.setTimeout(function () {
    $('body').addClass('loaded');
    $('body').removeClass('loaded_hiding');
  }, 500);
});

$(document).ready(function () {
  var url = location.href.split('/');
 if(url.length > 4) {
   if (url[4] == "women") {
     $('.mainmenu').find('a[class="women"]').css("color", "#6fa1f4").css("font-weight", "bold");
   } else if (url[4] == "men") {
     $('.mainmenu').find('a[class="men"]').css("color", "#6fa1f4").css("font-weight", "bold");
   } else if (url[4] == "girls" || url[4] == "boys"){
     $('.mainmenu').find('a[class="kids"]').css("color", "#6fa1f4").css("font-weight", "bold");

     // $('.kids').click(function () {
     //   let subMenu = $(this).parent().find('.sub-menu');
     //   console.log(1);
     //   if(subMenu.css('display') == 'block' ){
     //     subMenu.css('display', 'none');
     //   }else{
     //     subMenu.css('display', 'block');
     //   }
     // });

   }

 }

  $(function () {
    $.scrollUp({
      scrollName: "scrollUp",
      scrollDistance: 300,
      scrollFrom: "top",
      scrollSpeed: 300,
      easingType: "linear",
      animation: "fade",
      animationSpeed: 200,
      scrollTrigger: false,
      scrollText: '<i class="fa fa-angle-up"></i>',
      scrollTitle: false,
      scrollImg: false,
      activeOverlay: false,
      zIndex: 2147483647,
    });
  });



});



