@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title is-2">List film <i class="fa fa-film" aria-hidden="true"></i></h1>
        </div>
    </section>
    <list-film v-bind:enable-edit="true" v-bind:enable-show="true"></list-film>
@endsection
