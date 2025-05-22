<x-app-layout>
    <h2>Liste des clients</h2>

    <a href="{{ route('client.index') }}" class="btn btn-secondary">Importer des clients</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->telephone }}</td>
                    <td>{{ $client->adresse }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
