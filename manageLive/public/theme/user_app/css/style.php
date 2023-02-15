<?php
use DB;
use Auth;

    
    $restaturant_id = "11";

    $menus = DB::select('select * from restaurants where restaurant_id = '.$restaturant_id);

    if ($menus) 
    {
        $restaurant_details = $menus[0];
    }
    else
    {
        $restaurant_details = array();
    }

    $app_theme_color_1 = "#6742a8";

    if ($restaurant_details->app_theme_color_1 != "") 
    {
        $app_theme_color_1 = $restaurant_details->app_theme_color_1;
    }

    header("Content-type: text/css; charset: UTF-8");
?>


/*@import url(https://fonts.googleapis.com/css?family=Niconne);
@import url(https://fonts.googleapis.com/css?family=Muli:400, 400i|Roboto + Condensed:400, 600, 700);*/
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

.blog .entry .user-date ul,
.blog .pagination ul,
.blog-single .entry .user-date ul,
.blog-single .share ul,
footer .icon-social {
    list-style: none;
}
*,
:after,
:before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.container {
    margin: 0 auto;
    max-width: 1280px;
    width: 95%;
}
body {
    margin: 0;
    padding: 0;
    background: #fff;
    color: #888;
    /*font-family: sans-serif;*/
    font-family: 'Open Sans', sans-serif;
}
body::-webkit-scrollbar {
    display: none;
}
h1,
h2,
h3,
h4,
h5,
h6 {
    padding: 0;
    margin: 0;
    color: #343434;
    font-family: sans-serif, sans-serif;
}
.app-title h4,
.site-title h1 {
    font-family: Niconne, cursive;
}
h1 {
    font-size: 36px;
}
h2 {
    font-size: 34px;
}
h3 {
    font-size: 30px;
}
h4 {
    font-size: 26px;
}
h5 {
    font-size: 20px;
}
h6 {
    font-size: 16px;
}
a {
    color: #333;
}
.button,
.panel-control-left .sidenav-control-left i {
    color: #fff;
}
p {
    margin: 8px 0;
}
.button {
    background: <?php echo $app_theme_color_1; ?>;
    border: 0 transparent;
    padding: 5px 12px;
    border-radius: 2px;
    font-size: 12px;
    font-weight: 700;
}
.navbar {
    width: 100%;
    height: 60px;
    padding: 9px 0;
    z-index: 9;
    background: <?php echo $app_theme_color_1; ?>;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    text-align: center;
    border-bottom: 2px solid #6742a8;
}
.panel-control-left .side-nav .collapsible-header:hover,
.side-nav a:hover {
    background: 0 0;
}
.site-title {
    display: inline-block;
    margin-left:8px;
    position: relative;
    top: -3px;
}
.site-title h1 {
    font-size: 36px;
    padding: 0;
    margin: 0;
    font-weight: 700;
    color: #fff;
}
.side-nav a {
    padding: 0 16px;
}
.panel-control-left {
    float: left;
    font-size: 20px;
    margin-top: 5px;
}
.panel-control-left ul {
    padding: 10px 0;
}
.panel-control-left ul li {
    border-bottom: dotted 1px #eee;
}
.panel-control-left .collapsible-body ul li:last-child {
    margin-bottom: 0;
}
.panel-control-left ul li:last-child {
    border-bottom: 0;
    margin-bottom: 80px;
}
.panel-control-left ul li a {
    font-size: 15px;
    font-weight: bold;
}
.panel-control-left .side-nav li a i {
    margin-right: 5px;
    color: #6742a8;
}
.panel-control-left .side-nav .collapsible-header {
    font-size: 15px;
    color: rgba(0, 0, 0, 0.87);
    font-weight: bold;
}
.panel-control-left .side-nav .collapsible-header span i {
    float: right;
    text-align: right;
    font-size: 12px;
}
.panel-control-left .side-nav .collapsible-header.active {
    border-bottom: dotted 1px #ddd;
}
.panel-control-left .side-nav li.active {
    border-bottom: solid 1px #eee;
    background: 0 0;
}
.panel-control-left .side-nav .collapsible-header i {
    color: #6742a8;
    font-size: 16px;
    width: 24px;
    margin-right: 5px;
    text-align: left;
}
.panel-control-left .collapsible-body ul {
    padding: 0;
    margin: 0;
}
.panel-control-left .collapsible-body ul li a {
    padding-left: 45px;
    height: 40px;
    line-height: 40px;
}
.panel-control-left .categories-in li {
    line-height: 40px;
}
.panel-control-left .categories-in .collapsible-header {
    padding-left: 45px;
}
.panel-control-left .categories-in .collapsible-body ul li a {
    /*height: 36px;
    line-height: 36px;
    padding-left: 60px;*/
        height: auto;
    line-height: 36px;
    padding-left: 60px;
        padding: 0px 30px 0px 60px;
}
.panel-control-right {
    float: right;
    font-size: 20px;
}
.panel-control-right h6 {
    font-size: 16px;
}
.panel-control-right .side-nav li a i {
    margin-right: 5px;
}
.panel-control-right .sidenav-control-right i {
    right: -8px;
    position: relative;
    font-size: 18px;
    color: #fff;
}
.panel-control-right .sidenav-control-right span {
    background: #6742a8;
    border-radius: 50%;
    color: #fff;
    position: relative;
    bottom: 8px;
    padding: 1px 5px;
    font-size: 12px;
}
.panel-control-right img {
    width: 100%;
    height: 100%;
}
.panel-control-right .side-nav {
    padding: 30px 10px;
}
.panel-control-right .action i {
    float: right;
    cursor: pointer;
    font-size: 18px;
}
.panel-control-right .entry {
    border-bottom: 1px solid #eee;
    padding-bottom: 12px;
}
.panel-control-right .desc .rating {
    position: relative;
    bottom: 5px;
}
.panel-control-right .desc i {
    font-size: 14px;
}
.panel-control-right .desc h6 span {
    color: #6742a8;
}
.panel-control-right .price {
    text-align: right;
}
.panel-control-right ul li {
    display: inline-block;
    text-align: right;
    float: right;
    margin: 10px 10px 10px 0;
}
.panel-control-right ul li .button {
    font-size: 16px;
    line-height: 25px;
    position: relative;
    bottom: 20px;
}
.slider-slick {
    position: relative;
    overflow: hidden;
}
.slider-slick .slider-entry {
    position: relative;
    height: auto;
}
@media (min-width: 768px) {
    .slider-slick .slider-entry {
        position: relative;
        height: 430px;
    }
}
.slider-slick .overlay {
    background: rgba(0, 0, 0, 0.67);
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    right: 0;
}
.slider-slick img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.slider-slick .caption {
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
    top: 25%;
    color: #fff;
    z-index: 999;
    overflow-wrap: break-word;
    text-align: center;
}
.blog-single .author .entry,
.chef .entry,
.chef .entry .content,
.menu-list .entry,
.menu-list .entry .content,
.review .comment .content .entry {
    overflow: hidden;
}
.slider-slick .caption h2 {
    color: #fff;
}
.slider-slick .slick-dots {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: block;
    width: 100%;
}
.slider-slick .slick-dots li {
    width: auto;
}
.slider-slick .slick-dots li button {
    width: 10px;
    height: 10px;
    background: #fff;
    border-radius: 50%;
}
.offers .entry i,
.slider-slick .slick-dots li.slick-active button {
    background: #6742a8;
}
.slider-slick .slick-dots li button::before {
    font-size: 0;
    color: transparent;
}
.offers {
    text-align: center;
    padding: 15px 0;
}
.offers .entry i {
    width: 80px;
    height: 80px;
    color: #fff;
    border-radius: 50%;
    font-size: 35px;
    text-align: center;
    line-height: 70px;
    margin-bottom: 14px;
    border: 6px double #fff;
}
.menu .content .entry img,
.menu-grid .entry img {
    /*width:100%;height:100%*/
}
.rating {
    font-size: 12px;
    margin-top: 5px;
}
.open-hours {
    text-align: center;
    color: #fff;
    background: linear-gradient(rgba(12, 11, 11, 0.82), rgba(12, 11, 11, 0.82)), url(../img/fixed.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-color: #333;
}
.open-hours .entry {
    border: 1px solid #fff;
    padding: 25px 16px;
    margin-bottom: 10px;
}
.menu .content .entry,
.menu-grid .entry {
    border-radius: 0px;
    padding: 10px;
    text-align: center;
    position: relative;
}
.open-hours .app-title h4,
.open-hours .entry h5 {
    color: #fff;
}
.open-hours .entry h6 {
    margin-top: 5px;
    color: #eee;
}
.open-hours .entry .dividing {
    margin: 15px 0;
}
.menu {
    text-align: center;
}
.menu .app-title {
    margin-bottom: 10px;
}
.menu .content .tabs {
    margin-bottom: 10px;
    text-align: center;
}
.menu .content .tabs .tab {
    text-transform: none;
}
.menu .content .tabs .tab a {
    color: #444;
    font-size: 14px;
}
.menu .content .tabs .tab a.active {
    color: #6742a8;
}
.menu .content .tabs .indicator {
    background: 0 0;
}
.menu .content .entry .button {
    margin-top: 10px;
    margin-bottom: 5px;
}
.menu .content .entry .price,
.menu .content .entry .rating,
.menu .content .entry h6 {
    margin-top: 2px;
}
.menu-grid .entry .button {
    margin-top: 10px;
    margin-bottom: 5px;
}
.rating .active {
    color: #fecd2d;
}
.menu-grid .entry .price,
.menu-grid .entry .rating,
.menu-grid .entry h6 {
    margin-top: 2px;
}
.menu-list .entry {
    /*border:1px solid #ddd;*/
    padding: 15px;
    margin-bottom: 20px;
}
.menu-list .entry img {
    float: left;
    width: 120px;
    height: auto;
    margin-right: 16px;
}
.menu-list .entry .content ul {
    padding: 0;
    margin: 0;
}
.menu-list .entry .content ul li {
    display: inline-block;
    margin-right: 6px;
}
.menu-list .entry .content ul li a i {
    width: 20px;
    height: 20px;
    background: #f5f5f5;
    line-height: 20px;
    text-align: center;
}
.menu-list .entry .content .price {
    margin-top: 5px;
}
.menu-list .entry .content .button {
    margin-top: 12px;
}
.chef .entry {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 20px;
}
.chef .entry img {
    float: left;
    width: 100px;
    height: auto;
    margin-right: 16px;
}
.chef .entry .content ul {
    padding: 0;
    margin: 0;
}
.chef .entry .content ul li {
    display: inline-block;
    margin-right: 6px;
}
.chef .entry .content ul li a i {
    width: 20px;
    height: 20px;
    background: #f5f5f5;
    line-height: 20px;
    text-align: center;
}
.reservation .order {
    background: #fefefe;
    margin-top: 25px;
    padding: 16px 12px 2px;
    border: 1px solid #ddd;
    margin-bottom: 35px;
}
.reservation .order .title {
    text-align: center;
}
.reservation .order h5 {
    margin-bottom: 14px;
}
.reservation .order h5 span {
    font-size: 18px;
}
.reservation .order h6 {
    margin-bottom: 8px;
    font-size: 16px;
    color: #666;
}
.reservation .link {
    position: relative;
    top: -12px;
}
.reservation .order .text-right {
    text-align: right;
}
.reservation .order .button {
    margin: auto;
    display: block;
}
.app-section {
    padding: 40px 0;
}
.app-pages {
    margin-top: 60px;
}
.app-title {
    text-align: center;
    margin-bottom: 30px;
}
.app-title h4 {
    font-size: 40px;
}
.app-title .line {
    padding: 0;
    margin: 0;
}
.app-title .line li {
    display: inline-block;
}
.app-title .line li i {
    color: #6742a8;
}
.app-title .line .line-center {
    font-size: 20px;
    vertical-align: middle;
}
.pages-title {
    margin-bottom: 30px;
    text-align: center;
}
.pages-title h3 {
    font-size: 28px;
}
.app-bg-dark {
    background: #f3f3f3;
}
.app-bg-light {
    background: #fff;
}
.app-bg-light .entry {
    background: #f3f3f3;
}
.app-last-row {
    margin-bottom: 0;
}
.product-details .entry {
    position: relative;
}
.product-details .entry img {
    width: 100%;
    height: 100%;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 5px;
}
.product-details .entry .tabs {
    height: auto;
}
.product-details .entry .tabs a.active {
    border: 1px solid #6742a8;
}
.product-details .entry .tabs a {
    border: 1px solid #ddd;
}
.product-details .entry .tabs img {
    border: 0;
}
.product-details .entry .tabs .indicator {
    height: 0;
    background: 0 0;
}
.product-details .entry .tabs .tab {
    height: auto;
}
.product-details .details .button {
    margin-top: 20px;
}
.product-details .desc-review {
    margin-top: 30px;
}
.product-details .desc-review .tabs {
    height: 30px;
}
.product-details .desc-review .tabs .indicator {
    background: #6742a8;
}
.product-details .desc-review .tab {
    height: 30px;
    text-transform: none;
}
.review .comment .content .entry {
    margin-bottom: 22px;
}
.review .comment .content p {
    margin: 8px 0;
}
.review .comment .content img {
    width: 80px;
    height: 80px;
    float: left;
    margin-right: 15px;
    border-radius: 50%;
}
.review .comment .content {
    border-bottom: 1px solid #eee;
    padding-top: 20px;
    margin-top: 10px;
}
.review .post-review {
    margin-top: 20px;
}
.review .post-review h6 {
    margin-bottom: 15px;
}
.product-cart .entry {
    border: 1px solid #ddd;
    padding: 10px 16px 0 10px;
}
.product-cart .cart-total h6,
.product-cart .entry h6 {
    font-size: 15px;
}
.product-cart .entry img {
    width: 100%;
    height: 100%;
    border: 1px solid #ddd;
}
.product-cart .entry .cart-title {
    padding: 10px 0 0;
}
.product-cart .entry .cart-title i {
    text-align: right;
    float: right;
}
.product-cart .entry .s-title {
    border-top: 1px solid #ddd;
    padding-top: 20px;
}
.product-cart .entry input[type="number"] {
    height: 25px;
    border: 1px solid #ccc;
    padding: 0;
    width: 40px;
    text-align: center;
    position: relative;
    bottom: 4px;
}
.blog .entry img,
.blog-single .entry img,
.categories .entry img {
    width: 100%;
    height: 100%;
}
.product-cart .cart-total {
    text-align: right;
    margin-top: 25px;
}
.product-cart .cart-total h5,
.product-cart .cart-total h6 {
    margin-bottom: 10px;
}
.product-cart .cart-total .button {
    text-align: center;
    margin-right: 10px;
    margin-top: 10px;
}
.categories .entry {
    border: 1px solid #ddd;
    text-align: center;
}
.categories .entry h6 {
    padding: 0 12px;
}
.categories .entry span {
    display: block;
    padding: 2px 12px 15px;
}
.categories .entry img {
    margin-top: 10px;
    margin-bottom: 10px;
}
.blog {
    position: relative;
}
.blog .entry {
    margin-bottom: 30px;
}
.blog .entry .user-date ul li {
    display: inline-block;
    margin-right: 12px;
}
.blog .entry .user-date ul li a i {
    margin-right: 6px;
    color: #6742a8;
}
.blog .pagination ul {
    margin-top: 40px;
    text-align: center;
}
.blog .pagination ul li {
    display: inline-block;
    background: #f3f3f3;
    margin: 0 2px;
    border: 1px solid #dedede;
}
.picker--focused .picker__day--selected,
.picker__day--selected:hover,
form .picker__date-display,
form .picker__day--selected,
form .picker__weekday-display {
    background-color: #6742a8;
}
.login .or h5,
.picker__nav--next:hover,
form .picker__nav--prev:hover {
    background: #6742a8;
}
.blog .pagination ul .active {
    background: #6742a8;
    color: #fff;
    border-color: #6742a8;
}
.blog-single {
    position: relative;
}
.blog-single .entry {
    margin-bottom: 30px;
}
.blog-single .entry .user-date ul li {
    display: inline-block;
    margin-right: 12px;
}
.blog-single .entry .user-date ul li a i {
    margin-right: 6px;
    color: #6742a8;
}
.blog-single .share ul {
    margin-top: 15px;
}
.blog-single .share ul li {
    display: inline-block;
}
.blog-single .share ul li h6 {
    margin-right: 4px;
    position: relative;
    bottom: 2px;
}
.blog-single .share ul li a i {
    font-size: 20px;
    margin: 0 4px;
}
.blog-single .author {
    border-top: 1px solid #eee;
    padding-top: 20px;
    position: relative;
}
.blog-single .author p {
    margin: 8px 0;
}
.blog-single .author img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    float: left;
    margin-right: 15px;
}
.blog-single .author .entry ul {
    padding: 0;
    margin: 0;
}
.blog-single .author .entry ul li {
    display: inline-block;
    margin-right: 3px;
}
.blog-single .comment .content .entry {
    overflow: hidden;
    margin-bottom: 22px;
}
.blog-single .comment .content p {
    margin: 8px 0;
}
.blog-single .comment .content,
.blog-single .post-comment .content {
    border-top: 1px solid #eee;
    padding-top: 20px;
    margin-top: 10px;
}
.blog-single .post-comment .content textarea,
form textarea {
    margin-bottom: 20px;
}
.blog-single .comment .content img {
    width: 80px;
    height: 80px;
    float: left;
    margin-right: 15px;
}
@media (min-width: 768px) {
    .blog-single .comment .content {
        border-top: 1px solid #eee;
        padding-top: 20px;
        margin-top: 10px;
        padding-bottom: 10px;
    }
}
form .select-wrapper input.select-dropdown,
form input[type="number"],
form input[type="text"],
form input[type="email"],
form input[type="password"],
form input[type="tel"],
form input[type="date"] {
    border: 1px solid #ddd;
    height: 36px;
    border-radius: 2px;
    width: 100%;
    overflow: visible;
    padding: 0 10px;
    box-sizing: border-box;
}
form input:not([type]):focus:not([readonly]),
form input[type="number"]:focus:not([readonly]),
form input[type="text"]:focus:not([readonly]),
form input[type="email"]:focus:not([readonly]),
form input[type="password"]:focus:not([readonly]),
form input[type="tel"]:focus:not([readonly]),
form input[type="date"]:focus:not([readonly]) {
    border-bottom: 1px solid #ddd;
    box-shadow: none;
}
form textarea {
    border: 1px solid #ddd;
    border-radius: 2px;
    width: 100%;
    overflow: visible;
    padding: 10px;
    box-sizing: border-box;
    height: auto;
}
form .picker__day.picker__day--today {
    color: #6742a8;
}
::-webkit-input-placeholder {
    color: #666;
}
:-moz-placeholder {
    color: #666;
}
::-moz-placeholder {
    color: #666;
}
:-ms-input-placeholder {
    color: #666;
}
.login strong {
    display: block;
    position: relative;
    bottom: 5px;
}
.login .forgot {
    margin-bottom: 10px;
    display: block;
}
.login [type="checkbox"] + label {
    padding-left: 30px;
    color: #333;
}
.login .or h5,
.register .or h5 {
    height: 40px;
    color: #fff;
    line-height: 40px;
    border-radius: 50%;
    text-align: center;
}
.login [type="checkbox"]:checked + label::before {
    border-right: 2px solid #6742a8;
    border-bottom: 2px solid #6742a8;
}
.login .button {
    margin-top: 12px;
    margin-bottom: 24px;
    width: 100%;
}
.login .create-account {
    text-align: center;
}
.login .or h5 {
    width: 40px;
    margin: 10px auto;
}
.login .or .button {
    margin-top: 12px;
    margin-bottom: 12px;
}
.login .facebook {
    background: #3b5998;
}
.login .twitter {
    background: #00aced;
}
.login .google {
    background: #dd4b39;
}
.register .button {
    margin-top: 5px;
    margin-bottom: 14px;
    width: 100%;
}
.register .login-now {
    text-align: center;
    display: block;
}
.register .or h5 {
    width: 40px;
    background: #6742a8;
    margin: 20px auto 10px;
}
.register .or .button {
    margin-top: 12px;
    margin-bottom: 12px;
}
.register .facebook {
    background: #3b5998;
}
.register .twitter {
    background: #00aced;
}
.register .google {
    background: #dd4b39;
}
.page-404 {
    text-align: center;
}
.page-404 h3 {
    font-size: 96px;
}
.page-404 h3 span {
    color: #6742a8;
}
.page-404 .button {
    margin: 10px 0;
    display: inline-block;
}
.page-404 .button a {
    color: #fff;
}
.testimonial {
    text-align: center;
}
.testimonial .app-title {
    margin-bottom: 10px;
}
.testimonial img {
    border-radius: 50%;
    margin: 5px 0;
    height: 60px;
    width: 60px;
}
.faq .collapsible {
    border: none;
    box-shadow: none;
}
.faq .collapsible li {
    margin-bottom: 6px;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
}
.faq .collapsible li .collapsible-header {
    font-size: 16px;
    color: #666;
}
.faq .collapsible li .collapsible-header i {
    float: right;
    margin-right: 0;
    width: auto;
    font-size: 14px;
}
.faq .collapsible li .collapsible-body p {
    padding: 16px;
}
footer {
    background: #111;
    text-align: center;
    padding: 40px 0;
    display: block;
}
footer h6 {
    color: #ddd;
}
footer .icon-social {
    padding: 0;
    margin: 20px 0 15px;
}
footer .icon-social li {
    display: inline-block;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    margin: 0 3px;
    border-radius: 100%;
}
footer .icon-social .facebook {
    background: #3b5998;
}
footer .icon-social .twitter {
    background: #00aced;
}
footer .icon-social .google {
    background: #dd4b39;
}
footer .icon-social .instagram {
    background: #517fa6;
}
footer .icon-social .rss {
    background: #fe7e00;
}
footer ul li a {
    color: #fff;
}
footer .tel-fax-mail ul {
    list-style: none;
    padding: 0;
    margin: 0;
    color: #bbb;
}
footer .tel-fax-mail ul li {
    padding: 4px 0;
}
footer .tel-fax-mail ul li span {
    font-weight: 700;
    padding: 0;
    margin: 0;
}
footer .ft-bottom {
    border-top: 1px solid #222;
    margin-top: 20px;
    padding-top: 20px;
    color: #999;
}
.navbar .panel-control-right {
    display: none;
}
.entry h5 a {
    font-weight: 600;
    margin-top: 6px;
    font-size: 15px;
    color: #6742a8;
}
.tabs .tab a {
    text-transform: capitalize;
    font-weight: 600;
}
.tabs .tab a:hover,
.tabs .tab a.active {
    background-color: #6742a8;
    color: #fff !important;
}
.entry h5 {
    margin-top: 21px;
}
.app-title h4,
.site-title h1 {
    font-family: sans-serif;
    margin-top: 5px;
}


