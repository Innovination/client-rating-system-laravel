<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CanadaCitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Alberta' => [
                'Calgary', 'Edmonton', 'Red Deer', 'Lethbridge', 'St. Albert',
                'Medicine Hat', 'Grande Prairie', 'Airdrie', 'Spruce Grove', 'Okotoks',
                'Leduc', 'Fort Saskatchewan', 'Camrose', 'Chestermere', 'Cochrane',
                'Sherwood Park', 'Fort McMurray', 'Lloydminster', 'Wetaskiwin',
            ],
            'British Columbia' => [
                'Vancouver', 'Surrey', 'Burnaby', 'Richmond', 'Kelowna',
                'Abbotsford', 'Coquitlam', 'Langley', 'Saanich', 'Delta',
                'Kamloops', 'Nanaimo', 'Victoria', 'Prince George', 'Chilliwack',
                'Vernon', 'Maple Ridge', 'New Westminster', 'Penticton', 'North Vancouver',
                'Port Coquitlam', 'White Rock', 'West Vancouver', 'Mission', 'Courtenay',
            ],
            'Manitoba' => [
                'Winnipeg', 'Brandon', 'Steinbach', 'Thompson', 'Portage la Prairie',
                'Selkirk', 'Winkler', 'Morden', 'Dauphin', 'The Pas',
            ],
            'New Brunswick' => [
                'Moncton', 'Saint John', 'Fredericton', 'Dieppe', 'Riverview',
                'Quispamsis', 'Rothesay', 'Bathurst', 'Miramichi', 'Edmundston',
            ],
            'Newfoundland and Labrador' => [
                'St. John\'s', 'Mount Pearl', 'Corner Brook', 'Conception Bay South',
                'Grand Falls-Windsor', 'Paradise', 'Happy Valley-Goose Bay',
                'Gander', 'Labrador City', 'Stephenville',
            ],
            'Nova Scotia' => [
                'Halifax', 'Cape Breton', 'Truro', 'New Glasgow', 'Glace Bay',
                'Dartmouth', 'Sydney', 'Kentville', 'Amherst', 'Bridgewater',
            ],
            'Ontario' => [
                'Toronto', 'Ottawa', 'Mississauga', 'Brampton', 'Hamilton',
                'London', 'Markham', 'Vaughan', 'Kitchener', 'Windsor',
                'Burlington', 'Oakville', 'Richmond Hill', 'Oshawa', 'Barrie',
                'Sudbury', 'Kingston', 'Guelph', 'Ajax', 'Thunder Bay',
                'Waterloo', 'Brantford', 'Pickering', 'Whitby', 'Cambridge',
                'Niagara Falls', 'St. Catharines', 'Peterborough', 'Sault Ste. Marie', 'Clarington',
                'North Bay', 'Sarnia', 'Aurora', 'Newmarket', 'Halton Hills',
            ],
            'Prince Edward Island' => [
                'Charlottetown', 'Summerside', 'Stratford', 'Cornwall', 'Montague',
            ],
            'Quebec' => [
                'Montreal', 'Quebec City', 'Laval', 'Gatineau', 'Longueuil',
                'Sherbrooke', 'Saguenay', 'Lévis', 'Trois-Rivières', 'Terrebonne',
                'Saint-Jean-sur-Richelieu', 'Repentigny', 'Brossard', 'Drummondville',
                'Saint-Jérôme', 'Granby', 'Blainville', 'Dollard-des-Ormeaux',
                'Mirabel', 'Saint-Hyacinthe', 'Châteauguay', 'Mascouche', 'Victoriaville',
            ],
            'Saskatchewan' => [
                'Saskatoon', 'Regina', 'Prince Albert', 'Moose Jaw', 'Swift Current',
                'Yorkton', 'North Battleford', 'Estevan', 'Weyburn', 'Lloydminster',
            ],
            'Northwest Territories' => [
                'Yellowknife', 'Inuvik', 'Hay River', 'Fort Smith', 'Fort Simpson',
            ],
            'Nunavut' => [
                'Iqaluit', 'Rankin Inlet', 'Arviat', 'Baker Lake', 'Cambridge Bay',
            ],
            'Yukon' => [
                'Whitehorse', 'Dawson City', 'Watson Lake', 'Haines Junction', 'Carmacks',
            ],
        ];

        foreach ($data as $provinceName => $cities) {
            $state = State::where('name', $provinceName)->where('country_id', 38)->first();

            if (! $state) {
                continue;
            }

            foreach ($cities as $cityName) {
                City::firstOrCreate(['name' => $cityName, 'state_id' => $state->id]);
            }
        }
    }
}
