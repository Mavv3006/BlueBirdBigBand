<div>
    <div class="h-[60px] bg-white text-primary relative
    lg:h-[90px] {{ !$isMobileMenuOpen ? 'shadow-[0_0_12px_11px_white]' : '' }}">
        <div class="lg:flex lg:justify-between lg:items-center h-full">
            <div class="font-roboto font-bold text-[24px] text-center flex items-center justify-center h-full
    md:text-left md:ml-[60px] lg:text-[32px]">
                <a href="/v2">Blue Bird Big Band</a>
            </div>
            <div class="hidden mr-[60px] gap-12 relative items-center lg:flex">
                @foreach($navLinks->getLinkNavElements() as $element)
                    <a href="{{ $element->link}}"
                       class="text-[#1b1b1b] font-semibold">
                        {{ $element->name }}
                    </a>
                @endforeach
                @foreach($navLinks->getCtaNavElements() as $element)
                    <x-forms.buttons.call-to-action-button-anchor
                        name="{{$element->name}}"
                        href="{{$element->link}}"/>
                @endforeach
            </div>
        </div>
        <i
            class="fa-solid {{ $isMobileMenuOpen? 'fa-close' : 'fa-bars'}}
        absolute cursor-pointer top-[15px] h-[30px] right-[30px]
        lg:hidden"
            wire:click="toggleMobileMenu"
        ></i>
    </div>
    @if($isMobileMenuOpen)
        <div class="bg-white text-primary shadow-[0_0_12px_11px_white] flex flex-col gap-2 pb-2">
            @foreach($navLinks->getAllLinks() as $element)
                <a href="{{ $element->link}}"
                   class="bg-gray-100 py-2 pl-10 text-black font-bold rounded-lg cursor-pointer
                        hover:bg-gray-200
                        active:bg-gray-300">
                    {{ $element->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>
