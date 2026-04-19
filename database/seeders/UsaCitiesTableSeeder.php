<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class UsaCitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Alabama' => [
                'Birmingham', 'Montgomery', 'Huntsville', 'Mobile', 'Tuscaloosa',
                'Hoover', 'Dothan', 'Auburn', 'Decatur', 'Madison',
                'Florence', 'Gadsden', 'Vestavia Hills', 'Phenix City', 'Prattville',
            ],
            'Alaska' => [
                'Anchorage', 'Fairbanks', 'Juneau', 'Sitka', 'Ketchikan',
                'Wasilla', 'Kenai', 'Kodiak', 'Bethel', 'Palmer',
            ],
            'Arizona' => [
                'Phoenix', 'Tucson', 'Mesa', 'Chandler', 'Scottsdale',
                'Gilbert', 'Glendale', 'Tempe', 'Peoria', 'Surprise',
                'Yuma', 'Avondale', 'Flagstaff', 'Goodyear', 'Buckeye',
                'Lake Havasu City', 'Casa Grande', 'Sierra Vista', 'Maricopa',
            ],
            'Arkansas' => [
                'Little Rock', 'Fort Smith', 'Fayetteville', 'Springdale', 'Jonesboro',
                'North Little Rock', 'Conway', 'Rogers', 'Bentonville', 'Pine Bluff',
                'Hot Springs', 'Benton', 'Texarkana', 'Sherwood', 'Jacksonville',
            ],
            'California' => [
                'Los Angeles', 'San Diego', 'San Jose', 'San Francisco', 'Fresno',
                'Sacramento', 'Long Beach', 'Oakland', 'Bakersfield', 'Anaheim',
                'Santa Ana', 'Riverside', 'Stockton', 'Chula Vista', 'Irvine',
                'Fremont', 'San Bernardino', 'Modesto', 'Fontana', 'Moreno Valley',
                'Glendale', 'Huntington Beach', 'Santa Clarita', 'Garden Grove', 'Santa Rosa',
                'Oceanside', 'Rancho Cucamonga', 'Ontario', 'Corona', 'Elk Grove',
                'Sunnyvale', 'Pomona', 'Hayward', 'Torrance', 'Pasadena',
                'Salinas', 'Orange', 'Fullerton', 'Visalia', 'Roseville',
                'Concord', 'Thousand Oaks', 'Simi Valley', 'Victorville', 'Palmdale',
                'Lancaster', 'Berkeley', 'Escondido', 'Miramar', 'Santa Clara',
            ],
            'Colorado' => [
                'Denver', 'Colorado Springs', 'Aurora', 'Fort Collins', 'Lakewood',
                'Thornton', 'Arvada', 'Westminster', 'Pueblo', 'Boulder',
                'Highlands Ranch', 'Centennial', 'Greeley', 'Longmont', 'Loveland',
                'Broomfield', 'Grand Junction', 'Castle Rock', 'Commerce City', 'Parker',
            ],
            'Connecticut' => [
                'Bridgeport', 'New Haven', 'Hartford', 'Stamford', 'Waterbury',
                'Norwalk', 'Danbury', 'New Britain', 'Meriden', 'Bristol',
                'West Haven', 'Milford', 'Middletown', 'Norwich', 'Shelton',
            ],
            'Delaware' => [
                'Wilmington', 'Dover', 'Newark', 'Middletown', 'Smyrna',
                'Milford', 'Seaford', 'Georgetown', 'Elsmere', 'New Castle',
            ],
            'Florida' => [
                'Jacksonville', 'Miami', 'Tampa', 'Orlando', 'St. Petersburg',
                'Hialeah', 'Port St. Lucie', 'Cape Coral', 'Tallahassee', 'Fort Lauderdale',
                'Pembroke Pines', 'Hollywood', 'Gainesville', 'Miramar', 'Coral Springs',
                'Clearwater', 'Miami Gardens', 'Palm Bay', 'Lakeland', 'Pompano Beach',
                'West Palm Beach', 'Davie', 'Boca Raton', 'Deltona', 'Plantation',
                'Sunrise', 'Fort Myers', 'Homestead', 'Palm Coast', 'Kissimmee',
            ],
            'Georgia' => [
                'Atlanta', 'Augusta', 'Columbus', 'Macon', 'Savannah',
                'Athens', 'Sandy Springs', 'South Fulton', 'Roswell', 'Johns Creek',
                'Albany', 'Warner Robins', 'Alpharetta', 'Marietta', 'Valdosta',
                'Smyrna', 'Brookhaven', 'Dunwoody', 'Peachtree City', 'Gainesville',
            ],
            'Hawaii' => [
                'Honolulu', 'East Honolulu', 'Pearl City', 'Hilo', 'Kailua',
                'Waipahu', 'Kaneohe', 'Mililani Town', 'Kahului', 'Ewa Gentry',
                'Kihei', 'Makakilo', 'Wahiawa', 'Halawa', 'Wailuku',
            ],
            'Idaho' => [
                'Boise', 'Meridian', 'Nampa', 'Idaho Falls', 'Pocatello',
                'Caldwell', 'Coeur d\'Alene', 'Twin Falls', 'Lewiston', 'Post Falls',
                'Rexburg', 'Moscow', 'Eagle', 'Chubbuck', 'Star',
            ],
            'Illinois' => [
                'Chicago', 'Aurora', 'Joliet', 'Naperville', 'Rockford',
                'Springfield', 'Elgin', 'Peoria', 'Champaign', 'Waukegan',
                'Cicero', 'Bloomington', 'Arlington Heights', 'Evanston', 'Decatur',
                'Schaumburg', 'Bolingbrook', 'Palatine', 'Skokie', 'Des Plaines',
                'Orland Park', 'Tinley Park', 'Oak Lawn', 'Berwyn', 'Downers Grove',
            ],
            'Indiana' => [
                'Indianapolis', 'Fort Wayne', 'Evansville', 'South Bend', 'Carmel',
                'Fishers', 'Bloomington', 'Hammond', 'Gary', 'Lafayette',
                'Muncie', 'Terre Haute', 'Kokomo', 'Anderson', 'Noblesville',
                'Greenwood', 'Elkhart', 'Mishawaka', 'Lawrence', 'Jeffersonville',
            ],
            'Iowa' => [
                'Des Moines', 'Cedar Rapids', 'Davenport', 'Sioux City', 'Iowa City',
                'Waterloo', 'Council Bluffs', 'Ames', 'West Des Moines', 'Dubuque',
                'Ankeny', 'Urbandale', 'Cedar Falls', 'Marion', 'Bettendorf',
            ],
            'Kansas' => [
                'Wichita', 'Overland Park', 'Kansas City', 'Olathe', 'Topeka',
                'Lawrence', 'Shawnee', 'Manhattan', 'Lenexa', 'Salina',
                'Hutchinson', 'Leavenworth', 'Leawood', 'Dodge City', 'Garden City',
            ],
            'Kentucky' => [
                'Louisville', 'Lexington', 'Bowling Green', 'Owensboro', 'Covington',
                'Richmond', 'Georgetown', 'Florence', 'Elizabethtown', 'Hopkinsville',
                'Nicholasville', 'Frankfort', 'Henderson', 'Jeffersontown', 'Paducah',
            ],
            'Louisiana' => [
                'New Orleans', 'Baton Rouge', 'Shreveport', 'Metairie', 'Lafayette',
                'Lake Charles', 'Kenner', 'Bossier City', 'Monroe', 'Alexandria',
                'New Iberia', 'Laplace', 'Slidell', 'Prairieville', 'Central',
            ],
            'Maine' => [
                'Portland', 'Lewiston', 'Bangor', 'South Portland', 'Auburn',
                'Biddeford', 'Sanford', 'Augusta', 'Saco', 'Westbrook',
                'Waterville', 'Brewer', 'Presque Isle', 'Bath', 'Caribou',
            ],
            'Maryland' => [
                'Baltimore', 'Frederick', 'Rockville', 'Gaithersburg', 'Bowie',
                'Hagerstown', 'Annapolis', 'College Park', 'Salisbury', 'Laurel',
                'Greenbelt', 'Cumberland', 'Westminster', 'Hyattsville', 'Takoma Park',
                'Eldersburg', 'Waldorf', 'Ellicott City', 'Columbia', 'Germantown',
            ],
            'Massachusetts' => [
                'Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge',
                'New Bedford', 'Brockton', 'Quincy', 'Lynn', 'Fall River',
                'Newton', 'Lawrence', 'Somerville', 'Haverhill', 'Waltham',
                'Malden', 'Medford', 'Taunton', 'Chicopee', 'Weymouth',
            ],
            'Michigan' => [
                'Detroit', 'Grand Rapids', 'Warren', 'Sterling Heights', 'Ann Arbor',
                'Lansing', 'Flint', 'Dearborn', 'Livonia', 'Westland',
                'Troy', 'Farmington Hills', 'Kalamazoo', 'Wyoming', 'Southfield',
                'Rochester Hills', 'Taylor', 'Pontiac', 'St. Clair Shores', 'Royal Oak',
                'Novi', 'Dearborn Heights', 'Battle Creek', 'Saginaw', 'Kentwood',
            ],
            'Minnesota' => [
                'Minneapolis', 'St. Paul', 'Rochester', 'Duluth', 'Bloomington',
                'Brooklyn Park', 'Plymouth', 'Maple Grove', 'Woodbury', 'St. Cloud',
                'Eagan', 'Eden Prairie', 'Coon Rapids', 'Burnsville', 'Blaine',
                'Lakeville', 'Minnetonka', 'Apple Valley', 'Edina', 'St. Louis Park',
            ],
            'Mississippi' => [
                'Jackson', 'Gulfport', 'Southaven', 'Hattiesburg', 'Biloxi',
                'Meridian', 'Tupelo', 'Greenville', 'Olive Branch', 'Horn Lake',
                'Clinton', 'Pearl', 'Ridgeland', 'Brandon', 'Starkville',
            ],
            'Missouri' => [
                'Kansas City', 'St. Louis', 'Springfield', 'Columbia', 'Independence',
                'Lee\'s Summit', 'O\'Fallon', 'St. Joseph', 'St. Charles', 'Blue Springs',
                'Joplin', 'Chesterfield', 'Jefferson City', 'Cape Girardeau', 'Florissant',
                'St. Peters', 'Wentzville', 'University City', 'Ballwin', 'Kirkwood',
            ],
            'Montana' => [
                'Billings', 'Missoula', 'Great Falls', 'Bozeman', 'Butte',
                'Helena', 'Kalispell', 'Havre', 'Anaconda', 'Miles City',
            ],
            'Nebraska' => [
                'Omaha', 'Lincoln', 'Bellevue', 'Grand Island', 'Kearney',
                'Fremont', 'Hastings', 'North Platte', 'Norfolk', 'Columbus',
                'Papillion', 'La Vista', 'Scottsbluff', 'South Sioux City', 'Beatrice',
            ],
            'Nevada' => [
                'Las Vegas', 'Henderson', 'Reno', 'North Las Vegas', 'Sparks',
                'Carson City', 'Fernley', 'Elko', 'Mesquite', 'Boulder City',
                'Fallon', 'Winnemucca', 'West Wendover', 'Ely', 'Yerington',
            ],
            'New Hampshire' => [
                'Manchester', 'Nashua', 'Concord', 'Derry', 'Dover',
                'Rochester', 'Salem', 'Merrimack', 'Londonderry', 'Hudson',
                'Keene', 'Portsmouth', 'Laconia', 'Lebanon', 'Claremont',
            ],
            'New Jersey' => [
                'Newark', 'Jersey City', 'Paterson', 'Elizabeth', 'Edison',
                'Woodbridge', 'Lakewood', 'Toms River', 'Hamilton', 'Trenton',
                'Clifton', 'Camden', 'Brick', 'Cherry Hill', 'Passaic',
                'Middletown', 'Union City', 'Old Bridge', 'Gloucester', 'East Orange',
                'North Bergen', 'Vineland', 'Piscataway', 'New Brunswick', 'Jackson',
            ],
            'New Mexico' => [
                'Albuquerque', 'Las Cruces', 'Rio Rancho', 'Santa Fe', 'Roswell',
                'Farmington', 'Clovis', 'Hobbs', 'Alamogordo', 'Carlsbad',
                'Gallup', 'Artesia', 'Los Lunas', 'Sunland Park', 'Deming',
            ],
            'New York' => [
                'New York City', 'Buffalo', 'Rochester', 'Yonkers', 'Syracuse',
                'Albany', 'New Rochelle', 'Mount Vernon', 'Schenectady', 'Utica',
                'White Plains', 'Hempstead', 'Troy', 'Niagara Falls', 'Binghamton',
                'Freeport', 'Valley Stream', 'Long Beach', 'Spring Valley', 'Ramapo',
                'Brookhaven', 'Islip', 'Oyster Bay', 'Smithtown', 'Huntington',
            ],
            'North Carolina' => [
                'Charlotte', 'Raleigh', 'Greensboro', 'Durham', 'Winston-Salem',
                'Fayetteville', 'Cary', 'Wilmington', 'High Point', 'Concord',
                'Greenville', 'Asheville', 'Gastonia', 'Jacksonville', 'Chapel Hill',
                'Rocky Mount', 'Burlington', 'Wilson', 'Huntersville', 'Kannapolis',
            ],
            'North Dakota' => [
                'Fargo', 'Bismarck', 'Grand Forks', 'Minot', 'West Fargo',
                'Williston', 'Dickinson', 'Mandan', 'Jamestown', 'Wahpeton',
            ],
            'Ohio' => [
                'Columbus', 'Cleveland', 'Cincinnati', 'Toledo', 'Akron',
                'Dayton', 'Parma', 'Canton', 'Youngstown', 'Lorain',
                'Hamilton', 'Springfield', 'Kettering', 'Elyria', 'Lakewood',
                'Cuyahoga Falls', 'Middletown', 'Euclid', 'Newark', 'Mansfield',
                'Mentor', 'Beavercreek', 'Cleveland Heights', 'Strongsville', 'Dublin',
            ],
            'Oklahoma' => [
                'Oklahoma City', 'Tulsa', 'Norman', 'Broken Arrow', 'Lawton',
                'Edmond', 'Moore', 'Midwest City', 'Enid', 'Stillwater',
                'Muskogee', 'Bartlesville', 'Owasso', 'Shawnee', 'Ponca City',
            ],
            'Oregon' => [
                'Portland', 'Salem', 'Eugene', 'Gresham', 'Hillsboro',
                'Beaverton', 'Bend', 'Medford', 'Springfield', 'Corvallis',
                'Albany', 'Tigard', 'Lake Oswego', 'Keizer', 'Grants Pass',
                'Oregon City', 'McMinnville', 'Redmond', 'Tualatin', 'West Linn',
            ],
            'Pennsylvania' => [
                'Philadelphia', 'Pittsburgh', 'Allentown', 'Erie', 'Reading',
                'Scranton', 'Bethlehem', 'Lancaster', 'Harrisburg', 'Altoona',
                'York', 'Wilkes-Barre', 'Chester', 'Norristown', 'State College',
                'Easton', 'Hazleton', 'McKeesport', 'Johnstown', 'Wilkinsburg',
            ],
            'Rhode Island' => [
                'Providence', 'Warwick', 'Cranston', 'Pawtucket', 'East Providence',
                'Woonsocket', 'Coventry', 'Cumberland', 'North Providence', 'South Kingstown',
            ],
            'South Carolina' => [
                'Columbia', 'Charleston', 'North Charleston', 'Mount Pleasant', 'Rock Hill',
                'Greenville', 'Summerville', 'Goose Creek', 'Hilton Head Island', 'Sumter',
                'Florence', 'Spartanburg', 'Myrtle Beach', 'Conway', 'Anderson',
            ],
            'South Dakota' => [
                'Sioux Falls', 'Rapid City', 'Aberdeen', 'Brookings', 'Watertown',
                'Mitchell', 'Yankton', 'Pierre', 'Huron', 'Vermillion',
            ],
            'Tennessee' => [
                'Nashville', 'Memphis', 'Knoxville', 'Chattanooga', 'Clarksville',
                'Murfreesboro', 'Franklin', 'Jackson', 'Johnson City', 'Bartlett',
                'Hendersonville', 'Kingsport', 'Collierville', 'Cleveland', 'Smyrna',
                'Germantown', 'Brentwood', 'Columbia', 'La Vergne', 'Gallatin',
            ],
            'Texas' => [
                'Houston', 'San Antonio', 'Dallas', 'Austin', 'Fort Worth',
                'El Paso', 'Arlington', 'Corpus Christi', 'Plano', 'Laredo',
                'Lubbock', 'Garland', 'Irving', 'Amarillo', 'Grand Prairie',
                'McKinney', 'Frisco', 'Pasadena', 'Mesquite', 'Killeen',
                'McAllen', 'Waco', 'Carrollton', 'Denton', 'Midland',
                'Abilene', 'Beaumont', 'Round Rock', 'Odessa', 'Richardson',
                'Pearland', 'Sugar Land', 'The Woodlands', 'League City', 'Tyler',
                'Brownsville', 'College Station', 'Lewisville', 'Allen', 'San Angelo',
            ],
            'Utah' => [
                'Salt Lake City', 'West Valley City', 'Provo', 'West Jordan', 'Orem',
                'Sandy', 'Ogden', 'St. George', 'Layton', 'South Jordan',
                'Taylorsville', 'Millcreek', 'Herriman', 'Lehi', 'Logan',
                'Murray', 'Draper', 'Bountiful', 'Riverton', 'Cottonwood Heights',
            ],
            'Vermont' => [
                'Burlington', 'South Burlington', 'Rutland', 'Barre', 'Montpelier',
                'Winooski', 'St. Albans', 'Middlebury', 'Brattleboro', 'Newport',
            ],
            'Virginia' => [
                'Virginia Beach', 'Norfolk', 'Chesapeake', 'Richmond', 'Newport News',
                'Alexandria', 'Hampton', 'Roanoke', 'Portsmouth', 'Suffolk',
                'Lynchburg', 'Harrisonburg', 'Charlottesville', 'Danville', 'Manassas',
                'Petersburg', 'Fredericksburg', 'Winchester', 'Staunton', 'Blacksburg',
            ],
            'Washington' => [
                'Seattle', 'Spokane', 'Tacoma', 'Vancouver', 'Bellevue',
                'Kent', 'Everett', 'Renton', 'Federal Way', 'Kirkland',
                'Bellingham', 'Kennewick', 'Yakima', 'Redmond', 'Marysville',
                'Pasco', 'Shoreline', 'Richland', 'Lakewood', 'Sammamish',
                'Burien', 'Southbridge', 'Spokane Valley', 'Bremerton', 'Olympia',
            ],
            'West Virginia' => [
                'Charleston', 'Huntington', 'Parkersburg', 'Morgantown', 'Wheeling',
                'Weirton', 'Fairmont', 'Martinsburg', 'Beckley', 'Clarksburg',
            ],
            'Wisconsin' => [
                'Milwaukee', 'Madison', 'Green Bay', 'Kenosha', 'Racine',
                'Appleton', 'Waukesha', 'Oshkosh', 'Eau Claire', 'Janesville',
                'West Allis', 'La Crosse', 'Sheboygan', 'Wauwatosa', 'Fond du Lac',
                'New Berlin', 'Wausau', 'Brookfield', 'Beloit', 'Greenfield',
            ],
            'Wyoming' => [
                'Cheyenne', 'Casper', 'Laramie', 'Gillette', 'Rock Springs',
                'Sheridan', 'Green River', 'Evanston', 'Riverton', 'Jackson',
            ],
            'District of Columbia' => [
                'Washington D.C.',
            ],
            'Puerto Rico' => [
                'San Juan', 'Bayamón', 'Carolina', 'Ponce', 'Caguas',
                'Guaynabo', 'Arecibo', 'Toa Baja', 'Mayagüez', 'Trujillo Alto',
            ],
            'Guam' => [
                'Dededo', 'Yigo', 'Tamuning', 'Mangilao', 'Barrigada',
            ],
            'U.S. Virgin Islands' => [
                'Charlotte Amalie', 'Christiansted', 'Frederiksted',
            ],
            'American Samoa' => [
                'Pago Pago', 'Tafuna', 'Aua',
            ],
            'Northern Mariana Islands' => [
                'Saipan', 'Tinian', 'Rota',
            ],
        ];

        foreach ($data as $stateName => $cities) {
            $state = State::where('name', $stateName)->where('country_id', 229)->first();

            if (! $state) {
                continue;
            }

            foreach ($cities as $cityName) {
                City::firstOrCreate(['name' => $cityName, 'state_id' => $state->id]);
            }
        }
    }
}
