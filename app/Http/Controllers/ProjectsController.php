<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Project;
use App\ProjectUser;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()){
            $projects=Project::where('user_id',Auth::id())->get();

            return view('projects.index',compact('projects'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $companies=Company::where('user_id',Auth::id())->get();



        return view('projects.create',['project_id'=>$id],['companies'=>$companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $project = Project::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id'),
                'user_id' => Auth::user()->id
            ]);
            if($project){
                return redirect()->route('projects.show', ['project'=> $project->id])
                    ->with('success' , 'Project created successfully');
            }
        }

        return back()->withInput()->with('errors', 'Error creating new project');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project=Project::whereId($id)->first();
        return view('projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $project=Project::find($project->id);
        return view('projects.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, project $project)
    {
        $projectUpdate=Project::where('id',$project->id)->update([
            'name'=>$request->input('name'),
            'description'=>$request->input('description')
        ]);
        if ($projectUpdate){
            return redirect()->route('projects.show',compact('project'))->with('success','project updated successfully');
        }
        //
        $validated = $request->validated();
        if ($validated->fails()) {
            Session::flash('error', $validated->messages()->first());
            return redirect()->back()->withInput();
        }
    }
    public function adduser(Request $request){
        //add user to projects
        //take a project, add a user to it
        $project = Project::find($request->input('project_id'));

        if(Auth::user()->id == $project->user_id) {

            $user = User::where('email', $request->input('email'))->first(); //single record
            //check if user is already added to the project
            $projectUser = ProjectUser::where('user_id', $user->id)
                ->where('project_id', $project->id)
                ->first();
            dd('123');
            if ($projectUser) {
                //if user already exists, exit

                return response()->json(['success', $request->input('email') . ' is already a member of this project']);

            }
            if($user && $project){
                $project->users()->attach($user->id);
                return response()->json(['success' ,  $request->input('email').' was added to the project successfully']);

            }

        }
        return redirect()->route('projects.show', ['project'=> $project->id])
            ->with('errors' ,  'Error adding user to project');
        }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $findProject = Project::find( $project->id);
        if($findProject->delete()){

            //redirect
            return redirect()->route('projects.index')
                ->with('success' , 'Project deleted successfully');
        }
        return back()->withInput()->with('error' , 'Project could not be deleted');
    }
}
