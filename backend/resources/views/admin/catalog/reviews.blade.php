@extends('admin.layout', ['title' => 'Product Reviews', 'subtitle' => 'Moderate customer product reviews and ratings.'])
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
  @foreach([['Pending',0],['Approved',0],['Flagged',0],['Average rating','—']] as [$label,$value])
    <div class="bg-white rounded-sm border border-line p-4 shadow-admin"><div class="text-xs text-gray-500">{{ $label }}</div><div class="text-2xl font-extrabold">{{ $value }}</div></div>
  @endforeach
</div>
<div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin"><div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Review moderation</h2></div><table class="w-full text-sm"><thead class="bg-surface text-xs uppercase text-gray-500"><tr><th class="text-left px-4 py-2">Product</th><th class="text-left px-4 py-2">Customer</th><th class="text-left px-4 py-2">Rating</th><th class="text-left px-4 py-2">Status</th></tr></thead><tbody><tr><td colspan="4" class="px-4 py-10 text-center text-gray-400">No reviews submitted yet.</td></tr></tbody></table></div>
@endsection
