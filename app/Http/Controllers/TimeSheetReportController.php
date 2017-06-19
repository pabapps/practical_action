<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Crypt;
use Auth;
use App\User;
use App\UserDesignationModel;
use App\UserProjectModel;
use App\UserTimeSheetModel;
use App\Projects;
use Entrust;
use PDF;

class TimeSheetReportController extends Controller
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

        $users = DB::table('users')->select('id','name')->get();

        return view('timesheet.reports.timeReport')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   


        $user_id = $request->user_id;

        $start_date = $request->start_date;

        $end_date = $request->end_date;

        $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();

        $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();

        $query_time_report = DB::table('time_sheet_user')
        ->join('projects','time_sheet_user.project_id','=','projects.id')
        ->join('users','time_sheet_user.user_id','=','users.id')
        ->select('users.name','users.email','projects.project_name','projects.project_code',
            'time_sheet_user.time_spent','time_sheet_user.date')->where('time_sheet_user.user_id',$user_id)
        ->where('time_sheet_user.valid',1)->where('time_sheet_user.sent_to_accounts',1)
        ->where('projects.valid',1)
        ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();

        dd($query_time_report);

        


        $html = '<h1>HTML Example</h1>
        Some special characters: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-slash
        <h2>List</h2>
        List example:
        <ol>
        <li><b>bold text</b></li>
        <li><i>italic text</i></li>
        <li><u>underlined text</u></li>
        <li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
        <li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
        <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
        <li>SUBLIST
        <ol>
        <li>row one
        <ul>
        <li>sublist</li>
        </ul>
        </li>
        <li>row two</li>
        </ol>
        </li>
        <li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
        <li><font size="+3">font + 3</font></li>
        <li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
        </ol>
        <dl>
        <dt>Coffee</dt>
        <dd>Black hot drink</dd>
        <dt>Milk</dt>
        <dd>White cold drink</dd>
        </dl>
        <div style="text-align:center">IMAGES<br />
        </div>';

        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('hello_world.pdf');
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
