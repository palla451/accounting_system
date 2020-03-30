<?php

namespace App\Http\Controllers;

use App\Charts\DataChart;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Input;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InputsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $data = Input::latest()->with('payments')->where('user_id', '=', $user->id)->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editRecord">Edit</a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRecord">Delete</a>';

                        return $btn;
                    })
                    ->addColumn('payment', function ($data) {
                        foreach($data->payments as $payments){
                            return $payments->name;
                        }
                    })
                    ->editColumn('date', function ($data){
                        return date('d-m-yy', strtotime($data->date) );
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $payments = Payment::all();

        $mounthInput = $this->getQueryChart($user);
        $chart = new DataChart();
        $api = route('chartApiInput');
        $chart->labels($mounthInput->keys())->load($api);


        return view('layout.dashboard',['payments' => $payments, 'user' => $user, 'chart' => $chart]);
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
        $user = Auth::user();

        $myDateTime = DateTime::createFromFormat('d-m-Y', $request->get('date'));
        $newDateString = $myDateTime->format('Y-m-d');

        $input = Input::updateOrCreate(['id' => $request->record_id],
            [
                'user_id' => $user->getAuthIdentifier(),
                'description' => $request->description,
                'import' => $request->import,
                'date' => $newDateString
            ]);

        if($request->record_id){

            $input = Input::with('payments')->find($request->record_id);
            $input->payments()->detach();
            $input->payments()->attach($request->payment,[
                'paymentable_id' => $request->record_id,
                'paymentable_type' => 'App\Models\Input']);

            return response()->json(['success'=>'Product saved successfully.']);

        }else {
            $input->payments()->attach($request->get('payment'),[
                'paymentable_id' => $input->getAttribute('id'),
                'paymentable_type' => 'App\Models\Input']);

            return response()->json(['success'=>'Product saved successfully.']);
        }

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
        $input = Input::with('payments')->find($id);

        return response()->json($input);
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
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $input = Input::with('payments')->find($id);
        $input->payments()->detach();
        $input->delete();

        return response()->json(['success'=>'Input deleted successfully.']);
    }

    public function chart($user)
    {
        $lastMounthInput = Input::whereDate('date','>=', Carbon::now()->subDays('30'))
                                ->where('user_id', '=', $user->id)
                                ->orderBy('date','asc')
                                     ->get()
                                    ->groupBy(function($input) {
                                        return Carbon::parse($input->date)->format('d-m');
                        });

        $mounthInput = $lastMounthInput->map(function ($result) {
                        return number_format((float)$result->sum('import_as_float'), 2, '.', '');
                    });

        $chart = new DataChart();
        $chart->labels($mounthInput->keys());

        return $chart;
    }

    public function getQueryChart($user)
    {
        $lastMounthInput = Input::whereDate('date','>=', Carbon::now()->subDays('30'))
            ->where('user_id', '=', $user->id)
            ->orderBy('date','asc')
                ->get()
                    ->groupBy(function($input) {
                        return Carbon::parse($input->date)->format('d-m');
            });

        $mounthInput = $lastMounthInput->map(function ($result) {
            return number_format((float)$result->sum('import_as_float'), 2, '.', '');
        });

        return $mounthInput;
    }




    /**
     * Function for test ChartTv
     */
    public function chartApiInput(Request $request) {

        $test = $request->all();

        $user = Auth::user();
        $chart = new DataChart();
        $mounthInput = $this->getQueryChart($user);
        $chart->dataset('Last Mounth Input', 'line', $mounthInput->values())
                            ->color('rgb(0,123,255)');
        return json_decode($chart->api());
    }

}
