@extends('admin.layout', ['title' => $section['label'], 'subtitle' => $section['description']])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line flex items-start justify-between gap-3">
      <div>
        <h2 class="font-bold">{{ $section['label'] }}</h2>
        <p class="text-xs text-gray-500">{{ $section['description'] }}</p>
      </div>
      <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">Configuration</span>
    </div>

    <form class="p-4 space-y-4 text-sm">
      @foreach($section['fields'] as [$label, $value])
        <label class="block">
          <span class="text-xs text-gray-500">{{ $label }}</span>
          <input value="{{ $value }}" disabled
            class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface text-gray-600 focus:outline-none">
        </label>
      @endforeach

      <div class="flex items-center gap-2 pt-2 border-t border-line">
        <button type="button" disabled class="bg-brand-600/50 text-white px-4 py-2 rounded-sm text-sm font-semibold cursor-not-allowed">
          Save changes
        </button>
        <span class="text-xs text-gray-500">UI placeholder — persistence can be wired to database settings next.</span>
      </div>
    </form>
  </div>

  <div class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit">
    <h2 class="font-bold mb-1">Settings sections</h2>
    <p class="text-xs text-gray-500 mb-3">Jump to another configuration group.</p>
    <div class="space-y-1 text-sm">
      @foreach($sections as $key => $item)
        <a href="{{ route('admin.settings.show', $key) }}"
           class="block px-3 py-2 rounded-sm {{ $slug === $key ? 'bg-brand-600 text-white' : 'text-gray-700 hover:bg-brand-50 hover:text-brand-700' }}">
          {{ $item['label'] }}
        </a>
      @endforeach
    </div>
  </div>
</div>
@endsection
