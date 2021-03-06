<!doctype html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <title>@yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    {{--<link href="{{asset('assets/frontend/css/paper-kit.css?v=2.2.0')}}" rel="stylesheet" />--}}

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/material-icons.css')}}" />

    <!-- Material Kit CSS -->
    <link href="{{asset('assets/css/material-dashboard.css?v=2.1.0')}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">



    {{--noty--}}
    <link rel="stylesheet" href="{{asset('assets/plugins/noty/noty.css')}}">
    <script src="{{asset('assets/plugins/noty/noty.min.js')}}"></script>



    @if (app()->getLocale() == 'ar')

    <!--  Material Dashboard CSS    -->
    {{-- <link href="{{asset('assets/css/rtl/material-dashboard.css')}}" rel="stylesheet" /> --}}

    <link href="{{asset('assets/css/rtl/bootstrap-rtl.min.css')}}" rel="stylesheet" />


    <!--  CSS for Demo Purpose, don't include it in your project     -->

    {{-- <style>
        html[dir="rtl"] .icon {
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
            filter: FlipH;
            -ms-filter: "FlipH";
        }

        .wrapper .boxContainer .fancyBox {
            text-align: left;
            padding-left: 10px;
            text-decoration: underline;
            color: #4A8CF7;
        }

        .wrapper .boxContainer .fancyBox {
            text-decoration: underline;
            color: #4A8CF7;
        }

        html[dir="ltr"] .wrapper .boxContainer .fancyBox {
            text-align: left;
            padding-left: 10px;
        }

        html[dir="rtl"] .wrapper .boxContainer .fancyBox {
            text-align: right;
            padding-right: 10px;
        }

        html[dir="rtl"] .sidebar {
            text-align: right;
            padding: 0 0 0 10px;
        }

        .content {
            text-align: left;
        }

        html[dir="rtl"] .content {
            text-align: right;
        }

        .content {
            text-align: start;
        }

        .content {
            padding-left: 12px;
            margin-right: 20px;
        }

        html[dir="rtl"] .content body {
            padding-left: 0;
            padding-right: 12px;
            margin-left: 20px;
            margin-right: 0px;
            padding-inline-start: 12px;
            margin-inline-end: 20px;
        }

        .sidebar .nav li a,
        .sidebar .nav li .dropdown-menu a {
            padding: 5px 10px;
        }

        .sidebar .nav li>a,
        .off-canvas-sidebar .nav li>a {
            margin: 5px 10px;
        }

        .sidebar .nav,
        .off-canvas-sidebar .nav {
            margin-top: 5px !impotant;
        }

        .content {
            text-align: left;
        }

        html[dir="rtl"] .content {
            text-align: right;
            padding-left: 0;
            padding-right: 12px;
            margin-left: 20px;
            margin-right: 0px;
            padding-inline-start: 12px;
            margin-inline-end: 20px;
        }
    </style> --}}
    @endif
    <style>
        select {
            background-color: #202940 !important;
        }

        textarea {
            margin-bottom: 15px !important;
            position: relative !important;
        }

        .nicEdit-pane {
            position: fixed;
            top: 1px;
        }
    </style>
    @stack('style')
</head>

