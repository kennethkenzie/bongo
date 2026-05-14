@extends('admin.layout', ['title' => 'Colors', 'subtitle' => 'Manage product color swatches and naming.'])
@section('content')
<div class="bg-white rounded-sm border border-line p-5 shadow-admin">
  <div class="flex items-center justify-between border-b border-line pb-3 mb-4"><div><h2 class="font-bold">Color swatches</h2><p class="text-xs text-gray-500">Standardize product color options.</p></div><button disabled class="bg-brand-600/50 text-white px-3 py-2 rounded-sm text-sm cursor-not-allowed">Add color</button></div>
  <div class="grid grid-cols-2 md:grid-cols-6 gap-3 text-sm">
    @foreach([['Black','#111827'],['White','#ffffff'],['Purple','#7c2ae8'],['Red','#ef4444'],['Blue','#2563eb'],['Green','#16a34a']] as [$name,$hex])
      <div class="border border-line rounded-sm p-3"><div class="h-12 border border-line rounded-sm" style="background: {{ $hex }}"></div><div class="font-semibold mt-2">{{ $name }}</div><div class="text-xs text-gray-500">{{ $hex }}</div></div>
    @endforeach
  </div>
</div>
@endsection
