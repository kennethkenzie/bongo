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
    borderRadius: { sm:'2px', DEFAULT:'3px', md:'4px', lg:'4px' },
    boxShadow: { admin:'0 1px 2px rgba(0,0,0,.04), 0 12px 28px rgba(34,34,34,.06)' }
  }}
};
</script>
<style>
  body{font-family:Inter,system-ui,-apple-system,Segoe UI,sans-serif;background:#f5f5f5;color:#222}
  summary::-webkit-details-marker{display:none}
</style>
</head>
<body class="min-h-screen">
  @auth
  @php
    $user = auth()->user();
    $roleTone = match($user->role) {
      'admin' => 'bg-brand-50 text-brand-700 border-brand-100',
      'manager' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
      'support' => 'bg-amber-50 text-amber-700 border-amber-100',
      default => 'bg-gray-100 text-gray-600 border-gray-200',
    };
    $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
    $navLink = 'flex items-center gap-2.5 px-3 py-2 rounded-sm transition';
    $navIdle = 'text-gray-700 hover:bg-brand-50 hover:text-brand-700';
    $navActive = 'bg-brand-600 text-white shadow-sm';
    $childIdle = 'text-gray-600 hover:bg-brand-50 hover:text-brand-700';
    $childActive = 'bg-brand-50 text-brand-700 font-semibold';
  @endphp
  <div class="min-h-screen lg:flex">
    <aside class="lg:fixed lg:inset-y-0 lg:left-0 lg:w-72 bg-white border-r border-line z-30 flex flex-col">
      <div class="px-4 py-4 border-b border-line flex items-center gap-3">
        <div class="w-9 h-9 bg-brand-600 text-white grid place-items-center rounded-sm font-extrabold shadow-sm">EB</div>
        <div class="leading-tight min-w-0">
          <div class="text-brand-700 font-extrabold text-sm truncate">Estate Bongo Online</div>
          <div class="text-[10px] text-gray-500 uppercase tracking-[.22em]">Commerce Admin</div>
        </div>
      </div>

      <nav class="p-3 space-y-1 text-sm flex-1 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
           class="{{ $navLink }} {{ request()->routeIs('admin.dashboard') ? $navActive : $navIdle }}">
          <x-icon name="dashboard" :size="17" /> <span>Overview</span>
        </a>

        <details class="group" @if(request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*')) open @endif>
          <summary class="{{ $navLink }} cursor-pointer {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'text-brand-700 bg-brand-50' : $navIdle }}">
            <x-icon name="archive-box" :size="17" />
            <span class="flex-1">Catalog</span>
            <x-icon name="chevron-down" :size="14" class="transition group-open:rotate-180" />
          </summary>
          <div class="ml-4 mt-1 pl-3 border-l border-line space-y-1">
            <a href="{{ route('admin.products.index') }}" class="{{ $navLink }} py-1.5 {{ request()->routeIs('admin.products.*') ? $childActive : $childIdle }}">
              <x-icon name="cube" :size="15" /> Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ $navLink }} py-1.5 {{ request()->routeIs('admin.categories.*') ? $childActive : $childIdle }}">
              <x-icon name="tag" :size="15" /> Categories
            </a>
          </div>
        </details>

        <details class="group" @if(request()->routeIs('admin.orders.*')) open @endif>
          <summary class="{{ $navLink }} cursor-pointer {{ request()->routeIs('admin.orders.*') ? 'text-brand-700 bg-brand-50' : $navIdle }}">
            <x-icon name="shopping-cart" :size="17" />
            <span class="flex-1">Sales</span>
            <x-icon name="chevron-down" :size="14" class="transition group-open:rotate-180" />
          </summary>
          <div class="ml-4 mt-1 pl-3 border-l border-line space-y-1">
            <a href="{{ route('admin.orders.index') }}" class="{{ $navLink }} py-1.5 {{ request()->routeIs('admin.orders.*') ? $childActive : $childIdle }}">
              <x-icon name="receipt" :size="15" /> Orders
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="{{ $navLink }} py-1.5 {{ request('status') === 'pending' ? $childActive : $childIdle }}">
              <x-icon name="bell" :size="15" /> Pending queue
            </a>
          </div>
        </details>

        @if($user->isAdmin())
        <details class="group" @if(request()->routeIs('admin.users.*')) open @endif>
          <summary class="{{ $navLink }} cursor-pointer {{ request()->routeIs('admin.users.*') ? 'text-brand-700 bg-brand-50' : $navIdle }}">
            <x-icon name="users" :size="17" />
            <span class="flex-1">Customers</span>
            <x-icon name="chevron-down" :size="14" class="transition group-open:rotate-180" />
          </summary>
          <div class="ml-4 mt-1 pl-3 border-l border-line space-y-1">
            <a href="{{ route('admin.users.index') }}" class="{{ $navLink }} py-1.5 {{ request()->routeIs('admin.users.*') ? $childActive : $childIdle }}">
              <x-icon name="user-circle" :size="15" /> User management
            </a>
          </div>
        </details>

        <details class="group" @if(request()->routeIs('admin.settings.*') || request()->routeIs('admin.roles.*')) open @endif>
          <summary class="{{ $navLink }} cursor-pointer {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.roles.*') ? 'text-brand-700 bg-brand-50' : $navIdle }}">
            <x-icon name="cog" :size="17" />
            <span class="flex-1">Settings</span>
            <x-icon name="chevron-down" :size="14" class="transition group-open:rotate-180" />
          </summary>
          <div class="ml-4 mt-1 pl-3 border-l border-line space-y-1">
            <a href="{{ route('admin.settings.index') }}" class="{{ $navLink }} py-1.5 {{ request()->routeIs('admin.settings.index') ? $childActive : $childIdle }}">
              <x-icon name="cog" :size="15" /> Settings overview
            </a>
            @php
              $settingsLinks = [
                'business' => 'Business Settings',
                'features' => 'Features activation',
                'languages' => 'Languages',
                'currency' => 'Currency',
                'tax' => 'Vat & TAX',
                'pickup' => 'Pickup point',
                'smtp' => 'SMTP Settings',
                'filesystem-cache' => 'File System & Cache Configuration',
                'social-logins' => 'Social media Logins',
                'facebook' => 'Facebook',
                'google' => 'Google',
                'shipping' => 'Shipping',
              ];
            @endphp
            @foreach($settingsLinks as $slug => $label)
              <a href="{{ route('admin.settings.show', $slug) }}"
                 class="block px-3 py-1.5 rounded-sm text-xs transition {{ request()->routeIs('admin.settings.show') && request()->route('section') === $slug ? $childActive : $childIdle }}">
                {{ $label }}
              </a>
            @endforeach
            <a href="{{ route('admin.roles.index') }}" class="{{ $navLink }} py-1.5 {{ request()->routeIs('admin.roles.*') ? $childActive : $childIdle }}">
              <x-icon name="lock" :size="15" /> Roles & permissions
            </a>
          </div>
        </details>
        @endif
      </nav>

      <div class="p-3 border-t border-line bg-white">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-9 h-9 bg-brand-100 text-brand-700 rounded-sm grid place-items-center font-bold">{{ strtoupper(substr($user->name,0,1)) }}</div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-semibold truncate">{{ $user->name }}</div>
            <div class="text-[11px] text-gray-500 truncate">{{ $user->email }}</div>
          </div>
        </div>
        <div class="mb-2 inline-flex items-center gap-1.5 px-2 py-1 rounded-sm border text-[10px] uppercase tracking-wider {{ $roleTone }}">
          <x-icon name="shield-check" :size="12" /> {{ $user->role }}
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button class="w-full inline-flex items-center justify-center gap-2 text-sm border border-line rounded-sm py-1.5 hover:bg-brand-50 hover:text-brand-700">
            <x-icon name="logout" :size="14" /> Sign out
          </button>
        </form>
      </div>
    </aside>

    <main class="flex-1 lg:ml-72">
      <header class="sticky top-0 z-20 bg-white/95 backdrop-blur border-b border-line px-4 md:px-6 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
          <h1 class="text-lg font-bold text-ink">{{ $title ?? 'Dashboard' }}</h1>
          @if (!empty($subtitle))<p class="text-xs text-gray-500">{{ $subtitle }}</p>@endif
        </div>
        <div class="flex items-center gap-2 text-sm">
          <a href="{{ route('admin.products.create') }}" class="hidden sm:inline-flex items-center gap-1 bg-brand-600 hover:bg-brand-700 text-white px-3 py-2 rounded-sm font-semibold">
            <x-icon name="plus" :size="14" /> Add product
          </a>
          <a href="{{ $frontendUrl }}" target="_blank" class="inline-flex items-center gap-1 border border-line px-3 py-2 rounded-sm text-brand-700 hover:bg-brand-50">
            View storefront <x-icon name="external-link" :size="13" />
          </a>
        </div>
      </header>

      @if (session('status'))
        <div class="mx-4 md:mx-6 mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-sm">
          {{ session('status') }}
        </div>
      @endif
      @if ($errors->any())
        <div class="mx-4 md:mx-6 mt-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded-sm text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
          </ul>
        </div>
      @endif

      <div class="p-4 md:p-6">
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
