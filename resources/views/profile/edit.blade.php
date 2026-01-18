@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profile Settings')

@section('page-title', 'Privacy Settings')

@section('content')
<div class="">
    <div
        x-data="{ tab: '{{ auth()->user()->isAdmin() ? 'profile' : 'security' }}' }"
        class="bg-white rounded-2xl shadow-sm border border-gray-200"
    >

        {{-- Tabs --}}
        <div class="border-b border-gray-200">
            <nav class="flex gap-6 px-6" aria-label="Tabs">

                {{-- ADMIN ONLY --}}
                @if(auth()->user()->isAdmin())
                <button
                    @click="tab='profile'"
                    :class="tab === 'profile'
                        ? 'border-indigo-600 text-indigo-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Profile Info
                </button>
                @endif

                {{-- FOR ALL --}}
                <button
                    @click="tab='security'"
                    :class="tab === 'security'
                        ? 'border-indigo-600 text-indigo-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Security
                </button>

                <button
                    @click="tab='danger'"
                    :class="tab === 'danger'
                        ? 'border-red-600 text-red-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Danger Zone
                </button>
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="p-6 sm:p-8">

            {{-- ADMIN: Profile Info --}}
            @if(auth()->user()->isAdmin())
            <div x-show="tab === 'profile'" x-cloak>
                <div class="">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            @endif

            {{-- Password --}}
            <div x-show="tab === 'security'" x-cloak>
                <div class="">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete --}}
            <div x-show="tab === 'danger'" x-cloak>
                <div class="">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection