<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActorController extends Controller
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
        $actor = Actor::all()->load('film');

        return view('actor.index', compact('actor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('actor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $slug = Str::slug($name);
        $request->request->add(['slug' => $slug]);

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:App\Actor,name',
                'description' => 'required',
                'slug' => 'unique:App\Actor,slug',
                'film_id' => 'required|exists:App\Film,id'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return  response(['message' => "Error: Validation Failed! " . $error], 200)
                    ->header('Content-Type', 'application/json');
            }

            $create = Actor::create($request->validate([
                'name' => 'required',
                'description' => 'required',
                'film_id' => 'required|exists:App\Film,id'
            ]));

            $create->{"message"} = "Actor successfully added!";

            return response($create, 200)
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            return response(['message' => "Error during adding Actor!", 'error' => "Error: " . $e->getMessage()], 200)
                ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        $actor = $actor->load('film');

        return view('actor.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        return view('actor.edit', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Actor $actor)
    {
        try {

            $name = $request->input('name');
            $slug = Str::slug($name);
            $request->request->add(['slug' => $slug]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:App\Actor,name',
                'description' => 'required',
                'slug' => 'unique:App\Actor,slug',
                'film_id' => 'required|exists:App\Film,id'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(['message' => "Error: Validation Failed! " . $error], 200)
                    ->header('Content-Type', 'application/json');
            }

            if ($actor->update($request->validate([
                'name' => 'required',
                'description' => 'required',
                'film_id' => 'required|exists:App\Film,id'
            ]))) {
                return response(['message' => "Actor successfully updated!"], 200)
                    ->header('Content-Type', 'application/json');
            }

            return response(['message' => "Error during update!"], 200)
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            return response(['message' => "Error during delete!", 'error' => "Error: " . $e->getMessage()], 200)
                ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actor $actor)
    {
        try {
            if ($actor->delete()) {
                return response(['message' => "Actor deleted!"], 200)
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
     * Show form for searching.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return view('actor.search');
    }


    /**
     * Return search result.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {
        $search = $request->validate([
            'q' => 'required'
        ])['q'];

        return Actor::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhereHas('film', function ($q) use ($search){
                $q  ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->with('film')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Actor::all()->load('film');
    }

    /**
     * Display an item of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showactorbyslug(Request $request)
    {
        $search = $request->validate([
            'search' => 'required'
        ])['search'];

        return Actor::whereSlug($search)->with('film')->get();
    }

    public function pageActor()
    {
        return Actor::with('film')->paginate(5);
    }
}
