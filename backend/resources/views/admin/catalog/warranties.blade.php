@extends('admin.layout', ['title' => 'Warranty', 'subtitle' => 'Define warranty policies and product-level warranty options.'])
@section('content')
@php $inputCls = 'mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600 text-sm'; @endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

  <form method="POST" action="{{ route('admin.catalog.warranties.store') }}"
        class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-3">Add warranty</h2>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Policy name</span>
      <input name="name" required value="{{ old('name') }}" placeholder="e.g. 1 year warranty" class="{{ $inputCls }}">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Description</span>
      <textarea name="description" rows="5"
        placeholder="Describe coverage, exclusions, and claim process..."
        class="{{ $inputCls }}">{{ old('description') }}</textarea>
    </label>

    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold text-sm">Create warranty</button>
  </form>

  <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-3 content-start">
    @forelse ($warranties as $warranty)
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin relative">
        <form method="POST" action="{{ route('admin.catalog.warranties.destroy', $warranty) }}"
              onsubmit="return confirm('Delete this warranty?')"
              class="absolute top-3 right-3">
          @csrf @method('DELETE')
          <button class="text-xs text-gray-400 hover:text-red-500">×</button>
        </form>
        <div class="w-10 h-10 bg-brand-50 text-brand-700 grid place-items-center rounded-sm mb-3">
          <x-icon name="shield-check" :size="20" />
        </div>
        <h2 class="font-bold text-sm">{{ $warranty->name }}</h2>
        @if ($warranty->description)
          <p class="text-sm text-gray-500 mt-2">{{ Str::limit($warranty->description, 100) }}</p>
        @endif
      </div>
    @empty
      <div class="md:col-span-2 bg-white rounded-sm border border-line p-10 text-center text-gray-400 text-sm shadow-admin">
        No warranties yet.
      </div>
    @endforelse
  </div>
</div>
@endsection