.main__container {
    width: 100%;
}

.item {
    width: 100%;
    box-shadow: 1px 1px 1px rgba(0,0,0,.1);
    padding: 10px;
}

@media(min-width: 800px) {
    .item {
        width: 49%;
    }
}

.panel-hide {
    display: none;
}

.red {
  background: red;
}

.green {
  background: green;
}

.yellow {
  background: yellow;
}
/*added css*/
.filters {
    overflow-x: scroll;
    display: block;
    flex-direction: row;
    width: 100%;
    justify-content: center;
    text-align: center;
}
.filter-btn {
    color: rgba(238,110,115,0.7);
    display: table-cell;
    width: auto;
    height: 100%;
    padding: 10px 10px;
    font-size: 13px;
    text-overflow: ellipsis;
    overflow: hidden;
    transition: color .28s ease;
    background-color: #d8d8d8;
    color: #000 !important;
    border-radius: 0.2rem;
    margin: 0 4px;
    line-height: 1.2;
    text-transform: capitalize;
}
.off{
    border: none;
}
.checked{
  font-style: italic;
  background-color:yellow;
}

.filter-button {
    color: rgba(238,110,115,0.7);
    display: table-cell;
    width: auto;
    height: 100%;
    padding: 10px 10px;
    font-size: 13px;
    text-overflow: ellipsis;
    overflow: hidden;
    transition: color .28s ease;
    background-color: #d8d8d8;
    color: #000;
    border-radius: 0.2rem;
    margin: 0 4px;
    line-height: 1.2;
    text-transform: capitalize;
    border: none;
    margin-bottom: 10px;
}
.filter-button.checked {
    background-color: #6742a8;
    color: #fff;
    font-style: inherit;
}


