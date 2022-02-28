if ($.fn.slider) {
  $("#sl2").slider();
}
var RGBChange = function () {
  $("#RGB").css(
    "background",
    "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
  );
};
$(document).ready(function () {
  var a = location.href;
  var b = a.split('/');
 if(b.length > 4) {
   if (b[4] == "women") {
     $('.mainmenu').find('a[class="women"]').css("color", "#fdb45e");
   } else if (b[4] == "men") {
     $('.mainmenu').find('a[class="men"]').css("color", "#fdb45e");
   } else if (b[4] == "girls" || b[4] == "boys"){
     $('.mainmenu').find('a[class="kids"]').css("color", "#fdb45e");
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


