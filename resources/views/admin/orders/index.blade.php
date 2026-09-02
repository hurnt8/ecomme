@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
    <form method="GET" class="flex gap-2 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="N° commande, nom, e-mail..."
               class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm w-72">
        <select name="status" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm" onchange="this.form.submit()">
            <option value="">Tous les statuts</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm">Filtrer</button>
    </form>

    <div class="bg-white rounded-lg border border-neutral-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-2">N° commande</th>
                    <th class="text-left px-4 py-2">Client</th>
                    <th class="text-left px-4 py-2">Date</th>
                    <th class="text-right px-4 py-2">Total</th>
                    <th class="text-center px-4 py-2">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.commandes.show', $order) }}" class="font-medium hover:underline">{{ $order->order_number }}</a>
                        </td>
                        <td class="px-4 py-2">
                            {{ $order->customer_name }}
                            <span class="block text-xs text-neutral-400">{{ $order->customer_email }}</span>
                        </td>
                        <td class="px-4 py-2 text-neutral-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 text-right">{{ number_format((float) $order->total, 2) }}&nbsp;€</td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs
                                {{ match($order->status) {
                                    \App\Enums\OrderStatus::Pending => 'bg-yellow-100 text-yellow-700',
                                    \App\Enums\OrderStatus::Processing => 'bg-blue-100 text-blue-700',
                                    \App\Enums\OrderStatus::Shipped => 'bg-indigo-100 text-indigo-700',
                                    \App\Enums\OrderStatus::Completed => 'bg-green-100 text-green-700',
                                    \App\Enums\OrderStatus::Cancelled => 'bg-red-100 text-red-700',
                                } }}">
                                {{ $order->status->label() }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-neutral-400">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
