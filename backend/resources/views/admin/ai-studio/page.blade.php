@extends('admin.layout', ['title' => $page[0], 'subtitle' => $page[1]])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 space-y-3">
    @if($slug === 'product')
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @foreach([['Products optimized','0'],['Drafts generated','0'],['Avg. SEO score','—']] as [$label,$value])
          <div class="bg-white rounded-sm border border-line p-4 shadow-admin"><div class="text-xs text-gray-500">{{ $label }}</div><div class="text-2xl font-extrabold mt-1">{{ $value }}</div></div>
        @endforeach
      </div>
      <form method="POST" action="#" class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        @csrf
        <div class="flex items-start justify-between gap-3 border-b border-line pb-4 mb-4">
          <div><h2 class="font-bold">AI product workspace</h2><p class="text-sm text-gray-500 mt-1">Generate marketplace-ready product content, then copy it into your product form.</p></div>
          <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">Draft mode</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Product idea / existing product notes</span><textarea name="prompt" rows="4" placeholder="Example: Wireless earbuds with ANC, 30 hour battery, black, budget-friendly..." class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></textarea></label>
          <label class="block"><span class="text-xs text-gray-500">Category</span><select name="category" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600"><option>Consumer Electronics</option><option>Women's Fashion</option><option>Phones & Telecom</option><option>Home & Garden</option></select></label>
          <label class="block"><span class="text-xs text-gray-500">Tone</span><select name="tone" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600"><option>AliExpress-style marketplace</option><option>Premium and trustworthy</option><option>Short and conversion-focused</option></select></label>
          <label class="block"><span class="text-xs text-gray-500">Output type</span><select name="output" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600"><option>Title + bullets + description</option><option>SEO title only</option><option>Variant names</option><option>Shipping and warranty copy</option></select></label>
          <label class="block"><span class="text-xs text-gray-500">Language</span><select name="language" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600"><option>English</option><option>Swahili</option></select></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Generated output preview</span><textarea rows="7" readonly placeholder="Generated product copy will appear here once AI integration is connected." class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface text-gray-500"></textarea></label>
        </div>
        <div class="flex items-center gap-2 mt-4"><button type="button" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">Generate draft</button><a href="{{ route('admin.products.create') }}" class="border border-line px-4 py-2 rounded-sm hover:bg-surface">Open product form</a></div>
      </form>
    @elseif($slug === 'templates')
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        <h2 class="font-bold mb-3">Create prompt template</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label class="block"><span class="text-xs text-gray-500">Template name</span><input placeholder="Product SEO Description" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <label class="block"><span class="text-xs text-gray-500">Use case</span><select class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600"><option>Catalog</option><option>Marketing</option><option>Customer support</option></select></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Prompt body</span><textarea rows="5" placeholder="Write a conversion-focused ecommerce description for: {{product_title}}" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></textarea></label>
        </div>
        <button type="button" class="mt-4 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">Save template</button>
      </div>
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
        <div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Prompt templates</h2><p class="text-xs text-gray-500">Starter templates available for AI catalog work.</p></div>
        <table class="w-full text-sm"><thead class="bg-surface text-gray-500 text-xs uppercase"><tr><th class="text-left px-4 py-2">Template</th><th class="text-left px-4 py-2">Use case</th><th class="text-left px-4 py-2">Variables</th><th class="text-left px-4 py-2">Status</th></tr></thead><tbody>@foreach([['Product SEO Description','Catalog','title, category, specs'],['Flash Deal Copy','Marketing','discount, deadline'],['Review Reply','Support','rating, customer_name']] as [$template,$use,$vars])<tr class="border-t border-line"><td class="px-4 py-3 font-semibold">{{ $template }}</td><td class="px-4 py-3 text-gray-600">{{ $use }}</td><td class="px-4 py-3 text-gray-500">{{ $vars }}</td><td class="px-4 py-3"><span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-sm text-xs">Ready</span></td></tr>@endforeach</tbody></table>
      </div>
    @elseif($slug === 'usage')
      <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        @foreach([['Tokens this month','0'],['Estimated cost','$0.00'],['AI requests','0'],['Failed requests','0']] as [$label,$value])
          <div class="bg-white rounded-sm border border-line p-5 shadow-admin"><div class="text-xs text-gray-500">{{ $label }}</div><div class="text-2xl font-extrabold mt-1">{{ $value }}</div></div>
        @endforeach
      </div>
      <div class="bg-white rounded-sm border border-line overflow-hidden shadow-admin">
        <div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Token usage log</h2><p class="text-xs text-gray-500">Usage records will appear when AI calls are connected.</p></div>
        <table class="w-full text-sm"><thead class="bg-surface text-gray-500 text-xs uppercase"><tr><th class="text-left px-4 py-2">Date</th><th class="text-left px-4 py-2">Feature</th><th class="text-left px-4 py-2">Model</th><th class="text-left px-4 py-2">Tokens</th><th class="text-left px-4 py-2">Cost</th></tr></thead><tbody><tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">No AI usage recorded yet.</td></tr></tbody></table>
      </div>
    @else
      <div class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm">
        <div class="border-b border-line pb-4 mb-4"><h2 class="font-bold">AI provider configuration</h2><p class="text-sm text-gray-500 mt-1">Prepare model/provider settings. Secrets should be stored in Laravel `.env`.</p></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label class="block"><span class="text-xs text-gray-500">Provider</span><select class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600"><option>OpenAI</option><option>OpenRouter</option><option>Anthropic</option></select></label>
          <label class="block"><span class="text-xs text-gray-500">Default model</span><input value="gpt-4.1-mini" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <label class="block"><span class="text-xs text-gray-500">Monthly token limit</span><input value="1000000" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <label class="block"><span class="text-xs text-gray-500">Temperature</span><input value="0.7" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">API key env name</span><input value="OPENAI_API_KEY" readonly class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface text-gray-600"></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Safety instructions</span><textarea rows="5" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">Generate honest, marketplace-safe ecommerce content. Do not invent regulated claims, fake reviews, or counterfeit brand affiliations.</textarea></label>
        </div>
        <button type="button" class="mt-4 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold">Save configuration</button>
      </div>
    @endif
  </div>

  <div class="space-y-3">
    <div class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit">
      <h2 class="font-bold mb-1">AI Studio</h2>
      <p class="text-xs text-gray-500 mb-3">AI workflow pages.</p>
      <div class="space-y-1 text-sm">
        @foreach($pages as $key => $item)
          <a href="{{ route('admin.ai.'.$key) }}" class="block px-3 py-2 rounded-sm {{ $slug === $key ? 'bg-brand-600 text-white' : 'text-gray-700 hover:bg-brand-50 hover:text-brand-700' }}">{{ $item[0] }}</a>
        @endforeach
      </div>
    </div>
    <div class="bg-white rounded-sm border border-line p-4 shadow-admin text-sm">
      <h2 class="font-bold mb-2">Integration note</h2>
      <p class="text-gray-500">These pages are ready for backend AI persistence. Add API keys to `.env`, then connect form submissions to your chosen provider.</p>
    </div>
  </div>
</div>
@endsection
