$(function () {
    "use-strict";
    $(".sidenav-control-left").sideNav({ edge: "left", closeOnClick: !1 }),
        $(".sidenav-control-right").sideNav({ edge: "right", closeOnClick: !1 }),
        $(document).on("click", ".collapsible-header", function (e) {
            $(this).parent().siblings().find("span i").removeClass("fa-chevron-down"), $(this).find("span i").toggleClass("fa-chevron-down");
        }),
        $(".slider-slick").slick({ dots: !0, infinite: !0, speed: 300, slidesToShow: 1, autoplay: !0 }),
        $(document).on("click", ".faq-collapsible", function (e) {
            $(this).parent().siblings().find("i").removeClass("fa-minus"), $(this).find("i").toggleClass("fa-minus");
        }),
        $("#testimonial").owlCarousel({ slideSpeed: 300, paginationSpeed: 400, singleItem: !0 }),
        $("ul.tabs").tabs(),
        $("select").material_select();
        $("#date_of_birth").pickadate({ 
        selectMonths: !0, 
        selectYears: 142,
        format: 'dd-mm-yyyy',
        close: 'Close',
        closeOnSelect: true,
        autoClose: true,
        closeOnSelect: true,
        });
});
			