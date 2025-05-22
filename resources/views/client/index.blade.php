<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __(' Gestion Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

            




            <h2>Importer des clients</h2>

                @if(session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif

                <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required class="mb-4">
                    <button type="submit" class="btn btn-primary">Importer</button>
                </form>

                <div class="mt-6">
                    <a href="{{ route('clients.clientsp') }}" class="btn btn-secondary">
                        Clients Potentiels
                    </a>
                </div>
                                 
                            

            </div>
        </div>
    </div>
</x-app-layout>
