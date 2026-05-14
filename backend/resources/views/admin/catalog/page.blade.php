@extends('admin.layout', ['title' => $page[0], 'subtitle' => $page[1]])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 space-y-3">
    <div class="bg-white rounded-sm border border-line p-5 shadow-admin">
      <div class="flex items-start justify-between gap-3 border-b border-line pb-4 mb-4">
        <div>
          <h2 class="font-bold">{{ $page[0] }}</h2>
          <p class="text-sm text-gray-500 mt-1">{{ $page[1] }}</p>
        </div>
        <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">Wired page</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="border border-line rounded-sm p-4 bg-surface/50">
          <div class="text-xs text-gray-500">Products</div>
          <div class="text-2xl font-extrabold">{{ number_format($productCount) }}</div>
        </div>
        <div class="border border-line rounded-sm p-4 bg-surface/50">
          <div class="text-xs text-gray-500">Active products</div>
          <div class="text-2xl font-extrabold">{{ number_format($activeProductCount) }}</div>
        </div>
        <div class="border border-line rounded-sm p-4 bg-surface/50">
          <div class="text-xs text-gray-500">Categories</div>
          <div class="text-2xl font-extrabold">{{ number_format($categoryCount) }}</div>
        </div>
      </div>
    </div>

    @if($slug === 'digital-products')
      <form class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        <h3 class="font-bold mb-3">Digital product details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Product title</span><input disabled placeholder="Digital download name" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
          <label class="block"><span class="text-xs text-gray-500">Price</span><input disabled placeholder="$0.00" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
          <label class="block"><span class="text-xs text-gray-500">License type</span><select disabled class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"><option>Single download</option></select></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Upload digital file</span><input disabled type="file" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
        </div>
        <button disabled class="mt-4 bg-brand-600/50 text-white px-4 py-2 rounded-sm font-semibold cursor-not-allowed">Create digital product</button>
      </form>
    @elseif($slug === 'bulk-import')
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        <h3 class="font-bold mb-2">Import products</h3>
        <p class="text-gray-500 mb-4">Upload CSV/XLS product files. Import persistence can be connected to a queued importer next.</p>
        <div class="border-2 border-dashed border-line rounded-sm p-8 text-center bg-surface/50">
          <x-icon name="archive-box" :size="34" class="text-brand-700 mx-auto mb-2" />
          <div class="font-semibold">Drop catalog file here</div>
          <div class="text-xs text-gray-500 mt-1">CSV, XLSX up to 20MB</div>
        </div>
      </div>
    @elseif($slug === 'bulk-export')
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        <h3 class="font-bold mb-3">Export catalog</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          @foreach(['All products CSV','Inventory XLSX','Category report'] as $export)
            <button disabled class="border border-line rounded-sm px-4 py-3 text-left hover:bg-surface cursor-not-allowed">
              <div class="font-semibold">{{ $export }}</div>
              <div class="text-xs text-gray-500 mt-1">Export action placeholder</div>
            </button>
          @endforeach
        </div>
      </div>
    @elseif($slug === 'reviews')
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
        <div class="px-4 py-3 border-b border-line"><h3 class="font-bold">Review moderation queue</h3></div>
        <table class="w-full text-sm"><tbody><tr><td class="px-4 py-10 text-center text-gray-400">No product reviews waiting for moderation.</td></tr></tbody></table>
      </div>
    @else
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
        <div class="px-4 py-3 border-b border-line flex items-center justify-between">
          <h3 class="font-bold">{{ $page[0] }} records</h3>
          <button disabled class="bg-brand-600/50 text-white px-3 py-2 rounded-sm text-sm font-semibold cursor-not-allowed">Add new</button>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-surface text-gray-500 text-xs uppercase"><tr><th class="text-left px-4 py-2">Name</th><th class="text-left px-4 py-2">Status</th><th class="text-left px-4 py-2">Updated</th></tr></thead>
            <tbody><tr><td colspan="3" class="px-4 py-10 text-center text-gray-400">No {{ strtolower($page[0]) }} records yet.</td></tr></tbody>
          </table>
        </div>
      </div>
    @endif

    @if(in_array($slug, ['in-house-products','seller-products']))
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
        <div class="px-4 py-3 border-b border-line"><h3 class="font-bold">Recent products</h3></div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-surface text-gray-500 text-xs uppercase"><tr><th class="text-left px-4 py-2">Product</th><th class="text-left px-4 py-2">Category</th><th class="text-left px-4 py-2">Price</th><th class="text-left px-4 py-2">Status</th></tr></thead>
            <tbody>
              @foreach($products as $product)
                <tr class="border-t border-line">
                  <td class="px-4 py-2 flex items-center gap-3"><img src="{{ $product->image }}" class="w-9 h-9 object-cover rounded-sm border border-line" alt=""><span class="line-clamp-1">{{ $product->title }}</span></td>
                  <td class="px-4 py-2 text-gray-600">{{ optional($product->category)->name ?? '—' }}</td>
                  <td class="px-4 py-2 font-semibold">${{ number_format($product->price, 2) }}</td>
                  <td class="px-4 py-2"><span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-sm text-xs">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  </div>

  <div class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit">
    <h2 class="font-bold mb-1">Product pages</h2>
    <p class="text-xs text-gray-500 mb-3">Every item in the Products dropdown is wired.</p>
    <div class="space-y-1 text-sm">
      <a href="{{ route('admin.products.create') }}" class="block px-3 py-2 rounded-sm text-gray-700 hover:bg-brand-50 hover:text-brand-700">Add New Product</a>
      <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-sm text-gray-700 hover:bg-brand-50 hover:text-brand-700">All products</a>
      @foreach($pages as $key => $item)
        <a href="{{ route($item[2]) }}" class="block px-3 py-2 rounded-sm {{ $slug === $key ? 'bg-brand-600 text-white' : 'text-gray-700 hover:bg-brand-50 hover:text-brand-700' }}">{{ $item[0] }}</a>
      @endforeach
      <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-sm text-gray-700 hover:bg-brand-50 hover:text-brand-700">Category</a>
    </div>
  </div>
</div>
@endsection
