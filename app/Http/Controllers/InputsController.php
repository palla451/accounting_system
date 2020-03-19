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
     */
    public function index(Request $request)
    {
//        $datas = Input::latest()->with('payments')->get();

//        foreach($datas as $data ){
//            foreach($data->payments as $payment){
//                echo $payment->name;
//            }
//        }


        if ($request->ajax()) {
            $data = Input::latest()->with('payments')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

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
//        return view('layout.dashboard',compact('products'));
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

        $myDateTime = DateTime::createFromFormat('d-m-Y', $request->get('date'));
        $newDateString = $myDateTime->format('Y-m-d H:i');
        $input = Input::updateOrCreate([
                'user_id' => 1,
                'description' => $request->description,
                'import' => $request->import,
                'date' => $newDateString
            ]);


        $input->payments()->attach($request->get('payment'),[
            'paymentable_id' => $input->getAttribute('id'),
            'paymentable_type' => 'App\Models\Input']);

        return response()->json(['success'=>'Product saved successfully.']);
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
