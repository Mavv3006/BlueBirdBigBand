<div>
    <p :class="{'font-bold' : bold_name}">{{ $name }}</p>
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
        <a href="mailto:{{ $email }}"
           class="border-b-2 border-transparent text-blue-900 transition duration-150 ease-in-out
           hover:border-blue-900
           focus:outline-none focus:text-blue-900 focus:border-blue-900">
            {{ $email }}
        </a>
    </p>
</div>
