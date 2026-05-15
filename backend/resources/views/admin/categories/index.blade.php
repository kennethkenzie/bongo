@extends('admin.layout', ['title' => 'Categories', 'subtitle' => 'Organize marketplace departments and category landing pages.'])
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
  <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit text-sm">
    @csrf
    <h2 class="font-bold mb-1">New category</h2>
    <p class="text-xs text-gray-500 mb-3">Add a new storefront category.</p>
    <label class="block mb-3">
      <span class="text-xs text-gray-500">Category name</span>
      <input name="name" placeholder="e.g. Phones & Telecom" required class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>
    <label class="block mb-3">
      <span class="text-xs text-gray-500">Category image</span>
      <input name="image_file" type="file" accept="image/*" class="mt-1 block w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-sm file:border-0 file:bg-brand-600 file:text-white hover:file:bg-brand-700">
      <span class="block text-[11px] text-gray-400 mt-1">Optional. JPG, PNG, WebP, or GIF up to 4 MB.</span>
    </label>
    <button class="w-full inline-flex items-center justify-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">
      <x-icon name="plus" :size="14" /> Create category
    </button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Category tree</h2>
      <p class="text-xs text-gray-500">Top-level marketplace categories and product counts.</p>
    </div>
    <div class="overflow-x-auto">
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
            <tr class="border-t border-line hover:bg-surface/70">
              <td class="px-4 py-2 flex items-center gap-3 min-w-[220px]">
                @if ($c->image)<img src="{{ $c->image }}" alt="" class="w-10 h-10 rounded-sm object-cover border border-line">@else <div class="w-10 h-10 rounded-sm bg-brand-50 text-brand-700 grid place-items-center"><x-icon name="tag" :size="17" /></div>@endif
                <div>
                  <div class="font-medium">{{ $c->name }}</div>
                  <div class="text-xs text-gray-500">Sort: {{ $c->sort_order ?? 0 }}</div>
                </div>
              </td>
              <td class="px-4 py-2 font-mono text-xs text-gray-500">{{ $c->slug }}</td>
              <td class="px-4 py-2">{{ $c->products_count }}</td>
              <td class="px-4 py-2">
                @if ($c->is_active)
                  <span class="text-emerald-600 inline-flex items-center gap-1"><x-icon name="check-circle" :size="14" /> Active</span>
                @else
                  <span class="text-gray-400">—</span>
                @endif
              </td>
              <td class="px-4 py-2 text-right">
                <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Delete this category? Products will become uncategorized only if your database allows it.')" class="inline">
                  @csrf @method('DELETE')
                  <button class="text-red-600 hover:underline text-sm inline-flex items-center gap-1"><x-icon name="trash" :size="13" /> Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
