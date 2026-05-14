@extends('admin.layout', ['title' => 'Order Management', 'subtitle' => 'Track fulfillment, payment state, and customer activity.'])
@section('content')
<div class="bg-white rounded-sm border border-line p-4 mb-3 shadow-admin">
  <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2 text-sm">
    <div class="relative md:col-span-2">
      <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="search" :size="15" /></span>
      <input name="q" value="{{ request('q') }}" placeholder="Search order #, customer…" class="border border-line rounded-sm pl-8 pr-3 py-2 w-full focus:outline-none focus:border-brand-600">
    </div>
    <select name="status" class="border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
      <option value="">All statuses</option>
      @foreach($statuses as $status)
        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
      @endforeach
    </select>
    <button class="inline-flex items-center justify-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-3 py-2 rounded-sm font-semibold"><x-icon name="search" :size="14" /> Filter orders</button>
  </form>
</div>

<div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
  <div class="px-4 py-3 border-b border-line">
    <h2 class="font-bold">Orders</h2>
    <p class="text-xs text-gray-500">{{ number_format($orders->total()) }} orders match your filters.</p>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-surface text-gray-500 text-xs uppercase">
        <tr>
          <th class="text-left px-4 py-2">Order #</th>
          <th class="text-left px-4 py-2">Customer</th>
          <th class="text-left px-4 py-2">Items</th>
          <th class="text-left px-4 py-2">Total</th>
          <th class="text-left px-4 py-2">Payment</th>
          <th class="text-left px-4 py-2">Status</th>
          <th class="text-left px-4 py-2">Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($orders as $o)
          <tr class="border-t border-line hover:bg-surface/70 align-top">
            <td class="px-4 py-3 font-mono text-brand-700">{{ $o->order_number }}</td>
            <td class="px-4 py-3">
              <div>{{ optional($o->user)->name ?? '—' }}</div>
              <div class="text-xs text-gray-500">{{ optional($o->user)->email }}</div>
            </td>
            <td class="px-4 py-3">{{ $o->items->sum('quantity') }}</td>
            <td class="px-4 py-3 font-semibold">${{ number_format($o->total, 2) }}</td>
            <td class="px-4 py-3 text-gray-600 capitalize">{{ $o->payment_method ?? '—' }}</td>
            <td class="px-4 py-3">
              <form method="POST" action="{{ route('admin.orders.status', $o) }}" class="flex items-center gap-1">
                @csrf @method('PATCH')
                <select name="status" class="border border-line rounded-sm px-2 py-1 text-xs bg-white focus:outline-none focus:border-brand-600" onchange="this.form.submit()">
                  @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected($o->status === $status)>{{ ucfirst($status) }}</option>
                  @endforeach
                </select>
              </form>
            </td>
            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $o->created_at?->format('M j, Y H:i') }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No orders yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="mt-3">{{ $orders->withQueryString()->links() }}</div>
@endsection
