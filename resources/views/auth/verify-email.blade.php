<x-app-layout>
    <div class="container">
        <div class="body d-md-flex align-items-center justify-content-between" style="background:white;">
            <div class="box-1 mt-md-0 mt-5">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/mata.png')}}" class="d-block w-100" alt="Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/mata.png')}}" class="d-block w-100" alt="Image 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/mata.png')}}" class="d-block w-100" alt="Image 3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-2 d-flex justify-content-center align-items-center h-100">
                <div class="mt-5 w-100" style="max-width: 400px;">
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif
                    <form action="{{ route('verification.send')}}" method="POST">
                        @csrf
                        <div class="d-flex flex-column">
                            <h3 class="text-center mb-2">Verifikasi Email <br> <b>Irene Optik</b></h3>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-block" id="submit">Verifikasi</button>
                                {{-- <div class="text-center mt-0">
                                    <a href="http://goldvisioning.com/" target="_blank" class="mb-4">www.IreneOptik.com</a>
                                </div> --}}
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
