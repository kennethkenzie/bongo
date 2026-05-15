@php
  $isEdit = isset($product) && $product->exists;
  $title = $isEdit ? 'Edit Product' : 'New Product';
@endphp
@extends('admin.layout', ['title' => $title])

@section('content')
<form method="POST"
      action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="bg-white rounded-sm border border-line p-6 max-w-3xl">
  @csrf
  @if ($isEdit) @method('PUT') @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Title</span>
      <input name="title" required value="{{ old('title', $product->title ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Category</span>
      <select name="category_id" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
        <option value="">— None —</option>
        @foreach ($categoryOptions as $opt)
          @php
            $label = match($opt['depth']) {
              1 => '- '.$opt['name'],
              2 => '-- '.$opt['name'],
              default => $opt['name'],
            };
          @endphp
          <option value="{{ $opt['id'] }}"
            @selected(old('category_id', $product->category_id ?? null) == $opt['id'])
            @if($opt['depth'] === 0) style="font-weight:600" @endif>{{ $label }}</option>
        @endforeach
      </select>
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Badge</span>
      <input name="badge" value="{{ old('badge', $product->badge ?? '') }}"
        placeholder="Bestseller / Choice / New"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Price (USD)</span>
      <input name="price" type="number" step="0.01" min="0" required value="{{ old('price', $product->price ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Original price (USD)</span>
      <input name="original_price" type="number" step="0.01" min="0" value="{{ old('original_price', $product->original_price ?? '') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Discount (%)</span>
      <input name="discount" type="number" min="0" max="99" value="{{ old('discount', $product->discount ?? 0) }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <label class="block">
      <span class="text-xs text-gray-500">Stock</span>
      <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <div class="md:col-span-2">
      <span class="text-xs text-gray-500">Product image</span>
      <div class="mt-1 flex items-start gap-3">
        @if (!empty($product->image))
          <img id="imgPreview" src="{{ $product->image }}" alt="" class="w-24 h-24 object-cover rounded-sm border border-line">
        @else
          <div id="imgPreview" class="w-24 h-24 grid place-items-center bg-surface border border-line rounded-sm text-xs text-gray-400">No image</div>
        @endif
        <div class="flex-1 space-y-2">
          <label class="block">
            <span class="text-xs text-gray-500">Upload product image</span>
            <input type="file" name="image_file" accept="image/*" id="imgInput"
              class="mt-1 block w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-sm file:border-0 file:bg-brand-600 file:text-white hover:file:bg-brand-700">
            <span class="block text-[11px] text-gray-400 mt-1">JPG, PNG, WebP, or GIF up to 4 MB. {{ $isEdit ? 'Leave empty to keep current image.' : 'Required.' }}</span>
          </label>
        </div>
      </div>
    </div>

    <script>
      (function () {
        const input = document.getElementById('imgInput');
        const preview = document.getElementById('imgPreview');
        input?.addEventListener('change', (e) => {
          const file = e.target.files?.[0];
          if (!file) return;
          const reader = new FileReader();
          reader.onload = (ev) => {
            if (preview.tagName === 'IMG') {
              preview.src = ev.target.result;
            } else {
              const img = document.createElement('img');
              img.id = 'imgPreview';
              img.src = ev.target.result;
              img.alt = '';
              img.className = 'w-24 h-24 object-cover rounded-sm border border-line';
              preview.replaceWith(img);
            }
          };
          reader.readAsDataURL(file);
        });
      })();
    </script>

    <label class="block md:col-span-2">
      <span class="text-xs text-gray-500">Description</span>
      <textarea name="description" rows="4"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">{{ old('description', $product->description ?? '') }}</textarea>
    </label>

    {{-- Brand / Custom Label / Smart Bar --}}
    <div class="md:col-span-2 border-t border-line pt-4 mt-1">
      <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Brand &amp; Labels</p>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <label class="block">
          <span class="text-xs text-gray-500">Brand</span>
          <select name="brand" class="mt-1 w-full border border-line rounded-sm px-3 py-2 bg-white focus:outline-none focus:border-brand-600">
            <option value="">— None —</option>
            @foreach ($brands as $b)
              <option value="{{ $b->name }}" @selected(old('brand', $product->brand ?? '') === $b->name)>{{ $b->name }}</option>
            @endforeach
          </select>
          @if ($brands->isEmpty())
            <a href="{{ route('admin.catalog.brands') }}" class="block text-[11px] text-brand-600 hover:underline mt-1">Register a brand first →</a>
          @endif
        </label>
        <label class="block">
          <span class="text-xs text-gray-500">Custom Label</span>
          <input name="custom_label" value="{{ old('custom_label', $product->custom_label ?? '') }}"
            placeholder="e.g. Exclusive"
            class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
        </label>
        <label class="block">
          <span class="text-xs text-gray-500">Smart Bar</span>
          <input name="smart_bar" value="{{ old('smart_bar', $product->smart_bar ?? '') }}"
            placeholder="e.g. Only 3 left in stock!"
            class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
        </label>
      </div>
    </div>

    {{-- Colors --}}
    <div class="md:col-span-2 border-t border-line pt-4 mt-1">
      <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Colors</p>
      <div id="colorsList" class="flex flex-wrap gap-2 mb-2 min-h-6"></div>
      <div class="flex gap-2">
        <input id="colorInput" type="text" placeholder="e.g. Red or #FF5733"
          class="flex-1 border border-line rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-600">
        <button type="button" id="addColorBtn"
          class="border border-brand-600 text-brand-600 hover:bg-brand-50 px-4 py-2 rounded-sm text-sm">Add</button>
      </div>
      <input type="hidden" name="colors" id="colorsJson"
        value="{{ old('colors', json_encode($product->colors ?? [])) }}">
    </div>

    {{-- Attributes --}}
    <div class="md:col-span-2 border-t border-line pt-4 mt-1">
      <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Attributes</p>
      <div id="attrList" class="space-y-1.5 mb-2"></div>
      <div class="flex gap-2">
        <input id="attrKey" type="text" placeholder="Key (e.g. Material)"
          class="w-36 border border-line rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-600">
        <input id="attrVal" type="text" placeholder="Value (e.g. Cotton)"
          class="flex-1 border border-line rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-600">
        <button type="button" id="addAttrBtn"
          class="border border-brand-600 text-brand-600 hover:bg-brand-50 px-4 py-2 rounded-sm text-sm">Add</button>
      </div>
      <input type="hidden" name="attributes" id="attributesJson"
        value="{{ old('attributes', json_encode($product->attributes ?? [])) }}">
    </div>

    {{-- Size Guide & Warranty --}}
    <div class="md:col-span-2 border-t border-line pt-4 mt-1">
      <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Size Guide &amp; Warranty</p>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-xs text-gray-500">Size Guide</span>
          <textarea name="size_guide" rows="5"
            placeholder="Describe sizing information, measurements, or a size chart..."
            class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">{{ old('size_guide', $product->size_guide ?? '') }}</textarea>
        </label>
        <label class="block">
          <span class="text-xs text-gray-500">Warranty</span>
          <textarea name="warranty" rows="5"
            placeholder="Describe warranty terms, coverage, and duration..."
            class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">{{ old('warranty', $product->warranty ?? '') }}</textarea>
        </label>
      </div>
    </div>

    <script>
    (function () {
      const inputCls = 'border border-line rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-600';

      // ── Colors ──────────────────────────────────────────────
      let colors = [];
      try { colors = JSON.parse(document.getElementById('colorsJson').value) || []; } catch (_) {}

      function renderColors() {
        const list = document.getElementById('colorsList');
        list.innerHTML = '';
        colors.forEach(function (c, i) {
          const chip = document.createElement('span');
          chip.className = 'inline-flex items-center gap-1 bg-surface border border-line rounded-full px-3 py-1 text-xs';
          const label = document.createTextNode(c);
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.textContent = '×';
          btn.className = 'ml-1 text-gray-400 hover:text-red-500 leading-none';
          btn.dataset.index = i;
          btn.addEventListener('click', function () {
            colors.splice(Number(this.dataset.index), 1);
            renderColors();
          });
          chip.appendChild(label);
          chip.appendChild(btn);
          list.appendChild(chip);
        });
        document.getElementById('colorsJson').value = JSON.stringify(colors);
      }

      document.getElementById('addColorBtn').addEventListener('click', function () {
        const val = document.getElementById('colorInput').value.trim();
        if (!val) return;
        colors.push(val);
        document.getElementById('colorInput').value = '';
        renderColors();
      });

      document.getElementById('colorInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); document.getElementById('addColorBtn').click(); }
      });

      renderColors();

      // ── Attributes ──────────────────────────────────────────
      let attrs = [];
      try { attrs = JSON.parse(document.getElementById('attributesJson').value) || []; } catch (_) {}

      function renderAttrs() {
        const list = document.getElementById('attrList');
        list.innerHTML = '';
        attrs.forEach(function (a, i) {
          const row = document.createElement('div');
          row.className = 'flex items-center gap-2 bg-surface border border-line rounded-sm px-3 py-2 text-sm';
          const key = document.createElement('span');
          key.className = 'font-medium text-gray-700 w-28 shrink-0 truncate';
          key.textContent = a.key;
          const sep = document.createElement('span');
          sep.textContent = ':';
          sep.className = 'text-gray-400';
          const val = document.createElement('span');
          val.className = 'flex-1 text-gray-600 truncate';
          val.textContent = a.value;
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.textContent = 'Remove';
          btn.className = 'ml-auto text-xs text-gray-400 hover:text-red-500 shrink-0';
          btn.dataset.index = i;
          btn.addEventListener('click', function () {
            attrs.splice(Number(this.dataset.index), 1);
            renderAttrs();
          });
          row.appendChild(key);
          row.appendChild(sep);
          row.appendChild(val);
          row.appendChild(btn);
          list.appendChild(row);
        });
        document.getElementById('attributesJson').value = JSON.stringify(attrs);
      }

      document.getElementById('addAttrBtn').addEventListener('click', function () {
        const key = document.getElementById('attrKey').value.trim();
        const val = document.getElementById('attrVal').value.trim();
        if (!key || !val) return;
        attrs.push({ key: key, value: val });
        document.getElementById('attrKey').value = '';
        document.getElementById('attrVal').value = '';
        renderAttrs();
      });

      document.getElementById('attrVal').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); document.getElementById('addAttrBtn').click(); }
      });

      renderAttrs();
    })();
    </script>

    <label class="block">
      <span class="text-xs text-gray-500">Shipping label</span>
      <input name="shipping" value="{{ old('shipping', $product->shipping ?? 'Free shipping') }}"
        class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
    </label>

    <div class="flex items-center gap-4 pt-5">
      <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="free_shipping" value="0">
        <input type="checkbox" name="free_shipping" value="1" class="accent-brand-600"
          @checked(old('free_shipping', $product->free_shipping ?? true))>
        Free shipping
      </label>
      <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" class="accent-brand-600"
          @checked(old('is_active', $product->is_active ?? true))>
        Active
      </label>
    </div>
  </div>

  <div class="flex items-center gap-2 mt-5">
    <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-sm text-sm font-semibold">
      {{ $isEdit ? 'Save changes' : 'Create product' }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="border border-line px-4 py-2 rounded-sm text-sm hover:bg-surface">Cancel</a>
  </div>
</form>
@endsection
