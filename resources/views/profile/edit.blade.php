@php
$layout = Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.customer';
@endphp

@extends($layout)

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

<h1 class="text-2xl font-bold mb-6">
Profile Settings
</h1>

<div class="bg-white p-6 rounded shadow">
@include('profile.partials.update-profile-information-form')
</div>

<div class="bg-white p-6 rounded shadow">
@include('profile.partials.update-password-form')
</div>

<div class="bg-white p-6 rounded shadow">
@include('profile.partials.delete-user-form')
</div>

</div>

@endsection
