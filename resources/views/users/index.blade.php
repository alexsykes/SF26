<x-admin>
    @foreach($users as $user)
        <details>
            <summary>
                {{$user->initial}}
            </summary>
                <?php $lines = explode("\n", $user->userdata); ?>
            @foreach($lines as $line)

                    <?php $lineData = explode(",", $line); ?>
                <div class="flex text-sm">
                    <div class="pl-4 w-1/3"><a href="/user/detail/{{$lineData[0]}}">{{$lineData[1]}}</a></div>
                    <div class="w-1/3"><a href="mailto:{{$lineData[2]}}">{{$lineData[2]}}</a></div>
                </div>
            @endforeach
        </details>
    @endforeach
</x-admin>
