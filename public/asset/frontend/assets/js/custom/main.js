// HAMBURGER
var forEach = function (e, t, r) {
    if ("[object Object]" === Object.prototype.toString.call(e))
        for (var c in e) Object.prototype.hasOwnProperty.call(e, c) && t.call(r, e[c], c, e);
    else
        for (var a = 0, l = e.length; l > a; a++) t.call(r, e[a], a, e)
},
    hamburgers = document.querySelectorAll(".hamburger");
    hamburgers.length > 0 && forEach(hamburgers, function (e) {
    e.addEventListener("click", function () {
        this.classList.toggle("is-active")
    }, !1)
});


// Toggle main menu
$(function () {
	$('.main-nav__toggle').on('click', function () {
        if ($(".main-menu").hasClass("active")){
            $(".main-menu").removeClass("active");

        }else{
            $(".main-menu").addClass("active");
        }
	});
});


// Cambios al header al dar scroll
var flag = false;
var scroll;

$(window).scroll(function () {
    scroll = $(window).scrollTop();

    if (scroll > 10) {
        if (!flag) {
            $(".main-header").addClass('scroll');

            flag = true;
        }
    } else {
        if (flag) {
            $(".main-header").removeClass('scroll');
            flag = false;
        }
    }
});
