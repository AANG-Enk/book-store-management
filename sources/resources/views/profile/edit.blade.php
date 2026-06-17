@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.customer')

@section('title', 'Profil Saya - BookStore')
@section('page_title', 'Profil Saya')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold">Profil Saya</h1>
        <p class="text-secondary mb-0">
            Kelola informasi akun, password, dan penghapusan akun.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm border-danger">
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
