<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = auth()->user();
        $users = User::whereNotIn('name',[$user->name])->get();

        return view('users.index')->with(['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::whereNotIn('name',['admin'])->pluck('name','id')->toArray();
        $groups = Group::latest()->pluck('name','id')->toArray();
        

        return view('users.create')->with(['roles' => $roles])->with(['groups'=>$groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'roles'=>'array|required',
            'roles.*'=>'required',
            'groups'=>'array|required',
            'groups.*'=>'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $user->roles()->attach($request->roles);
        $user->groups()->attach($request->groups);

        return redirect()->route('users.index')
            ->with('success','User added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $user = User::where('id',$id)->first();
        }

        $user['roles'] = $user->roles()->pluck('name','id')->toArray(); 
        $user['groups'] = $user->groups()->pluck('name','id')->toArray(); 
        
        return view('users.show')->with(['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        
        if($user == null){
            return redirect()->route('users.index')
            ->with('error','There are no user with this id.');
        }
        $roles = Role::whereNotIn('name',['admin'])->pluck('name','id')->toArray();
        $user['groups'] = $user->groups()->pluck('name','id')->toArray(); 
        $groups = Group::latest()->pluck('name','id')->toArray();

        return view('users.edit')->with(['user' => $user])->with(['roles' => $roles])->with(['groups' => $groups]);
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

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'roles'=>'array|required',
            'roles.*'=>'required',
            'groups'=>'array|required',
            'groups.*'=>'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->roles()->sync($request->roles);
        $user->groups()->sync($request->groups);
        
        return redirect()->route('users.index')
        ->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        $reports = $user->reports;
        $admin = user::where('name', "admin")->first();

        foreach ($reports as $report) {
            $report->user_id = $admin->id;
            $report->save();
        }

        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success','User deleted successfully.');
    }

}