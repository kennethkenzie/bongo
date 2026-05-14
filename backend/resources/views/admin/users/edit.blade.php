@extends('admin.layout', ['title' => 'Edit User', 'subtitle' => 'Update profile details and dashboard permissions.'])
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
  <form method="POST" action="{{ route('admin.users.update', $user) }}" class="lg:col-span-2 bg-white rounded-sm border border-line p-5 shadow-admin">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <label class="block">
        <span class="text-xs text-gray-500">Name</span>
        <input name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
      </label>
      <label class="block">
        <span class="text-xs text-gray-500">Email</span>
        <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
      </label>
      <label class="block">
        <span class="text-xs text-gray-500">Phone</span>
        <input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
      </label>
      <label class="block">
        <span class="text-xs text-gray-500">Role</span>
        <select name="role" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
          @foreach($roles as $key => $label)
            <option value="{{ $key }}" @selected(old('role', $user->role) === $key)>{{ $label }}</option>
          @endforeach
        </select>
      </label>
    </div>
    <div class="flex items-center gap-2 mt-5">
      <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">Save user</button>
      <a href="{{ route('admin.users.index') }}" class="border border-line px-4 py-2 rounded-sm text-sm hover:bg-surface">Cancel</a>
    </div>
  </form>

  <div class="bg-white rounded-sm border border-line p-5 shadow-admin">
    <div class="w-14 h-14 bg-brand-100 text-brand-700 rounded-sm grid place-items-center font-extrabold text-xl mb-3">{{ strtoupper(substr($user->name,0,1)) }}</div>
    <h2 class="font-bold">{{ $user->name }}</h2>
    <p class="text-sm text-gray-500">{{ $user->email }}</p>
    <div class="mt-4 pt-4 border-t border-line">
      <h3 class="font-semibold text-sm mb-2">Current permissions</h3>
      <ul class="space-y-1 text-sm text-gray-600">
        @foreach(($permissions[$user->role] ?? []) as $item)
          <li class="flex items-start gap-2"><x-icon name="check-circle" :size="14" class="text-emerald-600 mt-0.5" /> {{ $item }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endsection
