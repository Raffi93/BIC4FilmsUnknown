<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = Film::all()->load('actors');

        return view('film.index', compact('film'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('film.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $name = $request->input('name');
            $slug = Str::slug($name);
            $request->request->add(['slug' => $slug]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:App\Film,name',
                'slug' => 'unique:App\Film,slug',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(['message' => "Error: Validation Failed! " . $error], 200)
                    ->header('Content-Type', 'application/json');
            }

            $create = Film::create($request->validate([
                'name' => 'required',
                'description' => 'required'
            ]));

            $create->{"message"} = "Film successfully added!";

            return response($create, 200)
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            return response(['message' => "Error during adding Film!", 'error' => "Error: " . $e->getMessage()], 200)
                ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show(Film $film)
    {
        return view('film.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit(Film $film)
    {
        return view('film.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Film $film)
    {
        try {
            $name = $request->input('name');
            $slug = Str::slug($name);
            $request->request->add(['slug' => $slug]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:App\Film,name',
                'slug' => 'unique:App\Film,slug',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(['message' => "Error: Validation Failed! " . $error], 200)
                    ->header('Content-Type', 'application/json');
            }

            if ($film->update($request->validate([
                'name' => 'required',
                'description' => 'required'
            ]))) {

                return response(['message' => "Film successfully updated!"], 200)
                    ->header('Content-Type', 'application/json');
            }

            return response(['message' => "Error during update!"], 200)
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            return response(['message' => "Error during update!", 'error' => "Error: " . $e->getMessage()], 200)
                ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {
        try {
            if ($film->delete()) {
                return response(['message' => "Film deleted!"], 200)
                    ->header('Content-Type', 'application/json');
            }

            return response(['message' => "Error during delete!"], 200)
                ->header('Content-Type', 'application/json');
        }
        catch (\Exception $e) {
            return response(['message' => "Error during delete! Error: " . $e->getMessage()], 200)
                ->header('Content-Type', 'application/json');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Film::all()->load('actors');
    }

    /**
     * Display an item of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showfilmbyslug(Request $request)
    {
        $search = $request->validate([
            'search' => 'required'
        ])['search'];

        return Film::whereSlug($search)->get();
    }

    public function pageFilm()
    {
        return Film::with('actors')->paginate(5);
    }
}
