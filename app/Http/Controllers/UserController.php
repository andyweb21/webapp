<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user');
    }

    public function read()
    {
        $data = User::all();
        return view('read')->with([
            'data' => $data
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" onClick="show('.$row->id.')">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onClick="destroy('.$row->id.')">Delete</a>';
                    if(Auth::user()->id == $row->id) {
                        $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" onClick="show('.$row->id.')">Edit</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|without_spaces|email:rfc,dns|unique:users',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ],
        [
            'email.without_spaces' => 'Whitespace not allowed.'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message'=>$validator->getMessageBag()->toArray()]);
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        if($request->image) {
            $file = $request->file('image');
            $imageName = $file->hashName();  
        
            $file->move(public_path('images'), $imageName);
            // $pathImage = $request->file('image')->store('images');
            $data['image'] = $imageName;
        }
        User::insert($data);
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('edit')->with([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message'=>$validator->getMessageBag()->toArray()]);
        }

        $data = User::findOrFail($id);
        $data->name = $request->name;
        if($request->password) {
        $data->password = Hash::make($request->password);
        }
        if($request->image) {
            $file = $request->file('image');
            $imageName = $file->hashName();  
        
            $file->move(public_path('images'), $imageName);
            // $pathImage = $request->file('image')->store('images');
            $data->image = $imageName;
        }
        $data->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
    }
}
