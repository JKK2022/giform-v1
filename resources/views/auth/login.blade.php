@extends('layouts.auth')

@section('container')
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>GIFORM</b></a>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('login') }}" class="mt-2">
                @csrf

                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid  @enderror" required name="email" value="{{ old('email')}}" autofocus autocomplete="email" placeholder="Adresse e-mail">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" @error('password') is-invalid @enderror required autocomplete="current-password" placeholder="Mot de passe">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Se connecter </button>
                    </div>
                </div>

            </form>
        
        </div>

    </div>
@endsection
