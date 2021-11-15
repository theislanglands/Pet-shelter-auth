<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdoptionController extends Controller
{
    public function create()
    {
        // Guests should be redirected to the login page.
        if (auth()->guest()) {
            return redirect(route('login'));
        }
        return view('adoptions.create');
    }

    public function store(Request $request)
    {
        // validate input
        $validated = $request->validate([
            'name'        => ['required'],
            'description' => ['required'],
            'image'       => ['file', 'image']
        ]);

        // create new adoption
        $adoption = new Adoption();

        // checks if image has been supplied, otherviee use standart
        if ($request->has('image'))
        {
            $filename = Str::random(32) . "." . $request->file('image')->extension();
            $request->file('image')->move('imgs/uploads', $filename);
            $adoption->image_path = "imgs/uploads/$filename";
        }
        else
            $adoption->image_path = "imgs/demo/4.jpg";

        $adoption->name        = $validated['name'];
        $adoption->description = $validated['description'];

        // associate user with listing
        $adoption->listed_by   = auth()->id();
        $adoption->save();

        // success message
        session()->put("success", "Post for ".$adoption->name." created successfully");

        return redirect(route('home'));
    }

    public function show(Adoption $adoption)
    {
        return view('adoptions.details', ['adoption' => $adoption]);
    }

    public function adopt(Adoption $adoption)
    {
        
        if (request()->user()->id == $adoption->listed_by) {
            abort(403, "you cannot adopt your own pet");
        }

        $adoption->adopted_by = auth()->user()->id;
        $adoption->save();
        /*
        |-----------------------------------------------------------------------
        | Task 5 User, step 6. You should assing $adoption
        | The $adoption variable should be assigned to the logged user.
        | This is done using the adopted_by field from the user column in the database.
        |-----------------------------------------------------------------------

        in charge off
        - assign the current adoption model to the logged user - The system registers the new adoption
        - The Adoption column in the database has a field called `adopted_by`, which references the id of the User that adopted that pet.
        */

        return redirect()->home()->with('success', "Pet $adoption->name adopted successfully");
    }


    public function mine()
    {

        $adoptions = Adoption::all()->where('adopted_by', "=", auth()->user()->id);

        return view('adoptions.list', ['adoptions' => $adoptions, 'header' => 'My Adoptions']);
    }
}
