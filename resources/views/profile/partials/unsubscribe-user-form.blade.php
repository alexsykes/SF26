@php
    //    dd($user);
                 if($user->email_optout) {
                     $optout = 'checked';
                 } else {
                     $optout = "";
                 }
@endphp


<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Email Notifications') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Choose whether you\'d like to opt out of receiving notifications via email. ') }}
        </p>
    </header>

    <form method="post" action="/profile/unsubscribe" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="email_optout" :value="__('Do NOT receive notifications')"/>
            <input type="checkbox" id="email_optout" name="email_optout" {{$optout}} class="mt-1 block"/>
        </div>

        {{--        <div>--}}
        {{--            <x-input-label for="receive_trials" :value="__('New trials published')" />--}}
        {{--            <input type="checkbox" id="receive_trials" name="receive_trials"  {{$receiveTrials}}  class="mt-1 block"  />--}}
        {{--        </div>--}}

        {{--        <div>--}}
        {{--            <x-input-label for="receive_news" :value="__('General')" />--}}
        {{--            <input type="checkbox" id="receive_news" name="receive_news"  {{$receiveNews}}  class="mt-1 block"  />--}}
        {{--        </div>--}}


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

        </div>
    </form>
</section>
