@extends('admin.layout', ['title' => 'Categories', 'subtitle' => 'Organize marketplace departments and category landing pages.'])
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
  <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit text-sm">
    @csrf
    <h2 class="font-bold mb-1">New category</h2>
    <p class="text-xs text-gray-500 mb-3">Create a root category, mega-menu group, or subcategory.</p>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Category name</span>
      <input name="name" value="{{ old('name') }}" placeholder="e.g. Phones & Telecom" required class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Parent category</span>
      <select name="parent_id" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
        <option value="">— None (root category) —</option>
        @foreach ($parentOptions as $opt)
          <option value="{{ $opt['id'] }}" @selected(old('parent_id') == $opt['id']) @if($opt['depth'] === 0) style="font-weight:600" @endif>
            {{ $opt['depth'] === 1 ? '- ' : '' }}{{ $opt['name'] }}
          </option>
        @endforeach
      </select>
      <span class="block text-[11px] text-gray-400 mt-1">Select a root to create a mega-menu group, or a group to create a link-level subcategory.</span>
    </label>

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Sort order</span>
      <input name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Category image</span>
      <input name="image_file" type="file" accept="image/*" class="mt-1 block w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-sm file:border-0 file:bg-brand-600 file:text-white hover:file:bg-brand-700">
      <span class="block text-[11px] text-gray-400 mt-1">Optional. JPG, PNG, WebP, or GIF up to 4 MB.</span>
    </label>

    <label class="flex items-center gap-2 mb-4">
      <input type="checkbox" name="is_active" value="1" checked class="accent-brand-600">
      <span class="text-xs text-gray-600">Active</span>
    </label>

    <button class="w-full inline-flex items-center justify-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">
      <x-icon name="plus" :size="14" /> Create category
    </button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h2 class="font-bold">Category tree</h2>
        <p class="text-xs text-gray-500">Root categories, mega-menu groups, and link-level subcategories.</p>
      </div>
      <form method="POST" action="{{ route('admin.categories.sync_mega_menu') }}">
        @csrf
        <button class="inline-flex items-center gap-1 border border-brand-200 text-brand-700 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-sm text-xs font-semibold">
          Sync mega menu subcategories
        </button>
      </form>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-surface text-gray-500 text-xs uppercase">
          <tr>
            <th class="text-left px-4 py-2">Category</th>
            <th class="text-left px-4 py-2">Slug</th>
            <th class="text-left px-4 py-2">Products</th>
            <th class="text-left px-4 py-2">Status</th>
            <th class="px-4 py-2"></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($roots as $root)
            @include('admin.categories.partials.row', ['category' => $root, 'depth' => 0])
            @foreach ($root->children as $child)
              @include('admin.categories.partials.row', ['category' => $child, 'depth' => 1])
              @foreach ($child->children as $grandchild)
                @include('admin.categories.partials.row', ['category' => $grandchild, 'depth' => 2])
              @endforeach
            @endforeach
          @empty
            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">No categories yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
