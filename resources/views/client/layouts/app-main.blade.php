<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> {{$system->name}} </title>
    <meta name="_token" content="{{csrf_token()}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/treeview-rtl.css')}}">

    @include('client.layouts.common.css_links')

    <style type="text/css" media="print">
        @media print {
            .app-content, .content {
                margin-right: 0 !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                -moz-print-color-adjust: exact;
                print-color-adjust: exact;
                -o-print-color-adjust: exact;
            }

            .no-print, .main-news {
                display: none !important;
            }

            .printy {
                display: block !important;
            }

            table thead tr th, table tbody tr td {
                color: rgba(0, 0, 0, 0.27);
                /*border: 1px solid rgba(0, 0, 0, 0.26) !important;*/
            }

            .alert, .alert-sm, .alert-info, .alert-primary {
                color: #3e4045 !important;
            }
        }
    </style>
    <style>
        .dotsBTN {
            height: 31px !important;
            padding-top: 6px !important;
            border-radius: 88% !important;
        }

        table {
            border-radius: 10px !important;
            overflow-x: hidden;
        }

        @media screen and (max-width: 666px) {
            table {
                overflow-x: auto !important;
            }
        }

        .tx-20 {
            font-size: 20px !important;
        }

        .tx-18 {
            font-size: 18px !important;
        }

        .tx-16 {
            font-size: 16px !important;
        }

        .img-icon {
            width: 15px;
            height: 15px;
            margin-left: 10px;
        }

        @font-face {
            font-family: 'Cairo';
            src: url("{{asset('fonts/Cairo.ttf')}}");
        }

        label {
            font-size: 13px !important;
        }

        table {
            font-size: 13px !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cairo' !important;
        }

        .dropdown-menu.dropdown-menu-right.show {
            width: 240px !important;
        }

        body, html {
            font-family: 'Cairo';
        }

        * {
            font-size: 13px !important;
        }

        .navigation.navigation-main {
            padding-bottom: 50px !important;
        }

        .alarm-upgrade {
            font-family: 'Cairo' !important;
            font-size: 14px;
            padding-top: 10px;
        }

        table thead tr th, table tbody tr td {
            color: #000;
            /*border: 1px solid #c0c0c0 !important;*/
            text-align: center;
        }

        .alert, .alert-sm, .alert-info, .alert-primary {
            color: #3e4045 !important;
        }

        .main-news {
            padding: 3px !important;
            background: #222751 !important;
            color: white !important;
        }

        .main-news p {
            margin-top: 19px !important;
        }


        /* The animation code */
        @keyframes example {
            from {
                margin-right: 1000px;
            }
            to {
                margin-right: -980px;
            }
        }

        /* The element to apply the animation to */
        .main-news p {
            width: 100%;
            animation-name: example;
            animation-duration: 40s;
            animation-iteration-count: infinite;
        }

        .border-secondary {
            border-color: rgba(227, 229, 234, 0.6) !important;
        }

        h3 {
            font-size: 17px !important;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('client.layouts.common.header')

@include('client.layouts.common.ul_sidebar')
<div class="app-content content">
    <div class="main-news d-sm-block d-none no-print">
        <p class="no-print">
            {{__('main.wel-msg')}}
        </p>
    </div>
    <div class="content-wrapper">

        <div class="content-header row">

        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>
@include('client.layouts.common.footer')

@include('client.layouts.common.js_links')
<!-----sweetalert------>
<script src="{{asset('/')}}../js/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="modal" id="modaldemo">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content modal-content-demo">
            <div class="modal-header text-center">
                <h6 class="modal-title w-100" style="font-family: 'Cairo'; "> سياسة الخصوصية </h6>
                <button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center" dir="rtl">
                <ul dir="rtl">
                    <li> قد يتم استخدام بياناتك لضمان حفظ الجودة</li>
                    <li> لا يتم مشاركة بيانات مع افراد اخرين</li>
                    <li> قد يتم استعمال بياناتك من أجل التواصل معك او لحل مشاكل</li>
                    <li> مع ملاحظة ان أمن بياناتك هى من اهم اولوياتنا</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-----sweetalert------>
<script src="{{asset('js/treeview.js')}}"></script>

<script>
    $(document).ready(function () {
        //check if there are products out of stock...
        $.post("{{ route('getNumProductsOutOfStock') }}", {
            "_token": "{{ csrf_token() }}"
        }, function (data) {
            if (data >= 1) {
                $("#numOfProductsEnded").text(data);
                $("#numOfProductsEnded").show();
            }
        });

        //set products that are out of stock ===> ok i viewed it...
        $("#setProducts_viewed").click(function () {
            $.post("{{ route('setProductsOutOfStockViewed') }}", {
                "_token": "{{ csrf_token() }}"
            });
        });

        $("#toggleadding-shortcuts-ul").click(function () {
            $(".adding-shortcuts-ul").slideToggle(300);
        });

    });
</script>
</body>
</html>
