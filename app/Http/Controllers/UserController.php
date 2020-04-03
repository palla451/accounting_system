<?php

namespace App\Http\Controllers;

use App\Models\Input;
use App\Models\Job;
use App\Models\Payment;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $data = User::withTrashed()->with('job')->get();
            $pluck = $data->pluck('deleted_at','id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) use ($data){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editRecord">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRecord">Delete</a>';

                    foreach ($data as $item){
                        if($item->id == $row->id && is_null($item->deleted_at)){
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="softDelete" data-button="softDelete'.$row->id.'" class="btn btn-warning btn-sm softDeleteRecord">Disabled</a>';
                        }elseif($item->id == $row->id && $item->deleted_at){
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="restore" data-button="restore'.$row->id.'" class="btn btn-secondary btn-sm restoreRecord">Restore</a>';
                        }else{
                         // make null
                        }
                    }

                    return $btn;
                })
                ->addColumn('job', function($user) {
                    return $user->job->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $jobs = Job::all();

        return view('user.tableUser', compact(['user','jobs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($data)
    {
        $user = User::create([
            'lstName' => $data['lstName'],
            'fstName' => $data['fstName'],
            'job_id'  => $data['job'],
            'email'  => $data['email'],
            'password' => Hash::make($data['password'])
            ]);

        $role = Role::find(1); // ruolo user
        $user->roles()->attach($role->getAttribute('id'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        /* nuovo utente */
        if(!isset($request->record_id)){
            $this->create($data);
            return response()->json(['success'=>'User saved successfully.']);
        }
        else{
             $this->update($data);
             return response()->json(['success'=>'User updated successfully.']);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::with('job')->find($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $data
     * @return void
     */
    public function update($data)
    {
        $user = User::find($data['record_id']);

        $user->update([
            'fstName' => $data['fstName'],
            'lstName' => $data['lstName'],
            'job_id' => $data['job'],
            'email'  => $data['email'],
            'password' => isset($data['password']) ? $data['password'] : $user->password
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $user = User::with('roles')->find($id);
        $user->roles()->detach();
        $user->delete();

        return response()->json(['success'=>'User deleted successfully.']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['success'=>'User disabled successfully.']);
    }

    /**
     * @param $id
     * @return ResponseFactory|JsonResponse|Response
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!is_null($user)) {

            $user->restore();
            return response()->json(['success'=>'User reactivate successfully.']);
        } else{

            return response()->json(['success'=>'User reactivate successfully.']);
        }

        return response($response);

    }
}
