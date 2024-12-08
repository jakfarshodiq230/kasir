<x-app-layout>
    <div class="container">
        <div class="body d-md-flex align-items-center justify-content-between" style="background:white;">
            <div class="box-1 mt-md-0 mt-5">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/mata.png') }}" class="d-block w-100" alt="Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/mata.png') }}" class="d-block w-100" alt="Image 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/mata.png') }}" class="d-block w-100" alt="Image 3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-2 d-flex justify-content-center align-items-center h-100">
                <div class="mt-5 w-100" style="max-width: 400px;">
                    <form id="password-reset-form">
                        @csrf
                        <div class="d-flex flex-column">
                            <h3 class="text-center mb-2">Login <br> <b>Irene Optik</b></h3>
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            {{-- Display error for inactive user --}}
                            @if ($errors->has('status_user'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('status_user') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" class="form-control" name="email" placeholder="Enter email" value="{{ old('email', $request->email) }}">
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Enter password" autocomplete="new-password">
                                @if ($errors->has('password'))
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmasi</label>
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Enter password" autocomplete="new-password">
                                @if ($errors->has('password_confirmation'))
                                    <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                                @endif
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-block" id="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap's JS for the carousel -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#password-reset-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Clear any previous error messages
                $('.text-danger').remove();

                // Send the form data using AJAX
                $.ajax({
                    url: '{{ route('password.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Handle the response if password reset is successful
                        if (response.status === 'success') {
                            window.location.href = response.redirect; // Redirect to dashboard
                        }
                    },
                    error: function(xhr) {
                        // Handle errors if any, like validation errors
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            // Loop through errors and display them
                            $.each(errors, function(key, message) {
                                $('#' + key).after('<small class="text-danger">' + message + '</small>');
                            });
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