/*new_css_start*/
.app-section-ctm{
    padding-top:90px;
}
.filter-button{
    background: transparent;
}
.filter-button.checked{
    background-color:transparent;
    color: #6742a8;
    border-bottom: 4px solid #6742a8;
    border-radius: 0px;
}
.filter-button:focus{
    background: transparent;
    color: #6742a8;
}
.tabs .tab a{
    background: transparent;
}
.tabs .tab a.active{
    background-color: transparent;
    color: #6742a8 !important;
    border-bottom: 3px solid #6742a8;
}
.product-details .desc-review .tabs .indicator{
    background: transparent;
}
.price-new{
    float: right !important;
    text-align: center;
}
.price-new h4{
    margin-top: 0px !important;
    color:#6742a8;
    font-size: 20px;
}
table{
    border: 1px solid #ddd;
    margin-top:20px;
}
td, th{
    border-bottom: 1px solid #ddd;
}
td{
    padding-left: 15px;
}
th{
    padding-left: 15px;
    border-right: 1px solid #ddd;
}
.entry h5 {
    font-weight: bold;
}
.content a h6{
    color: #6742a8;
    font-weight: bold;
}
.new_dis{
    color: #a2a2a2;
}
.section-title-new{
    color: #6742a8;
    font-weight: bold;
    margin-top: 10px;
    padding-bottom: 5px;
}

