<?php

namespace App\Events;

use App\Mail\SitePublished;
use App\Models\Forecast;
use App\Models\Site;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class NewSiteApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Site $site, public Address $address)
    {
        $siteName = $site->site_name;
        info("Site Published - $siteName");

        Mail::to($address)
            ->bcc('alex@alexsykes.net')
            ->send(new SitePublished($site, $this->address));

        $this->getForecast($site);
    }

    private function getForecast(Site $site)
    {
        $open_weather = Config::get('app.OPEN_WEATHER');
        $lat = $site->lat;
        $lng = $site->lng;

        $url = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lng&exclude=minutely,alerts&units=imperial&appid=".$open_weather;

        if (! $site->forecast) {
            $rawData = (file_get_contents($url, 'r'));
            Forecast::create([
                'site_id' => $site->id,
                'data' => $rawData,
                'version' => 1,
            ]);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
