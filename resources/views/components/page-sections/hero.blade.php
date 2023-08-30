<div
    class="hero-bg-picture bg-gray-800 relative bg-top bg-no-repeat bg-cover h-72 md:h-96 lg:h-[30rem] xl:h-[40rem] 2xl:h-[48rem]">
    <div class="absolute h-full w-full bg-[#1b1b1b] opacity-70 top-0"></div>
    <div class="absolute w-full h-full">
        <div class="flex flex-col gap-8 items-center h-full justify-center ">
            <div class="text-white text-2xl w-3/4 text-center font-semibold">
                Herzlich Willkommen bei der Blue Bird Big Band
            </div>
            <div>
                <x-forms.buttons.call-to-action-button-anchor name="Kontakt" href="/v2/kontakt"/>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-bg-picture {
        background-image: url('{{ asset('assets/grouppictures/2023-05-07_v2.jpg') }}');
    }
</style>
