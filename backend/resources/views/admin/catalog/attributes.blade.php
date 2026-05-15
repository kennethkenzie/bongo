@extends('admin.layout', ['title' => 'Attribute', 'subtitle' => 'Manage reusable product attributes like material, storage, model, or fit.'])
@section('content')
@php $inputCls = 'mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600 text-sm'; @endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

  <form method="POST" action="{{ route('admin.catalog.attributes.store') }}"
        class="bg-white rounded-sm border border-line p-5 shadow-admin text-sm h-fit">
    @csrf
    <h2 class="font-bold mb-3">Add attribute</h2>

    @if ($errors->any())
      <div class="mb-3 text-xs text-red-600 space-y-0.5">
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
      </div>
    @endif

    <label class="block mb-3">
      <span class="text-xs text-gray-500">Attribute name</span>
      <input name="name" required value="{{ old('name') }}" placeholder="Material / Storage / Model" class="{{ $inputCls }}">
    </label>

    <label class="block mb-4">
      <span class="text-xs text-gray-500">Values <span class="text-gray-400">(comma-separated)</span></span>
      <textarea name="values" rows="4" placeholder="Cotton, Leather, Metal" class="{{ $inputCls }}">{{ old('values') }}</textarea>
    </label>

    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm font-semibold text-sm">Save attribute</button>
  </form>

  <div class="lg:col-span-2 bg-white rounded-sm border border-line overflow-hidden shadow-admin">
    <div class="px-4 py-3 border-b border-line"><h2 class="font-bold">Attributes</h2></div>
    <table class="w-full text-sm">
      <thead class="bg-surface text-xs uppercase text-gray-500">
        <tr>
          <th class="text-left px-4 py-2">Name</th>
          <th class="text-left px-4 py-2">Values</th>
          <th class="px-4 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($attributes as $attr)
          <tr class="border-t border-line hover:bg-surface/50">
            <td class="px-4 py-3 font-medium">{{ $attr->name }}</td>
            <td class="px-4 py-3 text-gray-500">
              @if (!empty($attr->values))
                <div class="flex flex-wrap gap-1">
                  @foreach ($attr->values as $v)
                    <span class="px-2 py-0.5 bg-surface border border-line rounded-sm text-xs">{{ $v }}</span>
                  @endforeach
                </div>
              @else
                <span class="text-gray-300">—</span>
              @endif
            </td>
            <td class="px-4 py-3 text-right">
              <form method="POST" action="{{ route('admin.catalog.attributes.destroy', $attr) }}"
                    onsubmit="return confirm('Delete {{ addslashes($attr->name) }}?')">
                @csrf @method('DELETE')
                <button class="text-xs text-gray-400 hover:text-red-500">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="px-4 py-10 text-center text-gray-400">No attributes yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
