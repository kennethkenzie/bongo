<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Access denied · Estate Bongo Online</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="https://cdn.tailwindcss.com"></script>
<style>body{font-family:Inter,system-ui,sans-serif;background:#f5f5f5;color:#222}</style>
</head>
<body>
<div class="min-h-screen grid place-items-center p-6">
  <div class="max-w-md w-full bg-white rounded-sm border border-gray-200 p-8 text-center">
    <div class="w-12 h-12 mx-auto bg-red-50 text-red-600 grid place-items-center rounded-sm">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6"
           stroke="currentColor" width="22" height="22" stroke-linecap="round" stroke-linejoin="round">
        <path d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
      </svg>
    </div>
    <h1 class="text-xl font-bold mt-3">Admins only</h1>
    <p class="text-sm text-gray-500 mt-1">
      Your account doesn't have access to the admin console.
      @if (auth()->check())
        Signed in as <span class="font-medium text-gray-700">{{ auth()->user()->email }}</span>.
      @endif
    </p>
    <div class="flex items-center justify-center gap-2 mt-5 text-sm">
      <a href="{{ url('/') }}" class="border border-gray-200 px-4 py-2 rounded-sm hover:bg-gray-50">Go home</a>
      @if (auth()->check())
        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
          @csrf
          <button class="bg-[#7c2ae8] hover:bg-[#6a1fcc] text-white px-4 py-2 rounded-sm font-semibold">Sign out</button>
        </form>
      @else
        <a href="{{ route('admin.login') }}" class="bg-[#7c2ae8] hover:bg-[#6a1fcc] text-white px-4 py-2 rounded-sm font-semibold">Admin sign in</a>
      @endif
    </div>
  </div>
</div>
</body>
</html>
