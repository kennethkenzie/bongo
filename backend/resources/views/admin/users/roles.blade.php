@extends('admin.layout', ['title' => 'Roles & Permissions', 'subtitle' => 'Understand what each account type can do.'])
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
  @foreach($roles as $key => $label)
    @php
      $tone = match($key) {
        'admin' => 'bg-brand-50 text-brand-700 border-brand-100',
        'manager' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'support' => 'bg-amber-50 text-amber-700 border-amber-100',
        default => 'bg-gray-50 text-gray-700 border-gray-200',
      };
    @endphp
    <div class="bg-white rounded-sm border border-line p-5 shadow-admin">
      <div class="w-10 h-10 rounded-sm grid place-items-center border {{ $tone }} mb-3"><x-icon name="shield-check" :size="20" /></div>
      <h2 class="font-bold">{{ $label }}</h2>
      <p class="text-xs text-gray-500 uppercase tracking-wider mt-0.5">{{ $key }}</p>
      <ul class="mt-4 space-y-2 text-sm text-gray-600">
        @foreach($permissions[$key] ?? [] as $item)
          <li class="flex items-start gap-2"><x-icon name="check-circle" :size="14" class="text-emerald-600 mt-0.5" /> {{ $item }}</li>
        @endforeach
      </ul>
    </div>
  @endforeach
</div>
@endsection
