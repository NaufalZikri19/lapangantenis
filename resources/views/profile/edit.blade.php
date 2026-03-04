<x-dashboard-layout>

    <div class="max-w-3xl space-y-6">

        <h1 class="text-2xl font-semibold">
            Profile Settings
        </h1>

        <div class="bg-white p-6 rounded-xl shadow">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            @include('profile.partials.delete-user-form')
        </div>

    </div>

</x-dashboard-layout>
