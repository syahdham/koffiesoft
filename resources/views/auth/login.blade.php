@extends('layouts.auth')

@section('content')
    <div class="contents order-2 order-md-1">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <div class="mb-4">
                        <h3>Sign In</h3>
                        <p class="mb-4">Sign in to continue access.</p>
                    </div>
                    <div class="form-group mb-1">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="d-flex mb-5 align-items-center justify-content-end">
                        <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                    </div>

                    <input type="button" value="Sign In" class="btn btn-primary login-user">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('register') }}">Don't have an account?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('vendors/sweetalert/sweetalert.js') }}"></script>

    <script>
        $('.login-user').on('click', function () {

            let email = $('#email').val();
            let password = $('#password').val();
            let button = $('.login-user').prop('disabled', true);

            if(email == '' || password == '') {
                sweetAlert('error', 'Error', 'All field are required');
                button.prop('disabled', false);
                return;
            }

            let formData = {
                email,
                password,
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('login') }}",
                data: formData,
                type: 'POST',
                success: function (resp) {
                    let data = JSON.parse(resp);

                    if (data[0]) {
                        location.href = "/";
                        return;
                    }

                    sweetAlert('error', 'Error', data[1]);
                    button.prop('disabled', false);
                },
                error: function (resp) {
                    sweetAlert('error', 'Error', resp.responseJSON.message);
                    button.prop('disabled', false);
                },
            });
        });

        function sweetAlert(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonColor: '#007bff',
                confirmButtonText: 'Oke',
            });
        }
    </script>
@endpush
