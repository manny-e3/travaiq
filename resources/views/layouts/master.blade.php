<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/fmdq_favicon.png') }}">
    <title>PentSpace</title>
    <link href="{{ asset('admin/assets/css/dashlite.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/libs/fontawesome-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/libs/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">

        <div class="nk-main ">
            @include('layouts.sidebar')
            @include('layouts.header')


            @yield('content')

            @include('layouts.footer')



            <script src="{{ asset('admin/assets/js/bundle.js') }}"></script>
            <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
            <script src="{{ asset('admin/assets/js/charts/chart-ecommerce.js') }}"></script>
            <script src="{{ asset('admin/assets/js/libs/datatable-btns.js') }}"></script>
               
            <script src=" {{ asset('admin/assets/js/charts/gd-analytics.js') }}"></script>
            <script src=" {{ asset('admin/assets/js/libs/jqvmap.js') }}"></script>




            <link rel="stylesheet" href="{{ asset('admin/assets/css/editors/summernote.css') }}">
            <script src="{{ asset('admin/assets/js/libs/editors/summernote.js') }}"></script>
            <script src="{{ asset('admin/assets/js/editors.js') }}"></script>


            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>


            <script>
                function loading() {
                    $(".btn .fa-spinner").show();
                    $(".btn .btn-text").html("Processing...");
                }

                document.getElementById('subcategoryForm').addEventListener('submit', function(event) {
                    if (this.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        loading();
                        document.getElementById('submitBtn').disabled = true;
                    }
                    this.classList.add('was-validated');
                }, false);
            </script>





<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if ($errors->any())
            let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessages,
                confirmButtonColor: '#3085d6',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#28a745',
            });
        @endif
    });
</script>

</body>

</html>
