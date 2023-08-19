@inject('navLinks','App\Services\View\NavigationLinksService')

<div class="h-[60px] bg-white text-primary relative
    lg:h-[90px] shadow-[0_0_12px_11px_white]">
    <div class="lg:flex lg:justify-between lg:items-center h-full">
        <div class="font-roboto font-bold text-[24px] text-center flex items-center justify-center h-full
    md:text-left md:ml-[60px] lg:text-[32px]">
            <a href="/v2/blade">Blue Bird Big Band</a>
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
            class="fa-solid fa-bars absolute cursor-pointer top-[15px] h-[30px] right-[30px]
        lg:hidden"
    ></i>
</div>
