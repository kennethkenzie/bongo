@extends('admin.layout', ['title' => 'Smart Bar', 'subtitle' => 'Configure product-page promo bars, urgency banners, and announcement strips.'])
@section('content')
<div class="bg-white rounded-sm border border-line p-5 shadow-admin">
  <h2 class="font-bold mb-3">Smart bar preview</h2>
  <div class="space-y-3">
    <div class="bg-brand-600 text-white px-4 py-3 rounded-sm flex items-center justify-between"><span>Flash Deal: Save up to 70% today</span><button class="bg-white/15 px-3 py-1 rounded-sm text-sm">Shop now</button></div>
    <div class="bg-amber-50 text-amber-800 border border-amber-100 px-4 py-3 rounded-sm">Free shipping on selected items this week.</div>
  </div>
</div>
@endsection
