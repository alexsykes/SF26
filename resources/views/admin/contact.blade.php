<x-guest-layout>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <style>
        .grecaptcha-badge {
            width: 70px !important;
            overflow: hidden !important;
            transition: all 0.3s ease !important;
            right: 4px !important;
        }

        .grecaptcha-badge:hover {
            width: 256px !important;
        }

    </style>
    <script>
        function onSubmit(token) {
            document.getElementById("contactForm").submit();
        }
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Contact us</h2>

    </x-slot>

    {{--    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">--}}
    {{--    <div class="mt-4 flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">--}}
    {{--        <main class="rounded-lg  flex max-w-[335px] w-full lg:max-w-4xl lg:flex-row  shadow-2xl">--}}
    {{--            <div class="text-[13px] leading-[20px] flex-1 p-4 lg:p-8 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg ">--}}
    <form method="post" name="contactForm" id="contactForm" action="contact">
        @csrf

        <div class="mt-2 grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-4">

            <div class="sm:col-span-4">
                <label for="sender" class="block  font-semibold ">Name</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               name="sender"
                               required
                               value=""
                               id="sender"
                               placeholder="Your name">
                    </div>
                </div>
                @error('sender')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-4">
                <label for="email" class="block  font-semibold ">Email</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               name="email"
                               required
                               value=""
                               id="email"
                               placeholder="Your email address">
                    </div>
                </div>
                @error('email')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-full">
                <label for="message" class="block  font-semibold ">Message</label>
                <div class="mt-2">
                                <textarea name="message"
                                          id="message"
                                          rows="3"
                                          class=" block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-500 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:"
                                          placeholder="Your message here"></textarea>
                </div>
            </div>
            @error('message')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror

            <div class="block mt-4 col-span-full">
                <label for="copy_sender" class="inline-flex items-center">
                    <input id="copy_sender" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           name="copy_sender">

                    <span class="ml-2 font-semibold text-sm text-base">{{ __('Send a copy to my email address') }}</span>
                </label>
            </div>

            <div class="">
                <x-primary-button class="g-recaptcha btn btn-primary btn-lg ms-4"
                                  data-sitekey="{{ config('services.recaptcha_v3.siteKey') }}"
                                  data-callback="onSubmit"
                                  data-action="sendMail">Send
                </x-primary-button>
            </div>
        </div>
    </form>
    {{--            </div>--}}
    {{--        </main>--}}
    {{--    </div>--}}
    {{--    </body>--}}
</x-guest-layout>