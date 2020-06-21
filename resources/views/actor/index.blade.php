@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title is-2">List actors <i class="fa fa-users" aria-hidden="true"></i></h1>
        </div>
    </section>
    <div class="container">
        <input type="checkbox" class="hackbox liste" id="liste_anzeigen">
        <label class="liste" for="liste_anzeigen"></label>
        <span class ="test">
        <list-actor class ="test" v-bind:enable-edit="true" v-bind:enable-show="true" ></list-actor>
        </span>
        <span class ="test2">
        <page-actor class ="test" v-bind:enable-edit="true" v-bind:enable-show="true" ></page-actor>
        </span>
    </div>
@endsection
