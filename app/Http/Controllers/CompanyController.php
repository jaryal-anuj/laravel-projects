<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class Companycontroller extends Controller
{
    public function create(){

        return view('companies.create');
    }

    public function store(Request $request){

        $company = Company::make([
            'name'=>$request->name
        ]);

        $request->user()->companies()->save($company);
        return redirect()->route('tenant.switch',$company);
    }
}
