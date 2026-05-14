@extends('admin.layout', ['title' => $section['label'], 'subtitle' => $section['description']])
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
  <div class="xl:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line flex items-start justify-between gap-3">
      <div>
        <h2 class="font-bold">{{ $section['label'] }}</h2>
        <p class="text-xs text-gray-500">{{ $section['description'] }}</p>
      </div>
      <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded-sm text-xs font-semibold">Configuration</span>
    </div>

    @if($slug === 'currency')
      <div class="p-4 space-y-4">
        <form method="POST" action="{{ route('admin.settings.currency.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 text-sm border border-line rounded-sm p-4 bg-surface/40">
          @csrf
          <label class="block md:col-span-1"><span class="text-xs text-gray-500">Code</span><input name="code" maxlength="3" required placeholder="USD" class="mt-1 w-full border border-line rounded-sm px-3 py-2 uppercase focus:outline-none focus:border-brand-600"></label>
          <label class="block md:col-span-2"><span class="text-xs text-gray-500">Name</span><input name="name" required placeholder="US Dollar" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <label class="block"><span class="text-xs text-gray-500">Symbol</span><input name="symbol" placeholder="$" class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <label class="block"><span class="text-xs text-gray-500">Rate</span><input name="exchange_rate" type="number" step="0.000001" min="0.000001" value="1" required class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600"></label>
          <div class="flex flex-col justify-end gap-2">
            <label class="inline-flex items-center gap-2 text-xs"><input type="checkbox" name="is_default" value="1" class="accent-brand-600"> Default</label>
            <label class="inline-flex items-center gap-2 text-xs"><input type="checkbox" name="is_active" value="1" checked class="accent-brand-600"> Active</label>
          </div>
          <div class="md:col-span-6"><button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">Add currency</button></div>
        </form>

        <div class="overflow-x-auto border border-line rounded-sm">
          <table class="w-full text-sm">
            <thead class="bg-surface text-gray-500 text-xs uppercase"><tr><th class="text-left px-4 py-2">Currency</th><th class="text-left px-4 py-2">Symbol</th><th class="text-left px-4 py-2">Exchange rate</th><th class="text-left px-4 py-2">Status</th><th class="px-4 py-2"></th></tr></thead>
            <tbody>
              @forelse($currencies as $currency)
                <tr class="border-t border-line">
                  <td class="px-4 py-2"><div class="font-semibold">{{ $currency->code }} @if($currency->is_default)<span class="ml-1 px-2 py-0.5 bg-brand-50 text-brand-700 rounded-sm text-xs">Default</span>@endif</div><div class="text-xs text-gray-500">{{ $currency->name }}</div></td>
                  <td class="px-4 py-2">{{ $currency->symbol ?: '—' }}</td>
                  <td class="px-4 py-2 font-mono">{{ $currency->exchange_rate }}</td>
                  <td class="px-4 py-2"><span class="px-2 py-0.5 rounded-sm text-xs {{ $currency->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">{{ $currency->is_active ? 'Active' : 'Inactive' }}</span></td>
                  <td class="px-4 py-2 text-right">
                    <form method="POST" action="{{ route('admin.settings.currency.destroy', $currency) }}" onsubmit="return confirm('Delete this currency?')">
                      @csrf @method('DELETE')
                      <button class="text-red-600 hover:underline text-sm inline-flex items-center gap-1"><x-icon name="trash" :size="13" /> Delete</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">No currencies yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    @else
      <form class="p-4 space-y-4 text-sm">
        @foreach($section['fields'] as [$label, $value])
          <label class="block">
            <span class="text-xs text-gray-500">{{ $label }}</span>
            <input value="{{ $value }}" disabled
              class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-surface text-gray-600 focus:outline-none">
          </label>
        @endforeach

        <div class="flex items-center gap-2 pt-2 border-t border-line">
          <button type="button" disabled class="bg-brand-600/50 text-white px-4 py-2 rounded-sm text-sm font-semibold cursor-not-allowed">
            Save changes
          </button>
          <span class="text-xs text-gray-500">UI placeholder — persistence can be wired to database settings next.</span>
        </div>
      </form>
    @endif
  </div>

  <div class="bg-white rounded-sm border border-line p-4 shadow-admin h-fit">
    <h2 class="font-bold mb-1">Settings sections</h2>
    <p class="text-xs text-gray-500 mb-3">Jump to another configuration group.</p>
    <div class="space-y-1 text-sm">
      @foreach($sections as $key => $item)
        <a href="{{ route('admin.settings.show', $key) }}"
           class="block px-3 py-2 rounded-sm {{ $slug === $key ? 'bg-brand-600 text-white' : 'text-gray-700 hover:bg-brand-50 hover:text-brand-700' }}">
          {{ $item['label'] }}
        </a>
      @endforeach
    </div>
  </div>
</div>
@endsection
