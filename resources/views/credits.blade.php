<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Credits
        </h2>
    </x-slot>
    <main>
        <body>
        <div class="visible rounded-xl  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1  border border-neutral-200 ">
            <div class="m-2 space-y-2">
                <div class="font-semibold">We are grateful to the following:</div>
                <div class="text-sm">Simon Stevens - for the site data which is the backbone of this site</div>
                <div class="text-sm">Slopehunter - <a class="font-semibold" target="_blank"
                                                      href="http://www.slopehunter.co.uk/index.html">click
                        here</a> -
                    although no longer maintained, there is some helpful stuff here - especially for southern England.
                </div>
                <div class="text-sm">OpenWeather - for the weather data vital to the use of this site</div>
            </div>
        </div>
        </body>
    </main>
</x-app-layout>