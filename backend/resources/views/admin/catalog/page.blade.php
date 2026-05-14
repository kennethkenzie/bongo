@extends('admin.layout', ['title' => $page[0], 'subtitle' => $page[1]])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 bg-white rounded-sm border border-line p-5 shadow-admin">
    <div class="flex items-start justify-between gap-3 border-b border-line pb-4 mb-4">
      <div>
        <h2 class="font-bold">{{ $page[0] }}</h2>
        <p class="text-sm text-gray-500 mt-1">{{ $page[1] }}</p>
      </div>
      <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">Catalog module</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
      <div class="border border-line rounded-sm p-4 bg-surface/50">
        <div class="text-xs text-gray-500">Products</div>
        <div class="text-2xl font-extrabold">{{ number_format($productCount) }}</div>
      </div>
      <div class="border border-line rounded-sm p-4 bg-surface/50">
        <div class="text-xs text-gray-500">Categories</div>
        <div class="text-2xl font-extrabold">{{ number_format($categoryCount) }}</div>
      </div>
      <div class="border border-line rounded-sm p-4 bg-surface/50">
        <div class="text-xs text-gray-500">Status</div>
        <div class="text-2xl font-extrabold text-brand-700">Ready</div>
      </div>
    </div>

    <div class="border border-dashed border-line rounded-sm p-5 text-sm text-gray-600">
      This page is prepared for <strong>{{ $page[0] }}</strong>. The navigation and page shell are ready; persistence and module-specific forms can be wired next.
    </div>

    <div class="flex items-center gap-2 mt-5">
      <a href="{{ route('admin.products.index') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">Go to products</a>
      <a href="{{ route('admin.categories.index') }}" class="border border-line px-4 py-2 rounded-sm text-sm hover:bg-surface">Go to categories</a>
    </div>
  </div>

  <div class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit">
    <h2 class="font-bold mb-1">Product menus</h2>
    <p class="text-xs text-gray-500 mb-3">Jump to another catalog function.</p>
    <div class="space-y-1 text-sm">
      <a href="{{ route('admin.products.create') }}" class="block px-3 py-2 rounded-sm text-gray-700 hover:bg-brand-50 hover:text-brand-700">Add New Product</a>
      <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-sm text-gray-700 hover:bg-brand-50 hover:text-brand-700">All products</a>
      @foreach($pages as $key => $item)
        <a href="{{ route('admin.catalog.show', $key) }}" class="block px-3 py-2 rounded-sm {{ $slug === $key ? 'bg-brand-600 text-white' : 'text-gray-700 hover:bg-brand-50 hover:text-brand-700' }}">{{ $item[0] }}</a>
      @endforeach
      <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-sm text-gray-700 hover:bg-brand-50 hover:text-brand-700">Category</a>
    </div>
  </div>
</div>
@endsection
