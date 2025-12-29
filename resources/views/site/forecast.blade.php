<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __($site['site_name']) }}
        </h2>

    </x-slot>
    @php
        //    Decode data
                $data = json_decode($forecast['data']);

        //        Set up lookup arrays
                $directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW", "N"];
                $dayArray = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

                $hourly = $data->hourly;
                $daily = $data->daily;

        //        Get summary data for today/tomorrow
                $today = $daily[0]->summary;
                $tomorrow = $daily[1]->summary;

//                Get data for rest of week
                $outlook = array();
                for ($i=2; $i < sizeof($daily); $i++) {
                    $day = $daily[$i];
                    $dayData = $day->summary;
                    $dayText = date("l", $day->dt);
                    $windDir = $day->wind_deg;
                    $windIndex = (int) (($windDir * 16 / 360) + 0.5);
                    $dir = $directions[$windIndex];
                    $windSpeed = intval($day->wind_speed);
                    $windGust = intval($day->wind_gust);
                    $lineItem =  "<div><span class=\"font-semibold\">Outlook for next $dayText - </span>";
                    $lineItem .= "$dir at $windSpeed ~ $windGust mph</div>";
                    array_push($outlook, $lineItem);
                }

//                Get html data for next 48 hours
                $html = "";
                foreach($hourly as $hourData) {
                    $time = date("D ga", $hourData->dt);
                    $windSpeeds = intval($hourData->wind_speed)." ~ ".intval($hourData->wind_gust);
                    $dir = $hourData->wind_deg;
                    $windIndex = (int) (($dir * 16 / 360) + 0.5);
                    $dir = $directions[$windIndex];
                    $html .= "<p><strong>$time</strong> $dir at $windSpeeds mph</p>";
                }
    @endphp
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="mt-4 flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row  shadow-2xl">
            <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-12 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                <div class="mt-3 mb-3 space-y-1 ">
                    <button class="border p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                            onclick="history.back()">Go
                        Back
                    </button>
                </div>
                <div><strong>Weather last updated :</strong> {{$forecast->updated_at->format('M jS, g:ia') }}</div>
                <div><strong>Summary for today :</strong> {{$today }}</div>
                <div><strong>Summary for tomorrow :</strong> {{$tomorrow }}</div>
                <details>
                    <summary class="pt-2 font-semibold">48 hour wind forecast</summary>
                    <div class="lg:columns-3 gap-5">
                        <p class=""><?php echo $html; ?>
                        </p>
                    </div>
                </details>
                <div id="outlook" class="mt-2">
                    @foreach($outlook as $dayItem)
                        @php echo $dayItem; @endphp
                    @endforeach
                </div>

                @php
                    $data = json_decode($forecast->data);
                    $hourly = $data->hourly;
                    $directions = array("N", "NNE","NE","ENE","E","ESE","SE", "SSE","S","SSW", "SW", "WSW", "W", "WNW", "NW", "NNW", "N");
                @endphp

            </div>
        </main>
    </div>
    </body>
</x-app-layout>