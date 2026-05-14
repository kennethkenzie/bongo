@extends('admin.layout', ['title' => $title, 'subtitle' => $subtitle])
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
  <div class="bg-white rounded-sm border border-line p-4 shadow-admin"><div class="text-xs text-gray-500">Orders</div><div class="text-2xl font-extrabold">{{ number_format($orders->total()) }}</div></div>
  <div class="bg-white rounded-sm border border-line p-4 shadow-admin"><div class="text-xs text-gray-500">Pending</div><div class="text-2xl font-extrabold">{{ $orders->where('status','pending')->count() }}</div></div>
  <div class="bg-white rounded-sm border border-line p-4 shadow-admin"><div class="text-xs text-gray-500">Processing</div><div class="text-2xl font-extrabold">{{ $orders->where('status','processing')->count() }}</div></div>
  <div class="bg-white rounded-sm border border-line p-4 shadow-admin"><div class="text-xs text-gray-500">Segment</div><div class="text-lg font-extrabold text-brand-700 capitalize">{{ str_replace('-', ' ', $type) }}</div></div>
</div>

<div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
  <div class="px-4 py-3 border-b border-line flex items-center justify-between">
    <div><h2 class="font-bold">{{ $title }}</h2><p class="text-xs text-gray-500">Dedicated order queue for this sales segment.</p></div>
    <a href="{{ route('admin.orders.index') }}" class="text-brand-700 text-sm hover:underline">All orders</a>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-surface text-gray-500 text-xs uppercase">
        <tr><th class="text-left px-4 py-2">Order #</th><th class="text-left px-4 py-2">Customer</th><th class="text-left px-4 py-2">Items</th><th class="text-left px-4 py-2">Total</th><th class="text-left px-4 py-2">Status</th><th class="text-left px-4 py-2">Date</th></tr>
      </thead>
      <tbody>
        @forelse($orders as $o)
          <tr class="border-t border-line hover:bg-surface/70">
            <td class="px-4 py-3 font-mono text-brand-700">{{ $o->order_number }}</td>
            <td class="px-4 py-3"><div>{{ optional($o->user)->name ?? '—' }}</div><div class="text-xs text-gray-500">{{ optional($o->user)->email }}</div></td>
            <td class="px-4 py-3">{{ $o->items->sum('quantity') }}</td>
            <td class="px-4 py-3 font-semibold">${{ number_format($o->total, 2) }}</td>
            <td class="px-4 py-3"><span class="px-2 py-0.5 bg-brand-50 text-brand-700 rounded-sm text-xs capitalize">{{ $o->status }}</span></td>
            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $o->created_at?->format('M j, Y H:i') }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">No {{ strtolower($title) }} yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
