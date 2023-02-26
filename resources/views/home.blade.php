@extends('layouts.master')

@section('contenu')
    <div class="row">
        <div class="col col-12 p-4">
            <div class="jumbotron">
                <h1 class="display-3">Bienvenu, <strong>{{ userFullName() }}</strong></h1>
                <p class="lead">
                    This is a simple hero unit, a simple jumbotron style component for calling
                    extra attention to featured content or information.
                </p>
                <hr class="my-4">
                <p>
                    It uses utility classes for topography and spacing to space content out within the larger container
                </p>
                <p class="lead">
                    <a href="" class="btn btn-primary btn-lg" role="button">Learn more</a>
                </p>
            </div>
        </div>
    </div>
@endsection
