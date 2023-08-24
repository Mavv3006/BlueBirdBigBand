<div>
    <x-page-sections.section-header>Setliste</x-page-sections.section-header>

    <table class="w-full">
        <thead class="text-left">
        <th>Titel</th>
        <th>Arrangeur</th>
        <th>Komponist</th>
        <th>Genre</th>
        </thead>
        <tbody>
        @foreach($setlistSongs as $song)
            <tr>
                <td>{{ $song['title'] }}</td>
                <td>{{ $song['arranger'] }}</td>
                <td>{{ $song['author'] }}</td>
                <td>{{ $song['genre'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
