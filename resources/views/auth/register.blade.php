@extends('layouts.auth')

@section('content')
    <div class="contents order-2 order-md-1">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <div class="mb-4">
                        <h3>Sign Up</h3>
                        <p class="mb-4">Sign up to create your account.</p>
                    </div>
                    <div class="form-group mb-1">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>

                    <div class="form-group mb-1">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group mb-1">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password-confirm">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm"
                               required autocomplete="new-password">
                    </div>

                    <input type="button" value="Sign Up" class="btn btn-primary register-user">
                    <div class="d-flex justify-content-end">
                        <span><a href="{{ route('login') }}">Already have an account?</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendors/sweetalert/sweetalert.js') }}"></script>

    <script>
        $('.register-user').on('click', function () {

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let confirmPass = $('#password-confirm').val();
            let button = $('.register-user').prop('disabled', true);

            if(name == '' || email == '' || password == '' || confirmPass == '') {
                sweetAlert('error', 'Error', 'All field are required');
                button.prop('disabled', false);
                return;
            }

            if (password !== confirmPass) {
                sweetAlert('error', 'Error', 'Password confirmation doesn\'t match');
                button.prop('disabled', false);
                return;
            }

            let formData = {
                name,
                email,
                password,
                password_confirmation: confirmPass,
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register') }}",
                data: formData,
                type: 'POST',
                success: async function (resp) {
                    let data = JSON.parse(resp);

                    if (data[0]) {
                        sweetAlert('success', 'Success', data[1]);

                        await sleep(2000);

                        location.href = "/login";
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

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    </script>
@endpush
