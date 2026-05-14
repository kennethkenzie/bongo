@extends('admin.layout', ['title' => 'Settings', 'subtitle' => 'Store operations, integrations, and dashboard configuration.'])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Store settings</h2>
      <p class="text-xs text-gray-500">Key configuration values for this marketplace install.</p>
    </div>
    <div class="divide-y divide-line">
      @foreach($settings as [$label, $value, $help])
        <div class="px-4 py-3 grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
          <div class="font-semibold">{{ $label }}</div>
          <div class="md:col-span-2">
            <div class="font-mono text-xs bg-surface border border-line rounded-sm px-2 py-1 inline-block max-w-full break-all">{{ $value }}</div>
            <p class="text-xs text-gray-500 mt-1">{{ $help }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="space-y-3">
    <div class="bg-white rounded-sm border border-line p-5 shadow-admin">
      <div class="w-10 h-10 bg-brand-50 text-brand-700 rounded-sm grid place-items-center mb-3"><x-icon name="cog" :size="20" /></div>
      <h2 class="font-bold">Operational checklist</h2>
      <ul class="mt-3 space-y-2 text-sm text-gray-600">
        <li class="flex gap-2"><x-icon name="check-circle" :size="14" class="text-emerald-600 mt-0.5" /> Run <code class="text-xs bg-surface px-1">php artisan storage:link</code> for uploads.</li>
        <li class="flex gap-2"><x-icon name="check-circle" :size="14" class="text-emerald-600 mt-0.5" /> Keep <code class="text-xs bg-surface px-1">FRONTEND_URL</code> pointed at Next.js.</li>
        <li class="flex gap-2"><x-icon name="check-circle" :size="14" class="text-emerald-600 mt-0.5" /> Use Roles to control dashboard access.</li>
      </ul>
    </div>

    <div class="bg-white rounded-sm border border-line p-5 shadow-admin">
      <h2 class="font-bold">Quick settings links</h2>
      <div class="mt-3 grid gap-2 text-sm">
        @foreach($sections as $key => $item)
          <a href="{{ route('admin.settings.show', $key) }}" class="border border-line rounded-sm px-3 py-2 hover:bg-brand-50 hover:text-brand-700 inline-flex items-center justify-between">
            <span class="inline-flex items-center gap-2"><x-icon name="circle" :size="10" :stroke="2" /> {{ $item['label'] }}</span> <x-icon name="arrow-right" :size="13" />
          </a>
        @endforeach
        <a href="{{ route('admin.roles.index') }}" class="border border-line rounded-sm px-3 py-2 hover:bg-brand-50 hover:text-brand-700 inline-flex items-center justify-between">
          Roles & permissions <x-icon name="arrow-right" :size="13" />
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
