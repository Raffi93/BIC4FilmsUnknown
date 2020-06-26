@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title is-2">Show actor <i class="fa fa-user" aria-hidden="true"></i></h1>
        </div>
    </section>
    <show-actor :current-actor="{{ $actor }}"></show-actor>
@endsection
