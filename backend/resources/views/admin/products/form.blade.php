@php
  $isEdit = isset($product) && $product->exists;
  $title = $isEdit ? 'Edit Product' : 'New Product';
@endphp
@extends('admin.layout', ['title' => $title])

@section('content')
<form method="POST"
      action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
      class="bg-white rounded-sm border border-line p-6 max-w-3xl">
  @csrf
  @if ($isEdit) @method('PUT') @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Title</span>
      <input name="title" required value="{{ old('title', $product->title ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Category</span>
      <select name="category_id" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
        <option value="">— None —</option>
        @foreach ($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id ?? null) == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Badge</span>
      <input name="badge" value="{{ old('badge', $product->badge ?? '') }}"
        placeholder="Bestseller / Choice / New"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Price (USD)</span>
      <input name="price" type="number" step="0.01" min="0" required value="{{ old('price', $product->price ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Original price (USD)</span>
      <input name="original_price" type="number" step="0.01" min="0" value="{{ old('original_price', $product->original_price ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Discount (%)</span>
      <input name="discount" type="number" min="0" max="99" value="{{ old('discount', $product->discount ?? 0) }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Stock</span>
      <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Image URL</span>
      <input name="image" required value="{{ old('image', $product->image ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Description</span>
      <textarea name="description" rows="4"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">{{ old('description', $product->description ?? '') }}</textarea>
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Shipping label</span>
      <input name="shipping" value="{{ old('shipping', $product->shipping ?? 'Free shipping') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <div class="flex items-center gap-4 pt-5">
      <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="free_shipping" value="0">
        <input type="checkbox" name="free_shipping" value="1" class="accent-brand-600"
          @checked(old('free_shipping', $product->free_shipping ?? true))>
        Free shipping
      </label>
      <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" class="accent-brand-600"
          @checked(old('is_active', $product->is_active ?? true))>
        Active
      </label>
    </div>
  </div>

  <div class="flex items-center gap-2 mt-5">
    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">
      {{ $isEdit ? 'Save changes' : 'Create product' }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="border border-line px-4 py-2 rounded-sm text-sm hover:bg-surface">Cancel</a>
  </div>
</form>
@endsection
