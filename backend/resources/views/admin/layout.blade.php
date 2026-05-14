<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>{{ $title ?? 'Admin' }} · Estate Bongo Online</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: { extend: {
    colors: {
      brand: { 50:'#f5edff',100:'#e9d8ff',200:'#d4b1ff',300:'#bd86ff',400:'#a25cff',500:'#8a3df3',600:'#7c2ae8',700:'#6a1fcc',800:'#561aa6',900:'#3f1280' },
      ink:'#222', line:'#e5e5e5', surface:'#f5f5f5', deal:'#ff3b30'
    },
    borderRadius: { sm:'2px', DEFAULT:'3px', md:'4px', lg:'4px' }
  }}
};
</script>
<style>body{font-family:Inter,system-ui,sans-serif;background:#f5f5f5;color:#222}</style>
</head>
<body class="min-h-screen">
  @auth
  <div class="flex min-h-screen">
    <aside class="w-60 bg-white border-r border-line shrink-0">
      <div class="px-4 py-4 border-b border-line flex items-center gap-2">
        <div class="w-8 h-8 bg-brand-600 text-white grid place-items-center rounded-sm font-bold">EB</div>
        <div class="leading-tight">
          <div class="text-brand-700 font-extrabold text-sm">Estate Bongo</div>
          <div class="text-[10px] text-gray-500 uppercase tracking-wider">Admin</div>
        </div>
      </div>
      <nav class="p-3 space-y-1 text-sm">
        @php
          $items = [
            ['admin.dashboard',   '📊 Dashboard'],
            ['admin.products.index', '📦 Products'],
            ['admin.categories.index', '🏷️ Categories'],
            ['admin.orders.index', '🧾 Orders'],
            ['admin.users.index', '👥 Users'],
          ];
        @endphp
        @foreach ($items as [$route, $label])
          <a href="{{ route($route) }}"
             class="block px-3 py-2 rounded-sm hover:bg-brand-50 hover:text-brand-700 transition
                    {{ request()->routeIs($route.'*') || request()->routeIs($route) ? 'bg-brand-600 text-white hover:bg-brand-600 hover:text-white' : 'text-gray-700' }}">
            {{ $label }}
          </a>
        @endforeach
      </nav>
      <div class="mt-auto p-3 border-t border-line absolute bottom-0 w-60">
        <div class="text-xs text-gray-500 mb-2">Signed in as <span class="font-semibold text-ink">{{ auth()->user()->name }}</span></div>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button class="w-full text-sm border border-line rounded-sm py-1.5 hover:bg-brand-50 hover:text-brand-700">Sign out</button>
        </form>
      </div>
    </aside>

    <main class="flex-1">
      <header class="bg-white border-b border-line px-6 py-3 flex items-center justify-between">
        <div>
          <h1 class="text-lg font-bold text-ink">{{ $title ?? 'Dashboard' }}</h1>
          @if (!empty($subtitle))<p class="text-xs text-gray-500">{{ $subtitle }}</p>@endif
        </div>
        <div class="flex items-center gap-2 text-sm">
          <a href="{{ url('/') }}" target="_blank" class="text-brand-700 hover:underline">View site →</a>
        </div>
      </header>

      @if (session('status'))
        <div class="mx-6 mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-sm">
          {{ session('status') }}
        </div>
      @endif
      @if ($errors->any())
        <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded-sm text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
          </ul>
        </div>
      @endif

      <div class="p-6">
        {{ $slot ?? '' }}
        @yield('content')
      </div>
    </main>
  </div>
  @else
    @yield('content')
  @endauth
</body>
</html>
