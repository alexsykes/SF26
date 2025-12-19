<x-automail>
    <div id="container" class="space-y-2 p-2 text-sm">
        <div>Subject: {{$clubmail->subject   }}</div>
        <div>ReplyTo: {{$clubmail->replyToName}} - {{$clubmail->replyToAddress   }}</div>
        <div>Content:</div>
        <div class="text-sm p-2 border shadow-sm"><?php echo $clubmail->content; ?></div>
        <form class="space-y-2" action="/clubmails/post" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$clubmail->id}}">
            <p>Distribution</p>
            <div class="flex space-x-4">
                <div id="testDistribution" class="items-start"><input type="radio" id="test" name="distribution" checked
                                                                      value="test">
                    <label for="test">Test</label></div>
                <div id="userDistribution" class="items-start"><input type="radio" id="users" name="distribution"
                                                                      value="users">
                    <label for="users">Users</label>
                </div>
            </div>

            <div class="pt-2">
                <x-danger-button>Fire!</x-danger-button>
            </div>
        </form>
    </div>

</x-automail>