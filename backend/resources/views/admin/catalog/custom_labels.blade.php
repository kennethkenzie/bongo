@extends('admin.layout', ['title' => 'Custom Label', 'subtitle' => 'Create labels such as Choice, Bestseller, New Arrival, and Sale.'])
@section('content')
@php $inputCls = 'mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600 text-sm'; @endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

  <form method="POST" action="{{ route('admin.catalog.labels.store') }}"
        class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-3">Add label</h2>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Label name</span>
      <input name="name" required value="{{ old('name') }}" placeholder="e.g. Bestseller" class="{{ $inputCls }}">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Color</span>
      <div class="mt-1 flex items-center gap-2">
        <input type="color" name="color" value="{{ old('color', '#7c2ae8') }}"
               class="h-9 w-12 border border-line rounded-sm cursor-pointer p-0.5">
        <span class="text-xs text-gray-400">Pick a badge color</span>
      </div>
    </label>

    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold text-sm">Create label</button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Product labels</h2>
      <p class="text-xs text-gray-500">Use labels to merchandise products across cards and listings.</p>
    </div>
    <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-3">
      @forelse ($labels as $label)
        <div class="border border-line rounded-sm p-4 flex items-start justify-between gap-2">
          <div>
            <span class="px-2 py-1 rounded-sm text-xs font-semibold text-white" style="background:{{ $label->color }}">{{ $label->name }}</span>
          </div>
          <form method="POST" action="{{ route('admin.catalog.labels.destroy', $label) }}"
                onsubmit="return confirm('Delete this label?')">
            @csrf @method('DELETE')
            <button class="text-xs text-gray-400 hover:text-red-500 shrink-0">×</button>
          </form>
        </div>
      @empty
        <p class="col-span-3 py-8 text-center text-gray-400 text-sm">No labels yet.</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
