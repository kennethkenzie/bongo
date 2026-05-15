@extends('admin.layout', ['title' => 'Size Guide', 'subtitle' => 'Create size charts for fashion, shoes, and apparel categories.'])
@section('content')
@php $inputCls = 'mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600 text-sm'; @endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

  <form method="POST" action="{{ route('admin.catalog.size_guides.store') }}"
        class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-3">New size guide</h2>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Guide name</span>
      <input name="name" required value="{{ old('name') }}" placeholder="e.g. Women's Apparel" class="{{ $inputCls }}">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Content</span>
      <textarea name="content" rows="8"
        placeholder="XS: Chest 32–34 in&#10;S: Chest 34–36 in&#10;M: Chest 36–38 in"
        class="{{ $inputCls }}">{{ old('content') }}</textarea>
    </label>

    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold text-sm">Create guide</button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Size guides</h2>
      <p class="text-xs text-gray-500">Attach guides to fashion and shoe categories.</p>
    </div>
    <table class="w-full text-sm">
      <thead class="bg-surface text-xs uppercase text-gray-500">
        <tr>
          <th class="text-left px-4 py-2">Guide</th>
          <th class="text-left px-4 py-2">Preview</th>
          <th class="px-4 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($sizeGuides as $guide)
          <tr class="border-t border-line hover:bg-surface/50">
            <td class="px-4 py-3 font-medium">{{ $guide->name }}</td>
            <td class="px-4 py-3 text-gray-500 text-xs max-w-xs truncate">{{ Str::limit($guide->content, 60) }}</td>
            <td class="px-4 py-3 text-right">
              <form method="POST" action="{{ route('admin.catalog.size_guides.destroy', $guide) }}"
                    onsubmit="return confirm('Delete {{ addslashes($guide->name) }}?')">
                @csrf @method('DELETE')
                <button class="text-xs text-gray-400 hover:text-red-500">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="px-4 py-10 text-center text-gray-400">No size guides yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