<body class="dark-edition">
    <div class="loader" style="position: fixed; top: 0; left: 0; background: #8b92a9; z-index: 9999; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center">
        <img src="{{ asset('uploads/load/Spinner.gif') }}" alt="loading..." srcset="">
    </div>
    
    <script>
        window.addEventListener("load", function(){
        const loader = document.querySelector(".loader");
        loader.className += " hidden";
        console.log('rrrrrrrrrrrr');
    })
    </script>
    <audio id="audioNotifyNew">
        <source src="{{asset('audio/amr.mp3')}}" type="audio/ogg">
        <source src="{{asset('audio/amr.mp3')}}" type="audio/mpeg">
    </audio>

    <audio id="audioNotifyAlert">
        <source src="{{asset('audio/elissa.mp3')}}" type="audio/ogg">
        <source src="{{asset('audio/elissa.mp3')}}" type="audio/mpeg">
    </audio>

    <div class="wrapper ">
        @include('back-end.layout.side-bar')
        <div class="main-panel" style="background-color: #202940; @if (app()->getLocale() == 'ar') float:left; @endif">
            <!-- Navbar -->

            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                    @include('partials._session')
                </div>
            </div>
            @include('back-end.layout.footer')
        </div>
    </div>
  
    <!--   Core JS Files   -->
    {{--Jquery--}}
    <script src="{{asset('assets/js/core/jquery.min.js')}}"></script>

    {{-- start dataTable plugin --}}
    <link href="{{asset('css/table_css/bootstrap.min.css')}}" rel="stylesheet" />

    <script src="{{asset('js/table_js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/table_js/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <link href="{{asset('css/table_css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />

    {{-- end dataTable plugin --}}


    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap-material-design.min.js')}}"></script>
    <script src="{{asset('assets/js/default-passive-events.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="{{asset('assets/js/buttons.js')}}"></script>

    <!-- Chartist JS -->
    <script src="{{asset('assets/js/plugins/chartist.min.js')}}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>

    {{-- this is for scrollbar that destroy design if local = ar --}}
    {{-- <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script> --}}
    <script src="{{asset('assets/js/plugins/jquery.nicescroll.js')}}"></script>
    {{-- <script>
        $("#selector").niceScroll({
            cursorcolor : 'red',
            cursorwidth : '40px',
        });
    </script> --}}

    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('assets/js/material-dashboard.js?v=2.1.0')}}"></script>

    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{asset('assets/demo/demo.js')}}"></script>



    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>

    <script src="{{asset('assets/frontend/js/paper-kit.js?v=2.2.0')}}" type="text/javascript"></script>

    <script>
        $(function () {
            $("[data-toggle=popover]").popover();
        });
        $(document).ready(function() {

            // start add order details from admin panel
            var i = 0,
                arrId = ["0"];
          
            $('#addButton').click(function(){

                productid    = $('#productId').val();

                if(jQuery.inArray(productid, arrId) !== -1){
                    console.log('id find in arrray is ' + productid);
                }else{
                    arrId.push(productid);
                    
                    var orderid   = $('#order_id').val(),
                    productName  = $('#productId').find(':selected').data('proname'),
                    productPrice = $('#productId').find(':selected').data('proprice'),
                    amount       = $('#amount').val(),
                    trContent= `<tr>
                                    <td> ${++i}         <input type='hidden'  name='product_id[]' value='${productid}'></td>
                                    <td> ${productName} </td>
                                    <td> ${amount}      <input type='hidden' name='amount[]' value='${amount}'></td>
                                    <td> ${amount * productPrice}   <input type='hidden' name='price[]' value='${amount * productPrice}'></td>
                                    <td><button class='removeRow btn btn-danger' data-proid='${productid}'>R</button></td>
                                </tr>`;
                    $('#orderTable tbody').append(trContent);
                 }
            });
            $('form').on('click', '.removeRow', function(e){
                e.preventDefault();
                var xx = $(this).data('proid');
                
                arrId = jQuery.grep(arrId, function(value) {                    
                    return value != xx;
                });
                $(this).closest('tr').remove();
            })
            // end add order details from admin panel

            $("#dataTable").DataTable();
            $().ready(function() {
                $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });

                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });

        // delete Noty
        $('.delete').click(function (e) {

            var that = $(this)

            e.preventDefault();

            var n = new Noty({
                text: "@lang('site.confirm_delete')",
                type: "warning",
                killer: true,
                buttons: [
                    Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                        that.closest('form').submit();
                    }),

                    Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
                        n.close();
                    })
                ]
            });

            n.show();

        });//end of delete noty

        //image preview
        $('.image').change(function () {

            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.img-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        // delete Noty
        $('.delete').click(function (e) {

            var that = $(this)

            e.preventDefault();

            var n = new Noty({
                text: "<?php echo app('translator')->get('site.confirmation'); ?>",
                // text: "<?php echo app('translator')->get('site.confirm_delete'); ?>",
                type: "warning",
                killer: true,
                buttons: [
                    Noty.button("<?php echo app('translator')->get('site.yes'); ?>", 'btn btn-success mr-2', function () {
                        that.closest('form').submit();
                    }),

                    Noty.button("<?php echo app('translator')->get('site.no'); ?>", 'btn btn-primary mr-2', function () {
                        n.close();
                    })
                ]
            });

            n.show();

        });//end of delete

    </script>

    <style>
        /* img{
            transition: all 2.5s ease-in-out;
        }
        img:hover {
            transform: scale(4.5);
            z-index: 5;
            position: fixed;
            top: 150px;
            left: 150px; */
        border-radius: 20% 0;
        }

        .navbar-wrapper .navbar-brand {
            font-size: 30px;
        }

        h4 {
            padding-left: 100px;
            font-size: 30px;
        }

        .form-inline {
            display: block;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .dataTables_length {
            display: none;
        }


        div.dataTables_wrapper div.dataTables_filter input {
            width: 100%;
            margin: 20px;
        }

        .btn.btn-lg,
        .btn-group-lg>.btn,
        .btn-group-lg .btn {
            font-size: 1.875rem;
        }

        .btn.btn-sm,
        .btn-group-sm>.btn,
        .btn-group-sm .btn {
            font-size: 1.1rem;
        }
    </style>
    <script>
      
        $('table, p, th').css('font-size', '18px');
    $('label').css('font-size', '15px');
    $(".invalid-feedback").css({'display':'block', 'font-size': '13px'});
    $(".dataTables_paginate ").css('font-size', '11px');
    $("input, select, textarea").css({
        'font-size' : '20px',
        'padding' : '5px',
        'height': '40px',
        'background': 'center',
    });
   
    </script>

    {{-- more edit in ar local becouse package matrial have more than error  --}}
    @if (app()->getLocale() == 'ar')
    <script>
        $('.sidebar .nav-link').each( function () { 
         $(this).children().css('display', 'flex');
    });   
    

    $('label').each(function(){
        $(this).css({
            'display': 'flex',
            'position': 'relative',
            'right': '14px',
            'padding-bottom': '5px',
        });
    }) 
    
    $('.col-md-8').each(function(){
        $(this).css('display', 'contents');
    })
    
    $('.card-header .col-md-8').each(function(){
        $(this).children().css('display', 'flex');
    })
    
    $('.col-md-8 .card-header').each(function(){
        $(this).children().css('display', 'flex');
    })

    $('table tbody, table tfoot').each(function(){
        $(this).css('text-align','center')
    })  
    
    $('table thead th, table tfoot th').each(function(){
        $(this).css('text-align','center')
    }) 
    
    $('.navbar-brand').each(function(){
        $(this).css({'font-size':'35px', 'padding':'20px'})
    })
      
    </script>
    @endif
    {{-- -------------------------   pusher plugin -------------------------- --}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('af2b4f6752717c614a6a', {
  cluster: 'eu'
});




// ------------#############  [1] this notifcation for admin to know there is an order maked and android take api from it to send a noty for active delivery ##################-------------
var channel = pusher.subscribe('my-channel-order');
channel.bind('my-event-order', function(data) {
    document.getElementById('audioNotifyNew').play();
    var name     = data.userOrder['firstName'],
        id = data.orderId;

    // console.log(data);
       
    var order = new Noty({
            text: "هناك طلب ما من العميل " + name,
            type: "warning",
            layout: 'bottomRight',
            killer: true,
            timeout: 60000,
            buttons: [
                Noty.button( `<a href="https://awfrlk.net/public/admin/order/pending?process=1&&orderId=${id}"> @lang("site.details") </a>`, 'btn btn-success mr-2', function () {
                    // that.window.location = "";  
                    that.closest('form').submit();
                    document.getElementById('audioNotifyNew').pause();
                }),

                Noty.button("@lang('site.hide')", 'btn btn-primary mr-2', function () {
                    console.log("id is -----" + id);
                    order.close();
                    document.getElementById('audioNotifyNew').pause();
                })
            ]
        });
        order.show()

});


// ------------ ############# [2] this notifcation for client to know his order has been accepted ##################-------------    
var channel = pusher.subscribe('channel-orderClient-acc');
channel.bind('event-orderClient-acc', function(data) {
    console.log('delivery has take this order');

});


// ------------ ############# [3] this notifcation for client to know his order has been finished and delivery is comming soon ##################-------------    
var channel = pusher.subscribe('channel-delEndShop');
channel.bind('event-delEndShop', function(data) {
    console.log('delivery has end shopping ');
    // alert(JSON.stringify(data));
}); 


// ------------ ############# [4] this notifcation from client to delivery and admin to tell him his order is late ##################-------------    
var channel = pusher.subscribe('channel-userUrgOrder');
channel.bind('event-userUrgOrder', function(data) {
    document.getElementById('audioNotifyAlert').play();
    console.log('user urgancy this order ' + data);
    var id = data.order_id;
    var order = new Noty({
            text: "هناك تأخير في الطلب برجاءء المتابعه " ,
            type: "alert",
            layout: 'topRight',
            killer: true,
            timeout: 60000,
            buttons: [
                Noty.button( `<a href="https://awfrlk.net/public/admin/order/pending?delivery=1&orderId=${id}"> @lang("site.details") </a>`, 'btn btn-success mr-2', function () {
                // Noty.button("<a href=' {{ route("pending.store", ["orderId" =>"last"] )}} '> @lang('site.details') </a>", 'btn btn-success mr-2', function () {
                    // that.window.location = "";  
                    that.closest('form').submit();
                    document.getElementById('audioNotifyAlert').pause();
                }),

                Noty.button("@lang('site.hide')", 'btn btn-primary mr-2', function () {
                    order.close();
                    document.getElementById('audioNotifyAlert').pause();
                })
            ]
        });
        order.show()

});


// ------------ ############# [5] this notifcation from delivery to tell me he arrival to client home  ##################-------------    
var channel = pusher.subscribe('channel-delArrivalOrder');
channel.bind('event-delArrivalOrder', function(data) {
    console.log('delivery has arrival to home');
    // alert(JSON.stringify(data));
});


 // ------------ ############# [6] this notifcation from  user tell delivery that he take order   ##################-------------    
var channel = pusher.subscribe('channel-userFeedOrder');
channel.bind('event-userFeedOrder', function(data) {
    console.log('user receving order suecc');
    // alert(JSON.stringify(data));
});  

 // ------------ ############# [7] this notifcation from  admin to fprce delivery take this order  ##################-------------    
var channel = pusher.subscribe('channel-adminForceDelivey');
channel.bind('event-adminForceDelivey', function(data) {
    console.log('admin forcing delivery to take this order ');
    // alert(JSON.stringify(data));
});  



 // ------------ ############# [8] this notifcation from  user to all delivery to tell him an user subscribe offer so delivery have to earn money  ##################-------------    
var channel = pusher.subscribe('my-channel-offer');
channel.bind('my-event-offer', function(data) {
    console.log('user subscribe for an offer delivery have to collect money ');
    // alert(JSON.stringify(data));
});  


// ------------ ############# [8] this notifcation from delivery to user that this delivery take offer and have to collect money ##################-------------    
var channel = pusher.subscribe('my-channel-DTakeOffer');
channel.bind('my-event-DTakeOffer', function(data) {
    console.log('delivery take this offer to collect money from it ');
    // alert(JSON.stringify(data));
});  

    </script>

</body>

</html>