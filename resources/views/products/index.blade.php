
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Product List') }}
                </h2>

                {{-- Only Admin Can Add Products --}}
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        + Add New Product
                    </a>
                @endif
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        {{-- Product Search --}}
    <form action="{{ route('products.index') }}" method="GET" class="mb-6">
        <div class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search products by name..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Search
                </button>

                <a
                href="{{ route('products.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Reset
                        </a>
                    </div>
                    </form>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">

                                {{-- Table Header --}}
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Image
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Qty
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description
                                        </th>

                                        {{-- Only Admin Can See Actions Heading --}}
                                        @if (auth()->user()->role === 'admin')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        @endif
                                    </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody class="bg-white divide-y divide-gray-200">

                                    @forelse ($products as $product)
                                        <tr>

                                            {{-- Product ID --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- Product Image --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($product->image)
                                                    <img
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                                    >
                                                @else
                                                    <div class="w-16 h-16 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center">
                                                        <span class="text-xs text-gray-400">
                                                            No Image
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Product Name --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $product->name }}
                                            </td>

                                            {{-- Quantity --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $product->qty }}
                                            </td>

                                            {{-- Price --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ₱{{ number_format($product->price, 2) }}
                                            </td>

                                            {{-- Description --}}
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $product->description }}
                                            </td>

                                            {{-- Only Admin Can See Edit and Delete --}}
                                            @if (auth()->user()->role === 'admin')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                    class="inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST"
                                                        class="inline-block"
                                                        onsubmit="return confirm('Delete this product?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="inline-block px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </td>
                                            @endif

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                                                class="px-6 py-8 text-center text-sm text-gray-500">
                                                No products found.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                         {{-- Pagination --}}
                     <div class="mt-4">
                        {{ $products->links() }}
                        </div>
                        {{-- Total Products --}}
                        <div class="mt-4 text-right text-sm text-gray-600">
                            Total Products: {{ $products->total() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
