@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title is-2">List film <i class="fa fa-film" aria-hidden="true"></i></h1>
        </div>
    </section>
    <div class="container">
        <input type="checkbox" class="hackbox liste" id="liste_anzeigen">
        <label class="liste" for="liste_anzeigen"></label>
        <span class ="test2">
        <list-film :current-list="{{ $film }}" v-bind:enable-edit="true" v-bind:enable-show="true"></list-film>
        </span>
        <span class ="test">
         <page-film class ="test" v-bind:enable-edit="true" v-bind:enable-show="true" ></page-film>
        </span>
    </div>
@endsection
