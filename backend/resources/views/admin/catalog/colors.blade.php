@extends('admin.layout', ['title' => 'Colors', 'subtitle' => 'Manage product color swatches and naming.'])
@section('content')
@php $inputCls = 'mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600 text-sm'; @endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

  <form method="POST" action="{{ route('admin.catalog.colors.store') }}"
        class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-3">Add color</h2>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Color name</span>
      <input name="name" required value="{{ old('name') }}" placeholder="e.g. Midnight Black" class="{{ $inputCls }}">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Hex value</span>
      <div class="mt-1 flex items-center gap-2">
        <input type="color" id="hexPicker" value="{{ old('hex', '#000000') }}"
               class="h-9 w-12 border border-line rounded-sm cursor-pointer p-0.5">
        <input name="hex" id="hexText" required value="{{ old('hex', '#000000') }}"
               placeholder="#000000" maxlength="7"
               class="flex-1 border border-line rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-600 font-mono">
      </div>
    </label>

    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold text-sm">Add color</button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Color swatches</h2>
      <p class="text-xs text-gray-500">Standardize product color options.</p>
    </div>
    <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-3">
      @forelse ($colors as $color)
        <div class="border border-line rounded-sm p-3 flex items-start justify-between gap-2">
          <div>
            <div class="h-10 w-10 border border-line rounded-sm mb-2" style="background:{{ $color->hex }}"></div>
            <div class="font-semibold text-sm">{{ $color->name }}</div>
            <div class="text-xs text-gray-500 font-mono">{{ $color->hex }}</div>
          </div>
          <form method="POST" action="{{ route('admin.catalog.colors.destroy', $color) }}"
                onsubmit="return confirm('Delete {{ addslashes($color->name) }}?')">
            @csrf @method('DELETE')
            <button class="text-xs text-gray-400 hover:text-red-500 shrink-0">×</button>
          </form>
        </div>
      @empty
        <p class="col-span-3 py-8 text-center text-gray-400 text-sm">No colors yet.</p>
      @endforelse
    </div>
  </div>
</div>

<script>
  (function () {
    const picker = document.getElementById('hexPicker');
    const text   = document.getElementById('hexText');
    picker.addEventListener('input', () => { text.value = picker.value; });
    text.addEventListener('input', () => {
      if (/^#[0-9a-fA-F]{6}$/.test(text.value)) picker.value = text.value;
    });
  })();
</script>
@endsection
