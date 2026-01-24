<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['user'])
            ->withCount('applications');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $jobs = $query->orderByDesc('created_at')->paginate(20);
        
        $totalJobs = Job::count();
        $pendingJobs = Job::where('status', 'pending')->count();
        $activeJobs = Job::where('is_active', true)->count();
        
        return view('admin.jobs.index', compact('jobs', 'totalJobs', 'pendingJobs', 'activeJobs'));
    }

    public function show($identifier)
    {
        $job = Job::findBySlugOrId($identifier);
        
        if (!$job) {
            abort(404);
        }
        
        $job->load(['user']);
        $job->loadCount('applications');
        return view('admin.jobs.show', compact('job'));
    }

    public function updateStatus(Request $request, Job $job)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        $job->update([
            'status' => $request->status,
            'is_active' => $request->status == 'approved',
        ]);
        
        return redirect()->route('admin.jobs.show', $job)
            ->with('success', 'Job status updated successfully.');
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('admin.jobs.create', compact('categories', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency' => 'nullable|string|max:3',
            'is_negotiable' => 'boolean',
            'job_type' => 'required|string|in:full-time,part-time,contract,remote,internship',
            'experience_level' => 'required|string|in:intern,junior,mid,senior,lead,executive',
            'skills_required' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'company_logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'status' => 'required|string|in:pending,approved,rejected',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Get company name from selected company
        // $company = Company::findOrFail($validated['company_id']);
        // $validated['company_name'] = $company->name;

        // Generate unique slug
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        // Handle salary display based on is_negotiable checkbox
        $isNegotiable = $request->boolean('is_negotiable');
        $currency = $request->salary_currency ?: 'USD';
        $salaryMin = $request->salary_min;
        $salaryMax = $request->salary_max;

        if ($isNegotiable) {
            // If negotiable is checked
            $validated['salary'] = 'Negotiable';
            $validated['is_negotiable'] = true;
            $validated['salary_min'] = null;
            $validated['salary_max'] = null;
            $validated['salary_currency'] = $currency;
        } elseif ($salaryMin && $salaryMax) {
            // If both min and max are provided
            $validated['salary'] = $currency . ' ' . number_format($salaryMin) . ' - ' . $currency . ' ' . number_format($salaryMax) . ' per month';
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = $salaryMin;
            $validated['salary_max'] = $salaryMax;
            $validated['salary_currency'] = $currency;
        } elseif ($salaryMin) {
            // If only min is provided
            $validated['salary'] = 'From ' . $currency . ' ' . number_format($salaryMin) . ' per month';
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = $salaryMin;
            $validated['salary_max'] = null;
            $validated['salary_currency'] = $currency;
        } elseif ($salaryMax) {
            // If only max is provided
            $validated['salary'] = 'Up to ' . $currency . ' ' . number_format($salaryMax) . ' per month';
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = null;
            $validated['salary_max'] = $salaryMax;
            $validated['salary_currency'] = $currency;
        } else {
            // If nothing is provided
            $validated['salary'] = null;
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = null;
            $validated['salary_max'] = null;
            $validated['salary_currency'] = $currency;
        }

        // Format skills required
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
            $validated['skills_required'] = $skills;
        }

        // Format benefits
        if ($request->filled('benefits')) {
            $benefits = array_filter(array_map('trim', explode("\n", $request->benefits)));
            $validated['benefits'] = $benefits;
        }

        // Handle file upload
        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $request->file('company_logo')->store('company-logos', 'public');
        } elseif ($company->logo) {
            // Use company's logo if no new logo uploaded
            $validated['company_logo'] = $company->logo;
        }

        // Set default values
        $validated['user_id'] = auth()->id();
        $validated['views'] = 0;

        // Create the job
        Job::create($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job posted successfully.');
    }

    public function edit($identifier)
    {
        $job = Job::findBySlugOrId($identifier);
        
        if (!$job) {
            abort(404);
        }
        
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('admin.jobs.edit', compact('job', 'categories', 'companies'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency' => 'nullable|string|max:3',
            'is_negotiable' => 'boolean',
            'job_type' => 'required|string|in:full-time,part-time,contract,remote,internship',
            'experience_level' => 'required|string|in:intern,junior,mid,senior,lead,executive',
            'skills_required' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'company_logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'status' => 'required|string|in:pending,approved,rejected',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Get company name from selected company
        // $company = Company::findOrFail($validated['company_id']);
        // $validated['company_name'] = $company->name;

        // Generate new slug if title changed
        if ($job->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $job->id);
        }

        // Handle salary display based on is_negotiable checkbox
        $isNegotiable = $request->boolean('is_negotiable');
        $currency = $request->salary_currency ?: 'USD';
        $salaryMin = $request->salary_min;
        $salaryMax = $request->salary_max;

        if ($isNegotiable) {
            // If negotiable is checked
            $validated['salary'] = 'Negotiable';
            $validated['is_negotiable'] = true;
            $validated['salary_min'] = null;
            $validated['salary_max'] = null;
            $validated['salary_currency'] = $currency;
        } elseif ($salaryMin && $salaryMax) {
            // If both min and max are provided
            $validated['salary'] = $currency . ' ' . number_format($salaryMin) . ' - ' . $currency . ' ' . number_format($salaryMax) . ' per month';
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = $salaryMin;
            $validated['salary_max'] = $salaryMax;
            $validated['salary_currency'] = $currency;
        } elseif ($salaryMin) {
            // If only min is provided
            $validated['salary'] = 'From ' . $currency . ' ' . number_format($salaryMin) . ' per month';
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = $salaryMin;
            $validated['salary_max'] = null;
            $validated['salary_currency'] = $currency;
        } elseif ($salaryMax) {
            // If only max is provided
            $validated['salary'] = 'Up to ' . $currency . ' ' . number_format($salaryMax) . ' per month';
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = null;
            $validated['salary_max'] = $salaryMax;
            $validated['salary_currency'] = $currency;
        } else {
            // If nothing is provided
            $validated['salary'] = null;
            $validated['is_negotiable'] = false;
            $validated['salary_min'] = null;
            $validated['salary_max'] = null;
            $validated['salary_currency'] = $currency;
        }

        // Format skills required
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
            $validated['skills_required'] = $skills;
        }

        // Format benefits
        if ($request->filled('benefits')) {
            $benefits = array_filter(array_map('trim', explode("\n", $request->benefits)));
            $validated['benefits'] = $benefits;
        }

        // Handle file upload - new logo
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($job->company_logo && $job->company_logo !== $company->logo) {
                Storage::disk('public')->delete($job->company_logo);
            }
            $validated['company_logo'] = $request->file('company_logo')->store('company-logos', 'public');
        } elseif ($request->has('remove_logo') && $request->remove_logo == '1') {
            // Remove logo if requested
            if ($job->company_logo && $job->company_logo !== $company->logo) {
                Storage::disk('public')->delete($job->company_logo);
            }
            $validated['company_logo'] = $company->logo;
        } else {
            // Keep existing logo or use company's logo
            $validated['company_logo'] = $job->company_logo ?: $company->logo;
        }

        $job->update($validated);

        return redirect()->route('admin.jobs.show', $job)
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->applications()->delete();
        $job->delete();
        
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    /**
     * Generate unique slug for job
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        $query = Job::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count++;
            $query = Job::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}