<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($products as $product)
                        <table class="w-full border border-collapse border-slate-500">
                            <thead>
                                <tr>
                                    <th class="border border-slate-600">Product</th>
                                    <th class="border border-slate-600">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td class="border border-slate-700 ...">{{ $product->name }}</td>
                                    <td class="border border-slate-700 ...">{{ $product->price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @empty
                        <div class="text-lg text-center">Nothing to show</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
