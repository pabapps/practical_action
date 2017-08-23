<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\ContactsTheme;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class ContactThemeController extends Controller
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
        return view('pabcontacts.theme.theme');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pabcontacts.theme.theme_create');
    }

    public function get_all_contact_theme(){

        $query_theme =  DB::table('themes')->select(['id', 'name'])->get();

        $theme_collection = collect($query_theme);
    // dd($reservation_collection);
        return Datatables::of($theme_collection)
        ->addColumn('action', function ($theme_collection) {
            return 

            ' <a href="'. url('/contact_theme') . '/' . 
            Crypt::encrypt($theme_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact_theme = new ContactsTheme;

        $contact_theme->name = $request->theme;
        $contact_theme->save();

        return redirect()->action('ContactThemeController@index');
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
        $id = Crypt::decrypt($id);

        $theme = ContactsTheme::where('id',$id)->first();

        return view('pabcontacts.theme.theme_edit')->with('theme',$theme);
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
        ContactsTheme::where('id', $id)
        ->update(['name' => $request->theme]);

        $request->session()->flash('alert-success', 'data has been successfully updated!');
        return redirect()->action('ContactThemeController@index'); 
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
