@extends('admin.layout', ['title' => 'Brand', 'subtitle' => 'Manage product brands and brand storefront metadata.'])
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
  <form class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    <h2 class="font-bold mb-3">Add brand</h2>
    <label class="block mb-3"><span class="text-xs text-gray-500">Brand name</span><input disabled placeholder="e.g. Estate Choice" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
    <label class="block mb-3"><span class="text-xs text-gray-500">Logo</span><input disabled type="file" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
    <label class="block mb-3"><span class="text-xs text-gray-500">Website</span><input disabled placeholder="https://" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
    <button disabled class="bg-brand-600/50 text-white px-4 py-2 rounded-sm font-semibold cursor-not-allowed">Create brand</button>
  </form>
  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Brands</h2><p class="text-xs text-gray-500">Brand records will appear here.</p></div>
    <table class="w-full text-sm"><thead class="bg-surface text-xs uppercase text-gray-500"><tr><th class="text-left px-4 py-2">Brand</th><th class="text-left px-4 py-2">Products</th><th class="text-left px-4 py-2">Status</th></tr></thead><tbody><tr><td colspan="3" class="px-4 py-10 text-center text-gray-400">No brands yet.</td></tr></tbody></table>
  </div>
</div>
@endsection
