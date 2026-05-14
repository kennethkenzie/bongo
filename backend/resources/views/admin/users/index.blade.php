@extends('admin.layout', ['title' => 'User Management', 'subtitle' => 'Manage customers, staff accounts, and access roles.'])
@section('content')
<div class="bg-white rounded-sm border border-line p-4 mb-3 shadow-admin">
  <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2 text-sm">
    <div class="relative md:col-span-2">
      <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="search" :size="15" /></span>
      <input name="q" value="{{ request('q') }}" placeholder="Search name, email, phone…" class="border border-line rounded-sm pl-8 pr-3 py-2 w-full focus:outline-none focus:border-brand-600">
    </div>
    <select name="role" class="border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
      <option value="">All roles</option>
      @foreach($roles as $key => $label)
        <option value="{{ $key }}" @selected(request('role') === $key)>{{ $label }}</option>
      @endforeach
    </select>
    <button class="inline-flex items-center justify-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-3 py-2 rounded-sm font-semibold">
      <x-icon name="search" :size="14" /> Filter users
    </button>
  </form>
</div>

<div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
  <div class="px-4 py-3 border-b border-line flex items-center justify-between">
    <div>
      <h2 class="font-bold">Accounts</h2>
      <p class="text-xs text-gray-500">{{ number_format($users->total()) }} users found.</p>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="text-brand-700 text-sm hover:underline inline-flex items-center gap-1">
      Roles <x-icon name="arrow-right" :size="13" />
    </a>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-surface text-gray-500 text-xs uppercase">
        <tr>
          <th class="text-left px-4 py-2">User</th>
          <th class="text-left px-4 py-2">Role</th>
          <th class="text-left px-4 py-2">Phone</th>
          <th class="text-left px-4 py-2">Joined</th>
          <th class="px-4 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $u)
          @php
            $tone = match($u->role) {
              'admin' => 'bg-brand-50 text-brand-700',
              'manager' => 'bg-emerald-50 text-emerald-700',
              'support' => 'bg-amber-50 text-amber-700',
              default => 'bg-gray-100 text-gray-600',
            };
          @endphp
          <tr class="border-t border-line hover:bg-surface/70">
            <td class="px-4 py-2 flex items-center gap-3 min-w-[280px]">
              <div class="w-9 h-9 bg-brand-100 text-brand-700 rounded-sm grid place-items-center font-semibold">{{ strtoupper(substr($u->name,0,1)) }}</div>
              <div>
                <div class="font-medium">{{ $u->name }}</div>
                <div class="text-xs text-gray-500">{{ $u->email }}</div>
              </div>
            </td>
            <td class="px-4 py-2"><span class="px-2 py-0.5 rounded-sm text-xs capitalize {{ $tone }}">{{ $u->role }}</span></td>
            <td class="px-4 py-2 text-gray-600">{{ $u->phone ?? '—' }}</td>
            <td class="px-4 py-2 text-gray-500">{{ $u->created_at?->format('M j, Y') }}</td>
            <td class="px-4 py-2 text-right"><a href="{{ route('admin.users.edit', $u) }}" class="inline-flex items-center gap-1 text-brand-700 hover:underline"><x-icon name="edit" :size="13" /> Edit</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="mt-3">{{ $users->withQueryString()->links() }}</div>
@endsection
