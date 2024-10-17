<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //to get all listings
    public function index(){
        //dd(request());
        //request(tag) will give you the tag which user clicked. If user clicked on laravel,he wants all posts which have tags of laravel to be filtered and populated on the screen.
        return view ('listings.index',[
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);

    }
    //to get single listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing

        ]);

    }
   //show create form
    public function create(){
        return view('listings.create');
    }

    //store listing data
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required'

        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }
        $formFields['user_id']= auth()->id();


        Listing::create($formFields);
        return redirect('/')->with('message','Listing created successfully!');



    }

    //show edit form
    public function edit(Listing $listing){
        return view('listings.edit',
        ['listing'=>$listing]);
    }

    public function update(Request $request,Listing $listing){

        //Make sure logged in user is the owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized action.');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required'

        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }
        $listing->update($formFields);
        return back()->with('message','Listing updated successfully!');



    }

    public function destroy(Listing $listing) {
        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }
        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully!');
    }

    //Manage Listings
    public function manage(){
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);

    }



}
