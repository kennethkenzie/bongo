@extends('admin.layout', ['title' => 'Dashboard', 'subtitle' => "Welcome back, ".auth()->user()->name])

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
  @php
    $stats = [
      ['Products', $productCount,  '📦', 'bg-brand-600'],
      ['Categories', $categoryCount, '🏷️', 'bg-emerald-600'],
      ['Orders', $orderCount, '🧾', 'bg-amber-600'],
      ['Users', $userCount, '👥', 'bg-rose-600'],
    ];
  @endphp
  @foreach ($stats as [$label, $value, $emoji, $bg])
    <div class="bg-white rounded-sm border border-line p-4">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-xs text-gray-500">{{ $label }}</div>
          <div class="text-2xl font-extrabold">{{ number_format($value) }}</div>
        </div>
        <div class="w-10 h-10 grid place-items-center {{ $bg }} text-white rounded-sm">{{ $emoji }}</div>
      </div>
    </div>
  @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-4">
  <div class="lg:col-span-2 bg-white rounded-sm border border-line">
    <div class="px-4 py-3 border-b border-line flex items-center justify-between">
      <h2 class="font-bold">Recent Orders</h2>
      <a href="{{ route('admin.orders.index') }}" class="text-brand-700 text-sm hover:underline">View all →</a>
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
            <tr class="border-t border-line">
              <td class="px-4 py-2 font-mono text-brand-700">{{ $o->order_number }}</td>
              <td class="px-4 py-2">{{ optional($o->user)->name ?? '—' }}</td>
              <td class="px-4 py-2 font-semibold">${{ number_format($o->total, 2) }}</td>
              <td class="px-4 py-2"><span class="px-2 py-0.5 bg-brand-50 text-brand-700 rounded-sm text-xs">{{ $o->status }}</span></td>
              <td class="px-4 py-2 text-gray-500">{{ $o->created_at?->diffForHumans() }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">No orders yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="bg-white rounded-sm border border-line">
    <div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Top Products</h2></div>
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
</div>
@endsection
