@extends('admin.layout', ['title' => 'Size Guide', 'subtitle' => 'Create size charts for fashion, shoes, and apparel categories.'])
@section('content')
<div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
  <div class="px-4 py-3 border-b border-line flex items-center justify-between"><div><h2 class="font-bold">Size guides</h2><p class="text-xs text-gray-500">Attach guides to fashion and shoe categories.</p></div><button disabled class="bg-brand-600/50 text-white px-3 py-2 rounded-sm text-sm cursor-not-allowed">New guide</button></div>
  <table class="w-full text-sm"><thead class="bg-surface text-xs uppercase text-gray-500"><tr><th class="text-left px-4 py-2">Guide</th><th class="text-left px-4 py-2">Category</th><th class="text-left px-4 py-2">Rows</th></tr></thead><tbody><tr><td colspan="3" class="px-4 py-10 text-center text-gray-400">No size guides yet.</td></tr></tbody></table>
</div>
@endsection
