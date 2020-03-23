<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Input;
use DateTime;
use Illuminate\Support\Facades\Auth;
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
        $route = route('inputs.index');
        if ($request->ajax()) {
            $data = Input::latest()->with('payments')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editInput">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteInput">Delete</a>';

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
        $user = Auth::user();

        return view('layout.dashboard',['payments' => $payments, 'user' => $user]);
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
        $newDateString = $myDateTime->format('Y-m-d H:i');

        $input = Input::updateOrCreate(['id' => $request->input_id],
            [
                'user_id' => $user->getAuthIdentifier(),
                'description' => $request->description,
                'import' => $request->import,
                'date' => $newDateString
            ]);

        if($request->input_id){

            $input = Input::with('payments')->find($request->input_id);
            $input->payments()->detach();
            $input->payments()->attach($request->payment,[
                'paymentable_id' => $request->input_id,
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
}
