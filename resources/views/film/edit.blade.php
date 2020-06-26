@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title is-2">Edit film <i class="fa fa-film" aria-hidden="true"></i></h1>
        </div>
    </section>
    <edit-film :current-film="{{ $film }}"></edit-film>
@endsection
