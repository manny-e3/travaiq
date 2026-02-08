<!DOCTYPE html>
<html lang="zxx" class="js">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">


    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}">
    <!-- Page Title  -->
    <title>Login | DashLite Admin Template</title>


    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dashlite.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('admin/assets/css/theme.css') }}">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-md">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light"
                                    data-target="athPromo"><em class="icon ni ni-info"></em></a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="html/index.html" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg"
                                            src="{{ asset('admin/images/logo.png') }}"
                                            srcset="{{ asset('admin/images/logo2x.png') }} 2x" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg"
                                            src="{{ asset('admin/images/logo-dark.png') }}"
                                            srcset="{{ asset('admin/images/logo-dark2x.png') }} 2x" alt="logo-dark">
                                    </a>
                                </div>

                                @yield('content')

                            </div>

                        </div><!-- .nk-split-content -->
                        <div class="nk-split-content nk-split-stretch bg-abstract"></div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
    <script src="{{ asset('admin/assets/js/bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>


</html>
