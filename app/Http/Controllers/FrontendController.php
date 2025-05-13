<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function store(Request $request)
    {
        // $this->authorizeAdmin();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'vat_number' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'logo' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'acc' => 'required|string|max:255',
            'branch_code' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
        ]);

        $company = Company::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'contact' => $validatedData['contact'],
            'logo' => $validatedData['logo'],
            'email' => $validatedData['email'],
            'acc' => $validatedData['acc'],
            'branch_code' => $validatedData['branch_code'],
            'bank' =>  $validatedData['bank'],
        ]);

        return response()->json(['message' => 'Product added successfully', 'added' => $company], 201);
    }

    public function update(Request $request, $id)
    {
        // $this->authorizeAdmin();
        Log::info('Received Update Request:', $request->all());
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json(['message' => 'Company updated successfully', 'product' => $company], 200);
    }
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies);
    }
}
