@extends('admin.layout', ['title' => 'Products', 'subtitle' => 'Manage your product catalog'])

@section('content')
<div class="flex items-center justify-between mb-3">
  <form method="GET" class="flex items-center gap-2">
    <input name="q" value="{{ request('q') }}" placeholder="Search products…"
      class="border border-line rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-600 w-64">
    <button class="bg-brand-600 hover:bg-brand-700 text-white px-3 py-2 rounded-sm text-sm">Search</button>
  </form>
  <a href="{{ route('admin.products.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">+ New product</a>
</div>

<div class="bg-white rounded-sm border border-line overflow-hidden">
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
        <tr class="border-t border-line hover:bg-surface">
          <td class="px-4 py-2 flex items-center gap-3">
            <img src="{{ $p->image }}" alt="" class="w-10 h-10 rounded-sm object-cover border border-line">
            <div>
              <div class="line-clamp-1 max-w-[280px]">{{ $p->title }}</div>
              <div class="text-xs text-gray-500 font-mono">#{{ $p->id }}</div>
            </div>
          </td>
          <td class="px-4 py-2 text-gray-600">{{ optional($p->category)->name ?? '—' }}</td>
          <td class="px-4 py-2 font-semibold text-deal">${{ number_format($p->price, 2) }}</td>
          <td class="px-4 py-2">{{ number_format($p->stock) }}</td>
          <td class="px-4 py-2 text-gray-600">{{ number_format($p->sold) }}</td>
          <td class="px-4 py-2">
            @if ($p->is_active)
              <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-sm text-xs">Active</span>
            @else
              <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-sm text-xs">Inactive</span>
            @endif
          </td>
          <td class="px-4 py-2 text-right whitespace-nowrap">
            <a href="{{ route('admin.products.edit', $p) }}" class="text-brand-700 hover:underline">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="inline ml-2" onsubmit="return confirm('Delete this product?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No products found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-3">
  {{ $products->withQueryString()->links() }}
</div>
@endsection
