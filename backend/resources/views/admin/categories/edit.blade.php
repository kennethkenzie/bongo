@extends('admin.layout', ['title' => 'Edit Category', 'subtitle' => 'Update category hierarchy, images, mega-menu JSON, and visibility.'])
@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="bg-white rounded-sm border border-line shadow-admin p-4 max-w-4xl text-sm">
  @csrf
  @method('PUT')

  <div class="flex items-start justify-between gap-3 border-b border-line pb-3 mb-4">
    <div>
      <h2 class="font-bold text-lg">{{ $category->name }}</h2>
      <p class="text-xs text-gray-500">Slug: <span class="font-mono">{{ $category->slug }}</span></p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-brand-700 hover:underline">Back to categories</a>
  </div>

  @if ($errors->any())
    <div class="mb-4 text-xs text-red-600 space-y-0.5 bg-red-50 border border-red-100 rounded-sm p-3">
      @foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <label class="block">
      <span class="text-xs text-gray-500">Category name</span>
      <input name="name" value="{{ old('name', $category->name) }}" required class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Parent category</span>
      <select name="parent_id" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
        <option value="">— None (root category) —</option>
        @foreach ($parentOptions as $opt)
          <option value="{{ $opt['id'] }}" @selected(old('parent_id', $category->parent_id) == $opt['id']) @if($opt['depth'] === 0) style="font-weight:600" @endif>
            {{ $opt['depth'] === 1 ? '- ' : '' }}{{ $opt['name'] }}
          </option>
        @endforeach
      </select>
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Sort order</span>
      <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="flex items-center gap-2 mt-6">
      <input type="checkbox" name="is_active" value="1" class="accent-brand-600" @checked(old('is_active', $category->is_active))>
      <span class="text-sm text-gray-700">Active</span>
    </label>

    <div class="md:col-span-2">
      <span class="text-xs text-gray-500">Category image</span>
      <div class="mt-1 flex items-center gap-3">
        @if ($category->image)
          <img src="{{ $category->image }}" alt="" class="w-16 h-16 rounded-sm object-cover border border-line">
        @else
          <div class="w-16 h-16 rounded-sm bg-brand-50 text-brand-700 grid place-items-center border border-line"><x-icon name="tag" :size="22" /></div>
        @endif
        <div class="flex-1">
          <input name="image_file" type="file" accept="image/*" class="block w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-sm file:border-0 file:bg-brand-600 file:text-white hover:file:bg-brand-700">
          <span class="block text-[11px] text-gray-400 mt-1">Leave empty to keep current image. JPG, PNG, WebP, or GIF up to 4 MB.</span>
        </div>
      </div>
    </div>

    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Mega-menu groups JSON</span>
      <textarea name="groups" rows="8" class="mt-1 w-full border border-line rounded-sm px-3 py-2 font-mono text-xs focus:outline-none focus:border-brand-600" placeholder='[{"title":"Clothing","links":["Dresses","Tops"]}]'>{{ old('groups', $category->groups ? json_encode($category->groups, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
      <span class="block text-[11px] text-gray-400 mt-1">Used by the frontend mega menu for root categories. Optional for subcategories.</span>
    </label>

    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Featured tiles JSON</span>
      <textarea name="featured" rows="6" class="mt-1 w-full border border-line rounded-sm px-3 py-2 font-mono text-xs focus:outline-none focus:border-brand-600" placeholder='[{"title":"Summer Deals","image":"/storage/categories/example.jpg","href":"/category/example"}]'>{{ old('featured', $category->featured ? json_encode($category->featured, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
      <span class="block text-[11px] text-gray-400 mt-1">Used by the right rail of the frontend mega menu. Optional.</span>
    </label>
  </div>

  <div class="mt-5 flex items-center gap-2">
    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">Save category</button>
    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded-sm border border-line text-gray-700 hover:bg-surface">Cancel</a>
  </div>
</form>
@endsection
