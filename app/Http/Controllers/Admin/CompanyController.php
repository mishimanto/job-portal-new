<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('jobs')->latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'industry' => 'nullable|string',
            'location' => 'nullable|string',
            'size' => 'nullable|integer',
            'founded_date' => 'nullable|date',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        Company::create($validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        $jobs = $company->jobs()->latest()->paginate(10);
        return view('admin.companies.show', compact('company', 'jobs'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'industry' => 'nullable|string',
            'location' => 'nullable|string',
            'size' => 'nullable|integer',
            'founded_date' => 'nullable|date',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        
        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}