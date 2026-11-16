
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">

                    {{-- Success and error messages --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-md">
                            <strong>Please fix the following errors:</strong>

                            <ul class="list-disc list-inside text-sm mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Product Form --}}
                    <form action="{{ route('products.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- Product Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Product Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                maxlength="255"
                                required
                                placeholder="e.g. Apple"
                                class="block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm"
                            >
                        </div>

                        {{-- Quantity --}}
                        <div class="mb-4">
                            <label for="qty" class="block text-sm font-medium text-gray-700 mb-1">
                                Quantity
                            </label>

                            <input
                                type="number"
                                id="qty"
                                name="qty"
                                value="{{ old('qty') }}"
                                min="0"
                                step="1"
                                required
                                placeholder="e.g. 50"
                                class="block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm"
                            >
                        </div>

                        {{-- Price --}}
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                Price
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                required
                                placeholder="e.g. 29.99"
                                class="block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm"
                            >
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                                <span class="text-gray-500 font-normal">(optional)</span>
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Short description..."
                                class="block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm"
                            >{{ old('description') }}</textarea>
                        </div>

                        {{-- Product Image Upload --}}
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                Product Image
                                <span class="text-gray-500 font-normal">(optional)</span>
                            </label>

                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer bg-white focus:outline-none"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Accepted formats: JPG, JPEG, PNG, and WebP.
                                Maximum file size: 2 MB.
                            </p>

                            @error('image')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center gap-3 mt-6">

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Save Product
                            </button>

                            <a
                                href="{{ route('products.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
