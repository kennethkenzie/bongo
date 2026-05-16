@php
  $indent = ['pl-0', 'pl-7', 'pl-14'][$depth] ?? 'pl-14';
  $bg = $depth === 0 ? 'hover:bg-surface/70' : ($depth === 1 ? 'bg-surface/40 hover:bg-surface/80' : 'bg-gray-50/60 hover:bg-surface');
  $size = $depth === 0 ? 'w-9 h-9' : ($depth === 1 ? 'w-7 h-7' : 'w-6 h-6');
  $font = $depth === 0 ? 'font-semibold text-ink' : ($depth === 1 ? 'text-gray-700' : 'text-gray-500');
  $prefix = $depth === 0 ? '' : ($depth === 1 ? '- ' : '-- ');
@endphp
<tr class="border-t border-line {{ $bg }}">
  <td class="px-4 py-2">
    <div class="flex items-center gap-3 {{ $indent }} min-w-[240px]">
      @if ($category->image)
        <img src="{{ $category->image }}" alt="" class="{{ $size }} rounded-sm object-cover border border-line shrink-0">
      @else
        <div class="{{ $size }} rounded-sm bg-brand-50 text-brand-700 grid place-items-center shrink-0">
          <x-icon name="tag" :size="$depth === 0 ? 16 : 12" />
        </div>
      @endif
      <div>
        <div class="{{ $font }}">{{ $prefix }}{{ $category->name }}</div>
        <div class="text-[11px] text-gray-400">Sort: {{ $category->sort_order ?? 0 }}</div>
      </div>
    </div>
  </td>
  <td class="px-4 py-2 font-mono text-xs text-gray-500">{{ $category->slug }}</td>
  <td class="px-4 py-2 text-gray-600">{{ $category->products_count }}</td>
  <td class="px-4 py-2">
    @if ($category->is_active)
      <span class="text-emerald-600 inline-flex items-center gap-1 text-xs"><x-icon name="check-circle" :size="13" /> Active</span>
    @else
      <span class="text-gray-400 text-xs">Inactive</span>
    @endif
  </td>
  <td class="px-4 py-2 text-right whitespace-nowrap">
    <a href="{{ route('admin.categories.edit', $category) }}" class="text-brand-700 hover:underline text-xs inline-flex items-center gap-1 mr-3">
      <x-icon name="edit" :size="12" /> Edit
    </a>
    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete {{ addslashes($category->name) }}? Sub-categories under it will also be deleted.');" class="inline">
      @csrf @method('DELETE')
      <button class="text-red-500 hover:text-red-700 text-xs inline-flex items-center gap-1">
        <x-icon name="trash" :size="12" /> Delete
      </button>
    </form>
  </td>
</tr>
