@extends('admin.layout', ['title' => 'Custom Label', 'subtitle' => 'Create labels such as Choice, Bestseller, New Arrival, and Sale.'])
@section('content')
<div class="bg-white rounded-sm border border-line p-5 shadow-admin">
  <div class="flex items-center justify-between border-b border-line pb-3 mb-4"><div><h2 class="font-bold">Product labels</h2><p class="text-xs text-gray-500">Use labels to merchandise products across cards and listings.</p></div><button disabled class="bg-brand-600/50 text-white px-3 py-2 rounded-sm text-sm cursor-not-allowed">Add label</button></div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-sm">
    @foreach(['Choice','Bestseller','New Arrival','Limited Deal'] as $label)
      <div class="border border-line rounded-sm p-4"><span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">{{ $label }}</span><p class="text-xs text-gray-500 mt-3">Label preview</p></div>
    @endforeach
  </div>
</div>
@endsection
