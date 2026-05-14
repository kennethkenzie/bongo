@extends('admin.layout', ['title' => $page[0], 'subtitle' => $page[1]])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 space-y-3">
    @if($slug === 'product')
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin">
        <div class="flex items-start justify-between gap-3 border-b border-line pb-4 mb-4">
          <div><h2 class="font-bold">AI product workspace</h2><p class="text-sm text-gray-500 mt-1">Draft or improve product content using AI prompts.</p></div>
          <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">AI Studio</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Product idea or existing product</span><input disabled placeholder="Wireless earbuds with noise cancellation..." class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
          <label class="block"><span class="text-xs text-gray-500">Tone</span><select disabled class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"><option>Marketplace optimized</option></select></label>
          <label class="block"><span class="text-xs text-gray-500">Output</span><select disabled class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"><option>Title + Description + Bullets</option></select></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Generated content</span><textarea disabled rows="7" placeholder="AI generated product copy will appear here." class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></textarea></label>
        </div>
        <button disabled class="mt-4 bg-brand-600/50 text-white px-4 py-2 rounded-sm text-sm font-semibold cursor-not-allowed">Generate with AI</button>
      </div>
    @elseif($slug === 'templates')
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
        <div class="px-4 py-3 border-b border-line flex items-center justify-between"><div><h2 class="font-bold">Prompt templates</h2><p class="text-xs text-gray-500">Reusable AI instructions for common admin tasks.</p></div><button disabled class="bg-brand-600/50 text-white px-3 py-2 rounded-sm text-sm cursor-not-allowed">New template</button></div>
        <table class="w-full text-sm"><thead class="bg-surface text-gray-500 text-xs uppercase"><tr><th class="text-left px-4 py-2">Template</th><th class="text-left px-4 py-2">Use case</th><th class="text-left px-4 py-2">Status</th></tr></thead><tbody>@foreach(['Product SEO Description','Flash Deal Copy','Review Reply'] as $template)<tr class="border-t border-line"><td class="px-4 py-3 font-semibold">{{ $template }}</td><td class="px-4 py-3 text-gray-600">Catalog automation</td><td class="px-4 py-3"><span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-sm text-xs">Ready</span></td></tr>@endforeach</tbody></table>
      </div>
    @elseif($slug === 'usage')
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @foreach([['Tokens this month','0'],['Estimated cost','$0.00'],['AI requests','0']] as [$label,$value])
          <div class="bg-white rounded-sm border border-line p-5 shadow-admin"><div class="text-xs text-gray-500">{{ $label }}</div><div class="text-2xl font-extrabold mt-1">{{ $value }}</div></div>
        @endforeach
      </div>
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin"><div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Recent AI activity</h2></div><table class="w-full text-sm"><tbody><tr><td class="px-4 py-10 text-center text-gray-400">No AI usage recorded yet.</td></tr></tbody></table></div>
    @else
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        <h2 class="font-bold mb-3">AI provider configuration</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label class="block"><span class="text-xs text-gray-500">Provider</span><select disabled class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"><option>OpenAI</option></select></label>
          <label class="block"><span class="text-xs text-gray-500">Model</span><input disabled value="gpt-4.1-mini" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">API key</span><input disabled placeholder="Stored in .env" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface"></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Safety instructions</span><textarea disabled rows="5" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface">Generate honest, marketplace-safe ecommerce content.</textarea></label>
        </div>
      </div>
    @endif
  </div>

  <div class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit">
    <h2 class="font-bold mb-1">AI Studio</h2>
    <p class="text-xs text-gray-500 mb-3">AI workflow pages.</p>
    <div class="space-y-1 text-sm">
      @foreach($pages as $key => $item)
        <a href="{{ route('admin.ai.'.$key) }}" class="block px-3 py-2 rounded-sm {{ $slug === $key ? 'bg-brand-600 text-white' : 'text-gray-700 hover:bg-brand-50 hover:text-brand-700' }}">{{ $item[0] }}</a>
      @endforeach
    </div>
  </div>
</div>
@endsection
