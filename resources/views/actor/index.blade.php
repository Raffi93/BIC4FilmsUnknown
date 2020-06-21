@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title is-2">List actors <i class="fa fa-users" aria-hidden="true"></i></h1>
        </div>
    </section>
    <list-actor class ="test" v-bind:enable-edit="true" v-bind:enable-show="true" ></list-actor>
@endsection
