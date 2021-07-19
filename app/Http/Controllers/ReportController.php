<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportFile;
use App\Models\Tag;
use App\Models\Group;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::latest()->get();

        return view('reports.index')->with(['reports'=>$reports]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::latest()->pluck('name','id')->toArray();
        $tags = Tag::latest()->pluck('name','id')->toArray();

        return view('reports.create')->with(['groups' => $groups])->with(['tags'=>$tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // return $request;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'content' => 'required',
            'group_id' => 'required',
            'tags' => 'array|required',
            'tags.*' => 'required',
            'files' =>'array|required',
            'files.*' => 'mimes:mp3,ogg,pdf,jpeg,png|max:2048',
        ]);
                    
        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        $report = Report::create([
            'name'=>$request->name,
            'content'=>$request->content,
            'group_id'=>$request->group_id,
            'user_id'=> auth()->user()->id
        ]);

        $report->tags()->attach($request->tags);

        if($request->hasFile('files')){
            foreach ($request->file('files') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extesion = $file->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extesion;
                $path = $file->storeAs('public/files', $fileNameToStore);
                
                ReportFile::create([
                    'report_id'=>$report->id,
                    'file_url'=>$fileNameToStore
                ]);
            }
        }
        
        return redirect()->route('reports.index')
            ->with('success','report added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::where('id', $id)->first();

        return view('reports.show')->with(['report'=>$report]);
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
        $report = Report::find($id);
        
        foreach ($report->report_files as $files) {
            Storage::delete('public/files/'. $files->file_url);
        }
        $report->delete();
        return redirect()->route('reports.index')
        ->with('success','Report deleted successfully.');
    }
}
