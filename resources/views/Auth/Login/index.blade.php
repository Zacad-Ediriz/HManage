<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('') }}/backend/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>KFG</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('') }}/backend/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/css/rtl/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('') }}/backend/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet"
        href="{{ asset('') }}/backend/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('') }}/backend/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{ asset('') }}/backend/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('') }}/backend/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('') }}/backend/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">

                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-2">
                                {{-- <span class="app-brand-logo demo">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                            fill="#7367F0" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                            fill="#7367F0" />
                    </svg> --}}
                                </span>
                                <span class="app-brand-text demo text-body fw-bold ms-1">KFG</span>
                            </a>
                        </div>
                        <h4 class="mb-1 pt-2">Welcome 👋</h4>
                        <p class="mb-4"> </p>



                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="email" placeholder="Email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="remember"> {{ __('messages.remember_me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    Sing in
                                </button>
                            </div>
                        </form>


                        <div class="divider my-4">
                            <div class="divider-text"></div>
                        </div>

                        <div class="d-flex justify-content-center">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('') }}/backend/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('') }}/backend/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/node-waves/node-waves.js"></script>

    <script src="{{ asset('') }}/backend/vendor/libs/hammer/hammer.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/i18n/i18n.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="{{ asset('') }}/backend/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('') }}/backend/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="{{ asset('') }}/backend/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('') }}/backend/js/main.js"></script>

    <!-- Page JS -->
    {{-- <script src="{{ asset('') }}/backend/js/pages-auth.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend/js/axios.min.js') }}"></script>
    <script>
        let login_url = '{{ route('login') }}'
    </script>

    {{-- @vite('resources/js/auth/login.js') --}}

    <script>
        $(function() {
            $("#formAuthentication").on("submit", async function(e) {
                // alert("hi there")
                e.preventDefault();
                let res;
                try {
                    res = await axios.post("{{ route('login') }}", {
                        email: $(`input[name='email']`).val(),
                        password: $(`input[name='password']`).val()
                    })
                    if (res.status == 200) {
                        $(".errors").html("")
                        $(".input").removeClass("is-invalid").addClass("is-valid")
                        location.replace("{{ url('') }}/dashboard")
                    }
                } catch (error) {
                    if (error.response) {
                        $(".errors").html("")
                        $(".input").removeClass("is-invalid").addClass("is-valid")
                        if (error.response.status == 422) {
                            $.each(error.response.data.errors, function(k, v) {
                                if ($(`input[name='${k}']`).length > 0) {
                                    $(`#${k}_error`).html(v[0])
                                    $(`input[name='${k}']`).addClass("is-invalid")
                                }
                            })
                        }
                        if (error.response.status == 401) {
                            Swal.fire({
                                text: error.response.data,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        }
                        return false;
                    }


                    Swal.fire({
                        text: "Something went wrong!!!",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });

                }
            })
        })
    </script>
</body>

</html>