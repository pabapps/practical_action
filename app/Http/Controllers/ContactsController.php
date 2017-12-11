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
         $query_contacts =  DB::table('contacts')->select(['id', 'name','email1'])->get();

        // $contact_collection = collect($query_contacts);

        return view('pabcontacts.contacts.contacts')->with('query_contacts',$query_contacts);
    }

    /**
     * resturns all the contacts to the front end through an ajax request
     */

    public function get_all_contacts(){

        // dd("testing");

        $query_contacts =  DB::table('contacts')->select(['id', 'name','email1'])->get();

        // $contact_collection = collect($query_contacts);

        return json_encode($query_contacts);

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

        if(!empty($request->file('pic'))){
        // typing to save the path of the pic
            $file = $request->file('pic');

            $file_name = time() . $file->getClientOriginalName();

            $file->move('contacts/photos', $file_name);
        }


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
     * 
     */

    public function get_specific_contact(Request $request){

        // dd($request->contact_id);

        $contact_id = $request->contact_id;

        $contact_details = Contacts::where('id',$contact_id)->first();

        $category = Categories::where('id',$contact_details->category_id)->first();

        $contact_theme = DB::table('contact_theme')->select('id', 'theme_id')->where('contact_id',$contact_id)->get();

        $theme_array = array();

        $counter = 0;

        foreach ($contact_theme as $c_theme) {

            $theme = ContactsTheme::where('id',$c_theme->theme_id)->first();

            $theme_array[$counter] = $theme;

            $counter = $counter + 1;

        }



        $final_array = array();

        $final_array['contact'] = $contact_details;
        $final_array['category'] = $category;
        $final_array['theme_array'] = $theme_array;

        return json_encode($final_array);

    }


    public function contact_update(Request $request){

        $contact_id = $request->person_id;

        if(!empty($request->name)){

            Contacts::where('id', $contact_id)
            ->update(['name' => $request->name]);
        }

        if(!empty($request->designation)){

            Contacts::where('id', $contact_id)
            ->update(['designation' => $request->designation]);

        }

        if(!empty($request->organization)){

            Contacts::where('id', $contact_id)
            ->update(['organization' => $request->organization]);

        }

        if(!empty($request->category_id)){

            Contacts::where('id', $contact_id)
            ->update(['category_id' => $request->category_id]);

        }

        if(!empty($request->theme_id)){


            $old_contact_theme = ContactThemePivot::where('contact_id',$contact_id)->get();

            foreach ($old_contact_theme as $array) {

                ContactThemePivot::where('id',$array->id)->delete();

            }

            $themes = $request->theme_id;

            foreach ($themes as $theme) {

                $contact_theme = new ContactThemePivot;

                $contact_theme->contact_id = $contact_id;
                $contact_theme->theme_id = $theme;

                $contact_theme->save();
            }
            

        }

        if(!empty($request->primary_email)){

            Contacts::where('id', $contact_id)
            ->update(['email1' => $request->primary_email]);

        }

        if(!empty($request->secondary_email)){

            Contacts::where('id', $contact_id)
            ->update(['email2' => $request->secondary_email]);

        }

        if(!empty($request->mobile)){

            Contacts::where('id', $contact_id)
            ->update(['mobile' => $request->mobile]);

        }

        if(!empty($request->phone)){

            Contacts::where('id', $contact_id)
            ->update(['phone' => $request->phone]);

        }

        if(!empty($request->file('pic'))){

            $file = $request->file('pic');

            $file_name = time() . $file->getClientOriginalName();

            $file->move('contacts/photos', $file_name);

            Contacts::where('id', $contact_id)
            ->update(['pic_path' => "/contacts/photos/{$file_name}"]);


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
        dd("working on it");
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
