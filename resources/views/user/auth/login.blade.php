<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/konrix/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 Jul 2024 08:36:18 GMT -->
<head>
    <meta charset="utf-8">
    <title>Login | Konrix - Responsive Tailwind Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <link href="{{ URL::to('knorix/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::to('knorix/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ URL::to('knorix/assets/js/config.js') }}"></script>



 
</head>

<body>

    <div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="h-screen w-screen flex justify-center items-center">

            <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
                <div class="card overflo
                w-hidden sm:rounded-md rounded-none">
                    <div class="p-6">
                        <a href="index.html" class="block mb-8">
                            <img class="h-6 block dark:hidden" src="../assets/images/logo-dark.png" alt="">
                            <img class="h-6 hidden dark:block" src="../assets/images/logo-light.png" alt="">
                        </a>

                        <div id="err_div" class="bg-danger/25 text-danger text-sm rounded-md p-4" role="alert">
                            <span id="error" class="font-bold"></span> The provided credentials do not match our records!
                        </div> 

                                               
                        <form class="valid-form" id="userForm" >
                            @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="validationDefault01">Email</label>
                            <input id="validationDefault01" class="form-input" name="email" type="email" placeholder="Enter your email" >
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="loggingPassword">Password</label>
                            <input id="loggingPassword" class="form-input" name="password" type="password" placeholder="Enter your password" >
                        </div>

                       

                        <div class="flex justify-center mb-6">
                            <button type="submit" class="btn w-full text-white bg-primary"> Log In </button>
                        </div>

                        </form>

                        <div class="flex items-center my-6">
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                            <div class="mx-4 text-secondary">Or</div>
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        </div>

                        <div class="flex gap-4 justify-center mb-6">
                            <a href="javascript:void(0)" class="btn border-light text-gray-400 dark:border-slate-700">
                                <span class="flex justify-center items-center gap-2">
                                    <i class="mgc_github_line text-info text-xl"></i>
                                    <span class="lg:block hidden">Github</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="btn border-light text-gray-400 dark:border-slate-700">
                                <span class="flex justify-center items-center gap-2">
                                    <i class="mgc_google_line text-danger text-xl"></i>
                                    <span class="lg:block hidden">Google</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="btn border-light text-gray-400 dark:border-slate-700">
                                <span class="flex justify-center items-center gap-2">
                                    <i class="mgc_facebook_line text-primary text-xl"></i>
                                    <span class="lg:block hidden">Facebook</span>
                                </span>
                            </a>
                        </div>

                            

                        <p class="text-gray-500 dark:text-gray-400 text-center">Don't have an account ?<a href="{{ route('customer.register') }}" class="text-primary ms-1"><b>Register</b></a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script>
    $(document).ready(function() {
            $('#err_div').hide();

            $('#userForm').on('submit', function(e) {
                e.preventDefault();
                
                // Clear previous errors
                                
                let formData = new FormData(this);
                // Checkbox value handling
                
                $.ajax({
                    url: "{{ route('customer.login.action') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {

                        window.location.href =
                            "{{ route('customer.shopping') }}";
                        }
                    },
                    error: function(xhr) {

            let errors = xhr.responseJSON.errors;

            if (xhr.responseJSON && xhr.responseJSON.login_error) {
                $('#err_div').show();
            }



            // Clear previous errors
            $('.error-text').remove();
            $('input, select, textarea').removeClass('border-red-500');

            // Loop through Laravel validation errors
            $.each(errors, function(field, messages) {
                let input = $('[name="'+field+'"]');

                // Add red border
                input.addClass('border-red-500');

                // Append error message
                input.after('<small class="error-text text-red-500">'+messages[0]+'</small>');
            });
        }
                });
            });
        });
</script>


<!-- Mirrored from coderthemes.com/konrix/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 Jul 2024 08:36:18 GMT -->
</html>