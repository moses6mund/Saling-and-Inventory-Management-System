<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pharmacy Store And Selling Management System</title>
    <link
    rel="shortcut icon"
    type="image/x-icon"
    href="assets/img/file.svg"
  />

    <!-- Bootstrap 4.5.3 CSS -->
    <link rel="stylesheet" href="assets/lib/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/lib/css/bootstrap.min.css">
    
    <!-- Custom CSS -->
    <style>
        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin-right: 20vh;
            height: 100%;
        }

        .modal.fade:not(.show).right .modal-dialog {
            transform: translate3d(25%, 0, 0);
        }

        .radio-item {
            margin-right: 15px;
        }

        .radio-item input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .radio-item label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            line-height: 25px;
        }

        .radio-item label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 2px;
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            background: #fff;
        }

        .radio-item input[type="radio"]:checked + label:after {
            content: '';
            position: absolute;
            left: 5px;
            top: 7px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #28a745;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.428571429;
        }
    </style>
  </head>
  
  <body>
    <div class="container-fluid">
        @yield('content')
    </div>

    <!-- Bootstrap 4.5.3 Required JavaScript -->
    <script src="assets/lib/js/jquery-3.5.1.min.js"></script>
    <script src="assets/lib/js/popper.min.js"></script>
    <script src="assets/lib/js/bootstrap.min.js"></script>
  </body>
  @yield('script')
</html>
