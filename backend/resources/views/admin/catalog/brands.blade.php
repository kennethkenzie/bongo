@extends('admin.layout', ['title' => 'Brand', 'subtitle' => 'Manage product brands and brand storefront metadata.'])
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
  <form method="POST" action="{{ route('admin.catalog.brands.store') }}" enctype="multipart/form-data" class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-1">Register brand</h2>
    <p class="text-xs text-gray-500 mb-3">A logo is required before a brand can be registered.</p>

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Brand name</span>
      <input name="name" value="{{ old('name') }}" required placeholder="e.g. Estate Choice" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Brand logo <span class="text-red-600">*</span></span>
      <input name="logo_file" type="file" accept="image/*" required class="mt-1 block w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-sm file:border-0 file:bg-brand-600 file:text-white hover:file:bg-brand-700">
      <span class="block text-[11px] text-gray-400 mt-1">Required. JPG, PNG, WebP, GIF, or SVG up to 4 MB.</span>
    </label>

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Website</span>
      <input name="website" value="{{ old('website') }}" placeholder="https://" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="inline-flex items-center gap-2 mb-4">
      <input type="hidden" name="is_active" value="0">
      <input type="checkbox" name="is_active" value="1" checked class="accent-brand-600"> Active
    </label>

    <button class="w-full bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">Create brand</button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Brands</h2>
      <p class="text-xs text-gray-500">Only brands with logos are accepted.</p>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-surface text-xs uppercase text-gray-500">
          <tr><th class="text-left px-4 py-2">Brand</th><th class="text-left px-4 py-2">Website</th><th class="text-left px-4 py-2">Status</th><th class="px-4 py-2"></th></tr>
        </thead>
        <tbody>
          @forelse($brands as $brand)
            <tr class="border-t border-line">
              <td class="px-4 py-2 flex items-center gap-3">
                <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain rounded-sm border border-line bg-white">
                <div><div class="font-semibold">{{ $brand->name }}</div><div class="text-xs text-gray-500">{{ $brand->slug }}</div></div>
              </td>
              <td class="px-4 py-2 text-gray-600">@if($brand->website)<a href="{{ $brand->website }}" target="_blank" class="text-brand-700 hover:underline">{{ $brand->website }}</a>@else — @endif</td>
              <td class="px-4 py-2"><span class="px-2 py-0.5 rounded-sm text-xs {{ $brand->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">{{ $brand->is_active ? 'Active' : 'Inactive' }}</span></td>
              <td class="px-4 py-2 text-right">
                <form method="POST" action="{{ route('admin.catalog.brands.destroy', $brand) }}" onsubmit="return confirm('Delete this brand?')">
                  @csrf @method('DELETE')
                  <button class="text-red-600 hover:underline inline-flex items-center gap-1"><x-icon name="trash" :size="13" /> Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="px-4 py-10 text-center text-gray-400">No brands yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $brands->links() }}</div>
  </div>
</div>
@endsection