.need{
    font-weight: bold;
}

.tabs .tab a{
    border-bottom: 3px solid #a2a2a2;
    color: #a2a2a2 !important;
    border-radius: 0px;
}
.tabs-new .tab a{
    color: #343434;
    font-size: 20px;
    line-height: 15px;
    font-weight: normal;

}
.review .post-review h6{
    color: #6742a8;
    font-weight: bold;
}
.login_footer{
    position: fixed;
    width: 100%;
    bottom: 0px;
}
.menu-list .entry {
    border-bottom: 1px solid #ddd;
}
.likedislikerate {
    margin-top: 10px;
    text-align: center;
}
.price_cate{
    width: 100%;
    display: block;
}
.price_cate h6{
    display: inline-block;
    width: 68%;
}
.price_cate h5{
    display: inline-block;
    float: right !important;
    margin-top: 0px;
    margin-right: 18px;
}
.categories-list-ctm .entry img{
    padding: 40px 0px;
}
.menu-list .categories_items_tab .entry{
    padding: 10px 0px;
    margin-bottom: 0px;
}
.categories_items_tab .tabs .tab a{
    text-overflow: inherit;
    width: 100%;
    border-radius: 0px;
    padding: 0px;
    border-bottom: 3px solid #a2a2a2;
    color: #a2a2a2 !important;
}
.categories_items_tab .tabs .tab a.active{
    color: #6742a8 !important;
    border-bottom: 3px solid #6742a8;

}
.categories_items_tab .tabs .tab{
    margin: 0px 5px;
}
.product-details-main .details {
    text-align: center;
}
.ms-profile-information th{
        color: #000;
}
.dtl_ctm_icon img{
    width: 20px;
    height: 20px;
    margin-top:35px;
    margin-right: 10px;
}
.dtl_ctm_icon .dtl_ctm_icon_2 {
    margin-right: 0px;
}

