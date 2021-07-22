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
use Illuminate\Support\Str;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user->isAdmin()){
            $reports = Report::latest()->get();
        }else {
            $groups = $user->groups->pluck('id')->toArray();
            $reports = Report::whereIn('group_id', $groups)->get();
        }

        return view('reports.index')->with(['reports'=>$reports]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        if($user->isAdmin()){
            $groups = Group::latest()->pluck('name','id')->toArray();
        }else{
            $groups = $user->groups->pluck('name','id')->toArray();
        }

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
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'content' => 'required',
            'group_id' => 'required',
            'tags' => 'array|required',
            'tags.*' => 'required',
            'files' =>'array|required|max:10240',
            'files.*' => 'file|mimetypes:audio/mp4,audio/x-wav,audio/ogg,audio/mpeg,image/jpeg,image/png|max:10240',
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
        if($report == null){          
        return redirect()->route('reports.index')
        ->with('error','there are no report with this id.');
        }
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
        $user = auth()->user();
        $report = Report::where('id', $id)->first();

        if($report == null){
            return redirect()->route('reports.index')
            ->with('error','There are no report with this id.');
        }
        if($user->isAdmin()){
            $groups = Group::latest()->pluck('name', 'id')->toArray();
        }else{

            $groups = $user->groups()->pluck('name','id')->toArray(); 
        }

        $report['tags'] =  $report->tags->pluck('name', 'id')->toArray();
        $tags = Tag::latest()->pluck('name', 'id');

        return view('reports.edit')->with(['report' => $report])->with(['groups' => $groups])->with(['tags' => $tags]);

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
            'name' => 'required',
            'content' => 'required',
            'group_id' => 'required',
            'delete_old_files' => 'required',
            'tags' => 'array|required',
            'tags.*' => 'required',
            'files' =>'array|max:10240',
            'files.*' => 'file|mimetypes:audio/mp4,audio/x-wav,audio/ogg,audio/mpeg,image/jpeg,image/png|max:10240',
        ]);
                    
        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        $report = Report::where('id', $id)->first();

        
        $report->name = $request->name;
        $report->content = $request->content;
        $report->group_id = $request->group_id;
        $report->save();
        
        $report->tags()->sync($request->tags);
        
        if($request->delete_old_files == "true"){
            foreach ($report->report_files as $file) {
                Storage::delete('public/files/'. $file->file_url);
                $file->delete();
            }
        }

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
            ->with('success','report updated successfully.');
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
        
        foreach ($report->report_files as $file) {
            Storage::delete('public/files/'. $file->file_url);
        }

        $report->delete();
        return redirect()->route('reports.index')
        ->with('success','Report deleted successfully.');
    }

    
    public function searchForReports(Request $request){
       
        $validator = Validator::make($request->all(),[
            'search_by' => 'required',
            'text' => 'required',
        ]);
                    
        if($validator->fails()){
            return back()->withErrors($validator->messages());
        }

        if ($request->search_by == 'name' || $request->search_by == 'content') {
            // search by report name or report content
            $response = $this->searchByNameOrContent($request->search_by ,$request->text);
        
        }elseif($request->search_by == 'uploader' || $request->search_by == 'group' || $request->search_by == 'tag'){
            // search by uploader name, tag or group
            $response = $this->searchBy($request->search_by ,$request->text);

        }

        return $response;

    }


    private function searchByNameOrContent($search_by , $text){

        $user = auth()->user();

        if($user->isAdmin()){
            $all_reports = Report::latest()->get();
        }else{
            $groups = $user->groups->pluck('id')->toArray();
            $all_reports = Report::whereIn('group_id', $groups)->get();
        }
        
        $reports = [];
        foreach ($all_reports as $key => $report) {
         $texts = explode(" ", $text);
            if($search_by == 'name'){
                if(Str::contains($report->name,$texts)){
                    array_push($reports, $report);
                }
            }elseif($search_by == 'content'){
                if(Str::contains($report->content,$texts)){
                    array_push($reports, $report);
                }
            }
        }

        if(empty($reports)){
            return redirect()->route('reports.index')
            ->with('error','there are no reports with this '. $search_by .'.');
        }

        return view('reports.index')->with(['reports'=>$reports]);
    }


    private function searchBy($search_by, $text){

        $user = auth()->user();

        if($search_by == 'uploader'){

            $criteria = User::where('name', $text)->first();

        }elseif ($search_by == 'tag') {

            $criteria = Tag::where('name', $text)->first();

        }elseif($search_by == 'group'){

            $criteria = Group::where('name', $text)->first();
            
        }

        if($criteria == null){
            return redirect()->route('reports.index')
            ->with('error','there are no '. $search_by.' with '. $text.'.');
        }

        if($user->isAdmin()){
            $reports = $criteria->reports;
        }else{
            $groups = $user->groups->pluck('id')->toArray();
            $reports = $criteria->reports->whereIn('group_id', $groups)->all();
            if(empty($reports)){
                return redirect()->route('reports.index')
                ->with('error','there are no reports with this '. $search_by .'.');
            }
        }

        
        return view('reports.index')->with(['reports'=>$reports]);

    }


}
