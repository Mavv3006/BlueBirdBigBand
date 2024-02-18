@component('mail::message')
Liebe Freunde der Blue Bird Big Band,

wir hoffen, dass Sie alle in bester Stimmung sind! Es ist an der Zeit, Ihre Tanzschuhe zu schnüren, denn die Blue Bird Big Band aus Speyer lädt Sie herzlich zu unserem nächsten Konzert "{{ $concert->venue_description }}" ein, das am {{ $concert->date->translatedFormat('l, d.m.Y') }} in {{ $concert->venue->name }} stattfindet. Das Beste daran? <b>Der Eintritt ist frei</b> für alle Musik- und Tanzbegeisterten!

Datum: {{ $concert->date->translatedFormat('l, d.m.Y') }}<br>
Ort: {{ $concert->venue_description }}, {{ $concert->venue_street }} {{$concert->venue_street_number}}, {{ $concert->venue_plz }} {{ $concert->venue->name }}<br>
Uhrzeit: {{ $concert->start_time->format('H:i') }} Uhr bis {{ $concert->end_time->format('H:i') }} Uhr

Erleben Sie einen unvergesslichen Abend voller Swing-Musik und guter Laune, präsentiert von der Blue Bird Big Band. Von den Klassikern bis zu modernen Interpretationen werden wir Ihnen ein breites Repertoire bieten, das Ihre Tanzbeine zum Schwingen bringen wird.

Bringen Sie Ihre Freunde, Familie und alle Swing-Enthusiasten mit, die Sie kennen, und genießen Sie gemeinsam mit uns eine Nacht voller Musik und Tanz. Die Veranstaltung ist offen für alle Altersgruppen und Kenntnisstufen, also egal, ob Sie ein erfahrener Swing-Tänzer sind oder einfach nur die Musik genießen möchten, Sie sind herzlich willkommen!

Wir danken Ihnen für Ihre Unterstützung und freuen uns darauf, Sie am {{ $concert->date->translatedFormat('l, d.m.Y') }} in {{ $concert->venue->name }} zu sehen!

Mit swingenden Grüßen,
Eure Blue Bird Big Band
@endcomponent
