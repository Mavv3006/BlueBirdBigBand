<div>
    <x-page-sections.section-header>Setliste</x-page-sections.section-header>

    <p class="mt-4">
        Das sind die Titel, die die Blue Bird Big Band beim Auftritt gespielt hat.
    </p>

        <table class="w-3/4 mx-auto mt-2">
            <thead class="text-left">
            <th class="p-2">No.</th>
            <th class="p-2">Titel</th>
            <th class="p-2">Arrangeur</th>
            <th class="p-2">Komponist</th>
            <th class="p-2">Genre</th>
            </thead>
            <tbody>
            @foreach($setlistSongs as $song)
                <tr class="hover:bg-[#eaeaea]">
                    <td class="p-2">{{ $loop->index + 1 }}</td>
                    <td class="p-2">{{ $song['title'] }}</td>
                    <td class="p-2">{{ $song['arranger'] }}</td>
                    <td class="p-2">{{ $song['author'] }}</td>
                    <td class="p-2">{{ $song['genre'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
</div>
