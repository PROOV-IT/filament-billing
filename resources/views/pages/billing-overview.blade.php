<x-filament-panels::page>
    <div class="space-y-8">
        <section class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm dark:border-white/10 dark:bg-gray-950">
            <div class="max-w-3xl space-y-3">
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-primary-600">ProovIT Billing</p>
                <h1 class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">{{ $this->getTitle() }}</h1>
                <p class="max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-300">
                    Billing operations powered by <span class="font-medium">proovit/laravel-billing</span>.
                    This dashboard gives panel users a quick summary of the current billing activity.
                </p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            @foreach ($overview['stats'] as $stat)
                <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-950">
                    <p class="text-xs font-medium uppercase tracking-[0.18em] text-gray-500">{{ $stat['label'] }}</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-950 dark:text-white">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $stat['hint'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-gray-950">
            <div class="mb-4 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-950 dark:text-white">Recent invoices</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Latest documents visible to this panel.</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-white/10">
                <table class="min-w-full divide-y divide-gray-200 text-left dark:divide-white/10">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Number</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Customer</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Type</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-950">
                        @forelse ($overview['recent_invoices'] as $invoice)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $invoice['number'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $invoice['customer'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $invoice['status'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $invoice['type'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $invoice['total'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-8 text-sm text-gray-600 dark:text-gray-400" colspan="5">
                                    No invoices available yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>
