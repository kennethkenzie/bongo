@extends('admin.layout', ['title' => 'Smart Bar', 'subtitle' => 'Configure product-page promo bars, urgency banners, and announcement strips.'])
@section('content')
@php
  $inputCls = 'mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600 text-sm';
  $styleCls = [
    'brand'   => 'bg-brand-600 text-white',
    'warning' => 'bg-amber-50 text-amber-800 border border-amber-100',
    'info'    => 'bg-blue-50 text-blue-800 border border-blue-100',
    'success' => 'bg-emerald-50 text-emerald-800 border border-emerald-100',
  ];
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

  <form method="POST" action="{{ route('admin.catalog.smart_bars.store') }}"
        class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-3">Add smart bar</h2>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Message</span>
      <input name="message" required value="{{ old('message') }}"
             placeholder="Flash Deal: Save up to 70% today" class="{{ $inputCls }}">
    </label>

    <label class="block mb-3">
      <span class="text-xs text-gray-500">CTA button text <span class="text-gray-400">(optional)</span></span>
      <input name="cta_text" value="{{ old('cta_text') }}" placeholder="Shop now" class="{{ $inputCls }}">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Style</span>
      <select name="style" class="{{ $inputCls }} bg-white">
        @foreach (['brand' => 'Brand (purple)', 'warning' => 'Warning (amber)', 'info' => 'Info (blue)', 'success' => 'Success (green)'] as $val => $label)
          <option value="{{ $val }}" @selected(old('style', 'brand') === $val)>{{ $label }}</option>
        @endforeach
      </select>
    </label>

    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold text-sm">Create smart bar</button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Smart bars</h2>
      <p class="text-xs text-gray-500">Live preview of configured bars.</p>
    </div>
    <div class="p-4 space-y-3">
      @forelse ($smartBars as $bar)
        <div class="flex items-center gap-3">
          <div class="flex-1 px-4 py-3 rounded-sm flex items-center justify-between {{ $styleCls[$bar->style] ?? $styleCls['brand'] }}">
            <span class="text-sm">{{ $bar->message }}</span>
            @if ($bar->cta_text)
              <span class="ml-3 px-3 py-1 rounded-sm text-xs
                {{ $bar->style === 'brand' ? 'bg-white/15' : 'bg-black/10' }}">{{ $bar->cta_text }}</span>
            @endif
          </div>
          <form method="POST" action="{{ route('admin.catalog.smart_bars.destroy', $bar) }}"
                onsubmit="return confirm('Delete this smart bar?')">
            @csrf @method('DELETE')
            <button class="text-xs text-gray-400 hover:text-red-500 shrink-0">Delete</button>
          </form>
        </div>
      @empty
        <p class="py-8 text-center text-gray-400 text-sm">No smart bars yet.</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
