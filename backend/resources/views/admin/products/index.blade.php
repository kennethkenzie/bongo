@extends('admin.layout', ['title' => 'Product Management', 'subtitle' => 'Control catalog visibility, pricing, stock, and merchandising.'])

@section('content')
<div class="bg-white rounded-sm border border-line p-4 mb-3 shadow-admin">
  <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-2 text-sm">
    <div class="relative md:col-span-2">
      <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="search" :size="15" /></span>
      <input name="q" value="{{ request('q') }}" placeholder="Search product title…"
        class="border border-line rounded-sm pl-8 pr-3 py-2 focus:outline-none focus:border-brand-600 w-full">
    </div>
    <select name="category_id" class="border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
      <option value="">All categories</option>
      @foreach ($categories as $c)
        <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
    <select name="status" class="border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
      <option value="">All status</option>
      <option value="active" @selected(request('status') === 'active')>Active</option>
      <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
      <option value="low_stock" @selected(request('status') === 'low_stock')>Low stock</option>
    </select>
    <div class="flex gap-2">
      <button class="inline-flex flex-1 items-center justify-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-3 py-2 rounded-sm font-semibold">
        <x-icon name="search" :size="14" /> Filter
      </button>
      <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-1 border border-brand-600 text-brand-700 px-3 py-2 rounded-sm font-semibold hover:bg-brand-50">
        <x-icon name="plus" :size="14" /> New
      </a>
    </div>
  </form>
</div>

<div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
  <div class="px-4 py-3 border-b border-line flex items-center justify-between">
    <div>
      <h2 class="font-bold">Catalog products</h2>
      <p class="text-xs text-gray-500">{{ number_format($products->total()) }} products match your filters.</p>
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-surface text-gray-500 text-xs uppercase">
        <tr>
          <th class="text-left px-4 py-2">Product</th>
          <th class="text-left px-4 py-2">Category</th>
          <th class="text-left px-4 py-2">Price</th>
          <th class="text-left px-4 py-2">Stock</th>
          <th class="text-left px-4 py-2">Sold</th>
          <th class="text-left px-4 py-2">Status</th>
          <th class="px-4 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($products as $p)
          <tr class="border-t border-line hover:bg-surface/70">
            <td class="px-4 py-2 flex items-center gap-3 min-w-[320px]">
              <img src="{{ $p->image }}" alt="" class="w-11 h-11 rounded-sm object-cover border border-line">
              <div>
                <div class="line-clamp-1 max-w-[360px] font-medium">{{ $p->title }}</div>
                <div class="text-xs text-gray-500 font-mono">#{{ $p->id }} · {{ $p->slug }}</div>
              </div>
            </td>
            <td class="px-4 py-2 text-gray-600">{{ optional($p->category)->name ?? '—' }}</td>
            <td class="px-4 py-2">
              <div class="font-semibold text-deal">${{ number_format($p->price, 2) }}</div>
              @if($p->original_price)<div class="text-xs text-gray-400 line-through">${{ number_format($p->original_price, 2) }}</div>@endif
            </td>
            <td class="px-4 py-2">
              <span class="{{ $p->stock <= 15 ? 'text-red-700 font-semibold' : '' }}">{{ number_format($p->stock) }}</span>
            </td>
            <td class="px-4 py-2 text-gray-600">{{ number_format($p->sold) }}</td>
            <td class="px-4 py-2">
              @if ($p->is_active)
                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-sm text-xs">Active</span>
              @else
                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-sm text-xs">Inactive</span>
              @endif
              @if($p->stock <= 15)<span class="ml-1 px-2 py-0.5 bg-red-50 text-red-700 rounded-sm text-xs">Low stock</span>@endif
            </td>
            <td class="px-4 py-2 text-right whitespace-nowrap">
              <a href="{{ route('admin.products.edit', $p) }}" class="text-brand-700 hover:underline inline-flex items-center gap-1">
                <x-icon name="edit" :size="13" /> Edit
              </a>
              <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="inline ml-2" onsubmit="return confirm('Delete this product?')">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline inline-flex items-center gap-1">
                  <x-icon name="trash" :size="13" /> Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No products found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  {{ $products->withQueryString()->links() }}
</div>
@endsection
