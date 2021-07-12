<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $admin = auth()->user();

       if(!$admin->isAdmin()){
        return back()->with('error','You do not have access to this page.');
       }

       $groups = Group::latest()->pluck('name','id')->toArray();

       return view('groups.index')->with(['groups'=> $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = auth()->user();

        if(!$admin->isAdmin()){
            return back()->with('error','You do not have access to this page.');
        }

        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = auth()->user();

        if(!$admin->isAdmin()){
            return back()->with('error','You do not have access to this page.');
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        $group = Group::create([
            'name'=> $request->name,
        ]);

        return redirect()->route('groups.index')
        ->with('success','Group added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = auth()->user();

        if(!$admin->isAdmin()){
            return back()->with('error','You do not have access to this page.');
        }

        $group = Group::where('id', $id)->first();
        $group['users'] = $group->users()->pluck('name','id')->toArray();

        return view('groups.show')->with(['group' => $group ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = auth()->user();

        if(!$admin->isAdmin()){
            return back()->with('error','You do not have access to this page.');
        }

        $group = Group::where('id', $id)->first();

        return view('groups.edit')->with(['group' => $group]);
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

        $admin = auth()->user();

        if(!$admin->isAdmin()){
            return back()->with('error','You do not have access to this page.');
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        $group = Group::where('id', $id)->first();
        $group->name = $request->name;
        $group->save();

        return redirect()->route('groups.index')
        ->with('success','Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = auth()->user();

        if(!$admin->isAdmin()){
            return back()->with('error','You do not have access to this page.');
        }
        
        Group::where('id', $id)->delete();

        return redirect()->route('groups.index')
        ->with('success','group deleted successfully.');
    }
}
