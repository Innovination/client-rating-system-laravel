<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class AustraliaCitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'New South Wales' => [
                'Sydney', 'Newcastle', 'Central Coast', 'Wollongong', 'Maitland',
                'Albury', 'Wagga Wagga', 'Tamworth', 'Orange', 'Dubbo',
                'Broken Hill', 'Lismore', 'Coffs Harbour', 'Queanbeyan', 'Port Macquarie',
                'Bathurst', 'Nowra', 'Ballina', 'Armidale', 'Grafton',
                'Parramatta', 'Penrith', 'Campbelltown', 'Blacktown', 'Liverpool',
                'Sutherland', 'Manly', 'Gosford', 'Tweed Heads', 'Byron Bay',
            ],
            'Victoria' => [
                'Melbourne', 'Geelong', 'Ballarat', 'Bendigo', 'Shepparton',
                'Latrobe Valley', 'Albury-Wodonga', 'Warrnambool', 'Mildura', 'Traralgon',
                'Frankston', 'Dandenong', 'Ringwood', 'Box Hill', 'Footscray',
                'Sunshine', 'Broadmeadows', 'Heidelberg', 'Clayton', 'Springvale',
                'Horsham', 'Hamilton', 'Wangaratta', 'Sale', 'Bairnsdale',
            ],
            'Queensland' => [
                'Brisbane', 'Gold Coast', 'Sunshine Coast', 'Townsville', 'Cairns',
                'Toowoomba', 'Rockhampton', 'Mackay', 'Bundaberg', 'Hervey Bay',
                'Gladstone', 'Maryborough', 'Ipswich', 'Logan City', 'Redcliffe',
                'Southport', 'Mount Isa', 'Emerald', 'Dalby', 'Warwick',
                'Caloundra', 'Noosa', 'Maroochydore', 'Nambour', 'Gympie',
            ],
            'Western Australia' => [
                'Perth', 'Fremantle', 'Mandurah', 'Bunbury', 'Geraldton',
                'Kalgoorlie', 'Albany', 'Broome', 'Port Hedland', 'Karratha',
                'Rockingham', 'Armadale', 'Joondalup', 'Stirling', 'Wanneroo',
                'Bayswater', 'Melville', 'Canning', 'Gosnells', 'Swan',
                'Esperance', 'Northam', 'Newman', 'Tom Price',
            ],
            'South Australia' => [
                'Adelaide', 'Mount Gambier', 'Whyalla', 'Murray Bridge', 'Port Augusta',
                'Port Pirie', 'Gawler', 'Victor Harbor', 'Port Lincoln', 'Renmark',
                'Elizabeth', 'Salisbury', 'Playford', 'Marion', 'Onkaparinga',
                'Tea Tree Gully', 'Campbelltown', 'Charles Sturt', 'Holdfast Bay',
            ],
            'Tasmania' => [
                'Hobart', 'Launceston', 'Devonport', 'Burnie', 'Ulverstone',
                'Queenstown', 'Glenorchy', 'Clarence', 'Kingborough', 'Brighton',
                'Sorell', 'George Town', 'Scottsdale',
            ],
            'Australian Capital Territory' => [
                'Canberra', 'Belconnen', 'Tuggeranong', 'Woden Valley', 'Gungahlin',
                'Weston Creek', 'Molonglo Valley',
            ],
            'Northern Territory' => [
                'Darwin', 'Alice Springs', 'Palmerston', 'Katherine', 'Nhulunbuy',
                'Tennant Creek', 'Jabiru',
            ],
        ];

        foreach ($data as $stateName => $cities) {
            $state = State::where('name', $stateName)->where('country_id', 13)->first();

            if (! $state) {
                continue;
            }

            foreach ($cities as $cityName) {
                City::firstOrCreate(['name' => $cityName, 'state_id' => $state->id]);
            }
        }
    }
}
