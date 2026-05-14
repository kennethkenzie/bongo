@extends('admin.layout', ['title' => 'Warranty', 'subtitle' => 'Define warranty policies and product-level warranty options.'])
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
  @foreach(['No warranty','7 day replacement','1 year warranty'] as $warranty)
    <div class="bg-white rounded-sm border border-line p-5 shadow-admin"><div class="w-10 h-10 bg-brand-50 text-brand-700 grid place-items-center rounded-sm mb-3"><x-icon name="shield-check" :size="20" /></div><h2 class="font-bold">{{ $warranty }}</h2><p class="text-sm text-gray-500 mt-2">Warranty policy card prepared for product assignment.</p></div>
  @endforeach
</div>
@endsection
