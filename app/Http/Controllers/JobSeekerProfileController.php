<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Certification;
use App\Models\SocialLink;
use App\Models\ProfileVisibilitySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        return view('jobseeker.profile.edit', [
            'user' => $user,
            'personalInfo' => $user->personalInformation ?? null,
            'educations' => $user->educations,
            'skills' => $user->skills,
            'experiences' => $user->experiences,
            'projects' => $user->projects,
            'certifications' => $user->certifications,
            'socialLinks' => $user->socialLinks,
            'visibilitySettings' => $user->profileVisibilitySetting ?? new ProfileVisibilitySetting(),
        ]);
    }

    public function updatePersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $user->personalInformation()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Personal information updated successfully.');
    }

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'grade' => 'nullable|string|max:50',
            'activities' => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->educations()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Education added successfully.');
    }

    public function updateEducation(Request $request, Education $education)
    {
        // Manual authorization check
        if (Auth::id() !== $education->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'grade' => 'nullable|string|max:50',
            'activities' => 'nullable|array',
        ]);

        $education->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Education updated successfully.');
    }

    public function destroyEducation(Education $education)
    {
        // Manual authorization check
        if (Auth::id() !== $education->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $education->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Education deleted successfully.');
    }

    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->skills()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Skill added successfully.');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        // Manual authorization check
        if (Auth::id() !== $skill->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $skill->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Skill updated successfully.');
    }

    public function destroySkill(Skill $skill)
    {
        // Manual authorization check
        if (Auth::id() !== $skill->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $skill->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Skill deleted successfully.');
    }

    public function storeExperience(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_current' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'industry' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->experiences()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Experience added successfully.');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        // Manual authorization check
        if (Auth::id() !== $experience->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_current' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'industry' => 'nullable|string|max:255',
        ]);

        $experience->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Experience updated successfully.');
    }

    public function destroyExperience(Experience $experience)
    {
        // Manual authorization check
        if (Auth::id() !== $experience->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $experience->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Experience deleted successfully.');
    }

    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'role' => 'nullable|string|max:255',
            'technologies_used' => 'nullable|array',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_ongoing' => 'boolean',
            'project_url' => 'nullable|url|max:255',
            'images' => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->projects()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Project added successfully.');
    }

    public function updateProject(Request $request, Project $project)
    {
        // Manual authorization check
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'role' => 'nullable|string|max:255',
            'technologies_used' => 'nullable|array',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_ongoing' => 'boolean',
            'project_url' => 'nullable|url|max:255',
            'images' => 'nullable|array',
        ]);

        $project->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Project updated successfully.');
    }

    public function destroyProject(Project $project)
    {
        // Manual authorization check
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $project->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Project deleted successfully.');
    }

    public function storeCertification(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'skills' => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->certifications()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Certification added successfully.');
    }

    public function updateCertification(Request $request, Certification $certification)
    {
        // Manual authorization check
        if (Auth::id() !== $certification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'skills' => 'nullable|array',
        ]);

        $certification->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Certification updated successfully.');
    }

    public function destroyCertification(Certification $certification)
    {
        // Manual authorization check
        if (Auth::id() !== $certification->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $certification->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Certification deleted successfully.');
    }

    public function storeSocialLink(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'username' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        $user = Auth::user();
        $user->socialLinks()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Social link added successfully.');
    }

    public function updateSocialLink(Request $request, SocialLink $socialLink)
    {
        // Manual authorization check
        if (Auth::id() !== $socialLink->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'username' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        $socialLink->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Social link updated successfully.');
    }

    public function destroySocialLink(SocialLink $socialLink)
    {
        // Manual authorization check
        if (Auth::id() !== $socialLink->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $socialLink->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Social link deleted successfully.');
    }

    public function updateVisibilitySettings(Request $request)
    {
        $validated = $request->validate([
            'make_profile_public' => 'boolean',
            'show_education' => 'boolean',
            'show_experience' => 'boolean',
            'show_projects' => 'boolean',
            'show_certifications' => 'boolean',
            'show_skills' => 'boolean',
            'show_social_links' => 'boolean',
            'show_contact_info' => 'boolean',
        ]);

        $user = Auth::user();
        $user->profileVisibilitySetting()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Visibility settings updated successfully.');
    }

    public function getProfileStats()
    {
        $user = Auth::user();
        
        $profileViews = $user->profileViews()->count();
        $jobViews = $user->jobApplications()->count();

        return response()->json([
            'profile_views' => $profileViews,
            'job_views' => $jobViews,
        ]);
    }
}