.login_btn_in_menu{
    /*padding: 0px 5px;
    position: fixed;
    bottom: 70px;
    width: 100%;*/

    padding: 0px 5px;
    position: fixed;
    bottom: 60px;
    width: 100%;
    background: #fff;
    padding-bottom: 10px;
}
.login_btn_in_menu .button {
    background: #6742a8;
    border: 0 transparent;
    padding: 8px 12px;
    border-radius: 2px;
    font-size: 12px;
    font-weight: 700;
    width: 49%;
}

.login_btn_in_menu .sign_btn {
    background: #916ece;
}

.main_color{
    color: #6742a8;
}
.thumbs_icon{
        color: #6742a8;
    font-size: 21px;
}
.thumbs_down_icon{
    color: red;
    font-size: 21px;
}
.thumbs_icon_big{
        color: #6742a8;
    font-size: 41px
}
.thumbs_down_big_icon{
    color: red;
    font-size: 41px;
}
.need_mb15{
    margin-bottom: 15px;
}
.logo_side_one{
    text-align: center;
}
.app-section-home{
    padding: 0px 0;
}
.ft-bottomf{
    color: #fff;
}
.side-nav-img .collapsible-header img{
    margin-top: 6px;
    vertical-align: top;
    margin-right: 5px;
}
.side-nav-img .side-nav-panel img{
    margin-top: 6px;
    vertical-align: top;
    margin-right: 5px;
}
.side-nav .collapsible-header, .side-nav.fixed .collapsible-header{
    padding: 0px 16px;
}
.side-nav-img .categories_icon img{
    margin-top: 0;
    vertical-align: middle;
    margin-right: 0;
}
/*new_css_end*/

/* Krina's START here */
.is-invalid{
    border: 1px solid red !important;
}
.is-valid{
    border: 1px solid green !important;
}
.alert{
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
/* Krina's END here */