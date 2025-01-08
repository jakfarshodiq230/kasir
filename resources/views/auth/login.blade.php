<x-app-layout>
    <div class="container">
        <div class="body d-md-flex align-items-center justify-content-between" style="background:white;">
            <div class="box-1 mt-md-0 mt-5">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/kasir.png') }}" class="d-block w-100" alt="Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/kasir.png') }}" class="d-block w-100" alt="Image 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/kasir.png') }}" class="d-block w-100" alt="Image 3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-2 d-flex justify-content-center align-items-center h-100">
                <div class="mt-5 w-100" style="max-width: 400px;">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column">
                            <h3 class="text-center mb-2">Login <br> <b>{{ $toko->nama_toko}}</b></h3>

                            {{-- Display error for inactive user --}}
                            @if ($errors->has('status_user'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('status_user') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" class="form-control" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Enter password" autocomplete="current-password">
                                @if ($errors->has('password'))
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-block" id="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
