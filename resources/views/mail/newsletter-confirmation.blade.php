@component('mail::message')
Liebe/r [Name],

vielen Dank für Ihre Anmeldung zu unserem Newsletter! Bevor wir Ihnen regelmäßig spannende Neuigkeiten, exklusive
Angebote und Updates senden können, müssen wir sicherstellen, dass Sie diese E-Mail-Adresse tatsächlich verwenden
möchten.

Um Ihre Anmeldung abzuschließen, klicken Sie bitte auf den untenstehenden Link:

{{ \App\Services\NewsletterRequest\NewsletterRequestService::confirmationLink($this->newsletterRequest) }}

Durch Klicken auf den Link bestätigen Sie, dass Sie unseren Newsletter erhalten möchten. Sollten Sie sich nicht für
unseren Newsletter angemeldet haben oder diese E-Mail versehentlich erhalten haben, können Sie sie einfach ignorieren.

Wir freuen uns darauf, Sie in unserem Newsletter begrüßen zu dürfen und Sie über unsere neuesten Entwicklungen auf dem
Laufenden zu halten.

Vielen Dank und herzliche Grüße,<br>
Blue Bird Big Band
@endcomponent
