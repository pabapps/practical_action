<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\ContactsTheme;
use App\Contacts;
use App\ContactThemePivot;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pabcontacts.contacts.contacts');
    }

    public function get_all_contacts(){
        $query_contacts =  DB::table('contacts')->select(['id', 'name'])->get();

       $contact_collection = collect($query_contacts);
    // dd($reservation_collection);
       return Datatables::of($contact_collection)
       ->addColumn('action', function ($contact_collection) {
        return 

        ' <button  class="btn btn-primary btn-danger" data-toggle="modal" id="edit-button" data-target="#edit-modal"><i class="glyphicon   glyphicon-list"></i> Edit</button>';
    })
       ->editColumn('id', '{{$id}}')
       ->setRowId('id')
       ->make(true);

   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pabcontacts.contacts.contacts_create');
    }


    public function get_all_categories(Request $request){
        $search_term = $request->input('term');

        $query_categories= "
        SELECT categories.id , categories.name AS text
        FROM categories WHERE categories.name LIKE '%{$search_term}%'";

        $categories = DB::select($query_categories);


        return response()->json($categories);

    }

    public function get_all_themes(Request $request){

        $search_term = $request->input('term');

        $query_themes= "
        SELECT themes.id , themes.name AS text
        FROM themes WHERE themes.name LIKE '%{$search_term}%'";

        $themes = DB::select($query_themes);


        return response()->json($themes);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validating
        $this->validate($request,[

            'name' =>'required',
            'designation' =>'required',
            'organization' =>'required',
            'category_id' =>'required',
            'theme_id' =>'required',
            'primary_email' =>'required',
            'mobile' =>'required',
            'address' =>'required', 
            ]);


        // typing to save the path of the pic
        $file = $request->file('pic');

        $file_name = time() . $file->getClientOriginalName();

        $file->move('contacts/photos', $file_name);


        $contact =  new Contacts;
        $contact->name = $request->name;
        $contact->designation = $request->designation;
        $contact->organization = $request->organization;
        $contact->category_id = $request->category_id;
        $contact->email1 = $request->primary_email;
        if(!empty($request->secondary_email)){
            $contact->email2 = $request->secondary_email;
        }
        $contact->mobile = $request->mobile;
        if(!empty($request->phone)){

            $contact->phone = $request->phone;

        }
        if(!empty($request->file('pic'))){
            $contact->pic_path = "/contacts/photos/{$file_name}";
        }
        $contact->address = $request->address;

        $contact->save();

        $themes = $request->theme_id;

        foreach ($themes as $theme) {

            $contact_theme = new ContactThemePivot;

            $contact_theme->contact_id = $contact->id;
            $contact_theme->theme_id = $theme;

            $contact_theme->save();
        }

        return redirect()->action('ContactsController@index');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
