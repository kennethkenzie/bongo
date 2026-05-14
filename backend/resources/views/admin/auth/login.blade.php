@extends('admin.layout', ['title' => 'Admin Sign In'])

@section('content')
<div class="min-h-screen grid place-items-center bg-gradient-to-br from-brand-700 to-brand-400 p-4">
  <div class="bg-white rounded-sm shadow-2xl w-full max-w-md p-6">
    <div class="flex items-center gap-2 mb-5">
      <div class="w-10 h-10 bg-brand-600 text-white grid place-items-center rounded-sm font-bold">EB</div>
      <div class="leading-tight">
        <div class="text-brand-700 font-extrabold">Estate Bongo Online</div>
        <div class="text-[10px] text-gray-500 uppercase tracking-wider">Admin Console</div>
      </div>
    </div>
    <h1 class="text-xl font-bold mb-1">Sign in to your admin account</h1>
    <p class="text-sm text-gray-500 mb-4">Manage products, orders, and customers.</p>

    @if ($errors->any())
      <div class="mb-3 p-2.5 bg-red-50 border border-red-200 text-red-700 rounded-sm text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-3 text-sm">
      @csrf
      <label class="block">
        <span class="text-xs text-gray-500">Email</span>
        <input type="email" name="email" value="{{ old('email', 'demo@estatebongo.com') }}" required
          class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
      </label>
      <label class="block">
        <span class="text-xs text-gray-500">Password</span>
        <input type="password" name="password" value="password" required
          class="mt-1 w-full border border-line rounded-sm px-3 py-2 focus:outline-none focus:border-brand-600">
      </label>
      <label class="flex items-center gap-2 text-xs text-gray-600">
        <input type="checkbox" name="remember" checked class="accent-brand-600"> Remember me
      </label>
      <button class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2 rounded-sm">Sign In</button>
    </form>
    <div class="text-[11px] text-gray-400 text-center mt-4">
      Demo credentials: <code class="font-mono">demo@estatebongo.com</code> / <code class="font-mono">password</code>
    </div>
  </div>
</div>
@endsection
