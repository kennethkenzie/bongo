@extends('admin.layout', ['title' => 'Categories'])
@section('content')
<div class="flex items-center justify-end mb-3">
  <button onclick="document.getElementById('newCat').classList.toggle('hidden')"
    class="inline-flex items-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">
    <x-icon name="plus" :size="14" /> New category
  </button>
</div>

<form id="newCat" method="POST" action="{{ route('admin.categories.store') }}"
      class="hidden bg-white rounded-sm border border-line p-4 mb-3 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
  @csrf
  <input name="name" placeholder="Category name" required class="border border-line rounded-sm px-3 py-2">
  <input name="image" placeholder="Image URL" class="border border-line rounded-sm px-3 py-2">
  <button class="bg-brand-600 text-white rounded-sm">Create</button>
</form>

<div class="bg-white rounded-sm border border-line overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-surface text-gray-500 text-xs uppercase">
      <tr>
        <th class="text-left px-4 py-2">Category</th>
        <th class="text-left px-4 py-2">Slug</th>
        <th class="text-left px-4 py-2">Products</th>
        <th class="text-left px-4 py-2">Active</th>
        <th class="px-4 py-2"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $c)
        <tr class="border-t border-line">
          <td class="px-4 py-2 flex items-center gap-3">
            @if ($c->image)<img src="{{ $c->image }}" alt="" class="w-9 h-9 rounded-sm object-cover border border-line">@endif
            {{ $c->name }}
          </td>
          <td class="px-4 py-2 font-mono text-xs text-gray-500">{{ $c->slug }}</td>
          <td class="px-4 py-2">{{ $c->products_count }}</td>
          <td class="px-4 py-2">
            @if ($c->is_active)
              <span class="text-emerald-600 inline-flex items-center gap-1">
                <x-icon name="check-circle" :size="14" /> Active
              </span>
            @else
              <span class="text-gray-400">—</span>
            @endif
          </td>
          <td class="px-4 py-2 text-right">
            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Delete this category?')" class="inline">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline text-sm inline-flex items-center gap-1">
                <x-icon name="trash" :size="13" /> Delete
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
