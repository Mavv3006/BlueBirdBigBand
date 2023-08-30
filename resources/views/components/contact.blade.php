<div>
    <p class="{{$boldName? 'font-bold': ''}}">{{ $name }}</p>
    @if($telephone)
        <p>Telefon: {{ $telephone }}</p>
    @endif
    @if($telefax)
        <p>Telefax: {{ $telefax }}</p>
    @endif
    @if($mobile)
        <p>Mobil: {{ $mobile }}</p>
    @endif
    <p>E-Mail:
        <x-email-link :mail-address="$email"/>
    </p>
</div>
