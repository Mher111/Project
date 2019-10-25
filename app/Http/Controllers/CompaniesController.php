<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()){
            $companies=Company::where('user_id',Auth::id())->get();

            return view('companies.index',compact('companies'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
            $company = Company::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => Auth::user()->id
            ]);
            if($company){
                return redirect()->route('companies.show', ['company'=> $company->id])
                    ->with('success' , 'Company created successfully');
            }
        }

        return back()->withInput()->with('errors', 'Error creating new company');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $company=Company::find($company->id);
        return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company=Company::find($company->id);
        return view('companies.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $companyUpdate=Company::where('id',$company->id)->update([
            'name'=>$request->input('name'),
            'description'=>$request->input('description')
        ]);
        if ($companyUpdate){
            return redirect()->route('companies.show',compact('company'))->with('success','company updated successfully');
        }
        //
        $validated = $request->validated();
        if ($validated->fails()) {
            Session::flash('error', $validated->messages()->first());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {

        $findCompany = Company::find( $company->id);
        if($findCompany->delete()){

            //redirect
            return redirect()->route('companies.index')
                ->with('success' , 'Company deleted successfully');
        }
        return back()->withInput()->with('error' , 'Company could not be deleted');
    }
}
