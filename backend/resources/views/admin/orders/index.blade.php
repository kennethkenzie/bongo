@extends('admin.layout', ['title' => 'Orders'])
@section('content')
<div class="bg-white rounded-sm border border-line overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-surface text-gray-500 text-xs uppercase">
      <tr>
        <th class="text-left px-4 py-2">Order #</th>
        <th class="text-left px-4 py-2">Customer</th>
        <th class="text-left px-4 py-2">Items</th>
        <th class="text-left px-4 py-2">Total</th>
        <th class="text-left px-4 py-2">Status</th>
        <th class="text-left px-4 py-2">Date</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($orders as $o)
        <tr class="border-t border-line">
          <td class="px-4 py-2 font-mono text-brand-700">{{ $o->order_number }}</td>
          <td class="px-4 py-2">{{ optional($o->user)->name ?? '—' }}</td>
          <td class="px-4 py-2">{{ $o->items->sum('quantity') }}</td>
          <td class="px-4 py-2 font-semibold">${{ number_format($o->total, 2) }}</td>
          <td class="px-4 py-2"><span class="px-2 py-0.5 bg-brand-50 text-brand-700 rounded-sm text-xs">{{ $o->status }}</span></td>
          <td class="px-4 py-2 text-gray-500">{{ $o->created_at?->format('M j, Y H:i') }}</td>
        </tr>
      @empty
        <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">No orders yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
