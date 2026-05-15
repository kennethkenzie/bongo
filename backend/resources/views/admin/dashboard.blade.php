@extends('admin.layout', ['title' => 'Commerce Overview', 'subtitle' => "Welcome back, ".auth()->user()->name." — here is today’s marketplace pulse."])

@section('content')
@php
  $stats = [
    ['Revenue today', '$'.number_format($todayRevenue, 2), 'chart-bar', 'bg-brand-50 text-brand-700', 'Month: $'.number_format($monthRevenue, 2)],
    ['Orders', number_format($orderCount), 'receipt', 'bg-amber-50 text-amber-700', number_format($pendingOrders).' pending'],
    ['Products', number_format($productCount), 'cube', 'bg-emerald-50 text-emerald-700', number_format($activeProducts).' active'],
    ['Users', number_format($userCount), 'users', 'bg-rose-50 text-rose-700', number_format($adminCount).' staff accounts'],
  ];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
  @foreach ($stats as [$label, $value, $icon, $tone, $hint])
    <div class="bg-white rounded-sm border border-line p-4 shadow-admin">
      <div class="flex items-start justify-between gap-3">
        <div>
          <div class="text-xs text-gray-500">{{ $label }}</div>
          <div class="text-2xl font-extrabold mt-1">{{ $value }}</div>
          <div class="text-[11px] text-gray-400 mt-1">{{ $hint }}</div>
        </div>
        <div class="w-10 h-10 grid place-items-center rounded-sm {{ $tone }}">
          <x-icon :name="$icon" :size="20" />
        </div>
      </div>
    </div>
  @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-3 mt-4">
  <div class="xl:col-span-2 bg-white rounded-sm border border-line shadow-admin">
    <div class="px-4 py-3 border-b border-line flex items-center justify-between">
      <div>
        <h2 class="font-bold">Recent Orders</h2>
        <p class="text-xs text-gray-500">Latest checkout activity and fulfillment state.</p>
      </div>
      <a href="{{ route('admin.orders.index') }}" class="text-brand-700 text-sm hover:underline inline-flex items-center gap-1">
        Manage orders <x-icon name="arrow-right" :size="13" />
      </a>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-surface text-gray-500 text-xs uppercase">
          <tr>
            <th class="text-left px-4 py-2">Order #</th>
            <th class="text-left px-4 py-2">Customer</th>
            <th class="text-left px-4 py-2">Total</th>
            <th class="text-left px-4 py-2">Status</th>
            <th class="text-left px-4 py-2">Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($recentOrders as $o)
            <tr class="border-t border-line hover:bg-surface/70">
              <td class="px-4 py-2 font-mono text-brand-700">{{ $o->order_number }}</td>
              <td class="px-4 py-2">{{ optional($o->user)->name ?? '—' }}</td>
              <td class="px-4 py-2 font-semibold">${{ number_format($o->total, 2) }}</td>
              <td class="px-4 py-2"><span class="px-2 py-0.5 bg-brand-50 text-brand-700 rounded-sm text-xs capitalize">{{ $o->status }}</span></td>
              <td class="px-4 py-2 text-gray-500">{{ $o->created_at?->diffForHumans() }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No orders yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="bg-white rounded-sm border border-line shadow-admin">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Order pipeline</h2>
      <p class="text-xs text-gray-500">Status breakdown for quick triage.</p>
    </div>
    <div class="p-4 space-y-3">
      @foreach (['pending','paid','processing','shipped','delivered','cancelled'] as $status)
        @php $count = (int) ($statusCounts[$status] ?? 0); $pct = $orderCount ? min(100, round(($count / $orderCount) * 100)) : 0; @endphp
        <a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="block group">
          <div class="flex items-center justify-between text-sm mb-1">
            <span class="capitalize group-hover:text-brand-700">{{ $status }}</span>
            <span class="font-semibold">{{ number_format($count) }}</span>
          </div>
          <div class="h-2 bg-surface rounded-sm overflow-hidden">
            <div class="h-full bg-brand-600" style="width: {{ $pct }}%"></div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-4">
  <div class="bg-white rounded-sm border border-line shadow-admin">
    <div class="px-4 py-3 border-b border-line flex items-center justify-between">
      <h2 class="font-bold">Top products</h2>
      <a href="{{ route('admin.products.index') }}" class="text-xs text-brand-700 hover:underline">View catalog</a>
    </div>
    <ul class="divide-y divide-line">
      @foreach ($topProducts as $p)
        <li class="px-4 py-2.5 flex items-center gap-3">
          <img src="{{ $p->image }}" alt="" class="w-10 h-10 rounded-sm object-cover border border-line" />
          <div class="flex-1 min-w-0">
            <div class="text-sm line-clamp-1">{{ $p->title }}</div>
            <div class="text-xs text-gray-500">${{ number_format($p->price, 2) }} · {{ number_format($p->sold) }} sold</div>
          </div>
        </li>
      @endforeach
    </ul>
  </div>

  <div class="bg-white rounded-sm border border-line shadow-admin">
    <div class="px-4 py-3 border-b border-line flex items-center justify-between">
      <h2 class="font-bold">Low stock alerts</h2>
      <a href="{{ route('admin.products.index', ['status' => 'low_stock']) }}" class="text-xs text-brand-700 hover:underline">Restock</a>
    </div>
    <ul class="divide-y divide-line">
      @forelse ($lowStockProducts as $p)
        <li class="px-4 py-2.5 flex items-center gap-3">
          <img src="{{ $p->image }}" alt="" class="w-10 h-10 rounded-sm object-cover border border-line" />
          <div class="flex-1 min-w-0">
            <div class="text-sm line-clamp-1">{{ $p->title }}</div>
            <div class="text-xs text-gray-500">{{ optional($p->category)->name ?? 'Uncategorized' }}</div>
          </div>
          <span class="px-2 py-0.5 bg-red-50 text-red-700 rounded-sm text-xs">{{ $p->stock }} left</span>
        </li>
      @empty
        <li class="px-4 py-8 text-center text-gray-400 text-sm">No low stock products.</li>
      @endforelse
    </ul>
  </div>

  <div class="bg-white rounded-sm border border-line shadow-admin overflow-hidden">
    <div class="px-4 py-3 border-b border-line">
      <h2 class="font-bold">Category mix</h2>
      <p class="text-xs text-gray-500">Product distribution across all levels.</p>
    </div>
    <div class="p-4 space-y-2 max-h-80 overflow-y-auto">
      @forelse ($categoryMix as $cat)
        {{-- Root --}}
        @php $pct = $productCount ? min(100, round(($cat->products_count / $productCount) * 100)) : 0; @endphp
        <div>
          <div class="flex items-center justify-between text-sm mb-1">
            <span class="font-semibold">{{ $cat->name }}</span>
            <span class="text-gray-500 text-xs">{{ $cat->products_count }}</span>
          </div>
          <div class="h-1.5 bg-surface rounded-sm overflow-hidden">
            <div class="h-full bg-emerald-500" style="width: {{ $pct }}%"></div>
          </div>
        </div>

        @foreach ($cat->children as $sub)
          {{-- Sub-category --}}
          @php $pct2 = $productCount ? min(100, round(($sub->products_count / $productCount) * 100)) : 0; @endphp
          <div class="pl-4">
            <div class="flex items-center justify-between text-sm mb-1">
              <span class="text-gray-700">- {{ $sub->name }}</span>
              <span class="text-gray-400 text-xs">{{ $sub->products_count }}</span>
            </div>
            <div class="h-1.5 bg-surface rounded-sm overflow-hidden">
              <div class="h-full bg-emerald-400" style="width: {{ $pct2 }}%"></div>
            </div>
          </div>

          @foreach ($sub->children as $grand)
            {{-- Sub-sub-category --}}
            @php $pct3 = $productCount ? min(100, round(($grand->products_count / $productCount) * 100)) : 0; @endphp
            <div class="pl-8">
              <div class="flex items-center justify-between text-sm mb-1">
                <span class="text-gray-500">-- {{ $grand->name }}</span>
                <span class="text-gray-400 text-xs">{{ $grand->products_count }}</span>
              </div>
              <div class="h-1.5 bg-surface rounded-sm overflow-hidden">
                <div class="h-full bg-emerald-300" style="width: {{ $pct3 }}%"></div>
              </div>
            </div>
          @endforeach
        @endforeach
      @empty
        <p class="text-sm text-gray-400 text-center py-4">No categories yet.</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
