@extends('admin.layout', ['title' => 'Users'])
@section('content')
<div class="bg-white rounded-sm border border-line overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-surface text-gray-500 text-xs uppercase">
      <tr>
        <th class="text-left px-4 py-2">Name</th>
        <th class="text-left px-4 py-2">Email</th>
        <th class="text-left px-4 py-2">Phone</th>
        <th class="text-left px-4 py-2">Joined</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $u)
        <tr class="border-t border-line">
          <td class="px-4 py-2 flex items-center gap-3">
            <div class="w-8 h-8 bg-brand-100 text-brand-700 rounded-sm grid place-items-center font-semibold">{{ strtoupper(substr($u->name,0,1)) }}</div>
            {{ $u->name }}
          </td>
          <td class="px-4 py-2 text-gray-600">{{ $u->email }}</td>
          <td class="px-4 py-2 text-gray-600">{{ $u->phone ?? '—' }}</td>
          <td class="px-4 py-2 text-gray-500">{{ $u->created_at?->format('M j, Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
