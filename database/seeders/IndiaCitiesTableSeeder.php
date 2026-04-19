<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class IndiaCitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Andhra Pradesh' => [
                'Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool',
                'Tirupati', 'Rajahmundry', 'Kakinada', 'Kadapa', 'Anantapur',
                'Eluru', 'Ongole', 'Vizianagaram', 'Srikakulam', 'Chittoor',
            ],
            'Arunachal Pradesh' => [
                'Itanagar', 'Naharlagun', 'Pasighat', 'Bomdila', 'Tawang',
                'Ziro', 'Along', 'Tezu', 'Roing',
            ],
            'Assam' => [
                'Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon',
                'Tinsukia', 'Tezpur', 'Bongaigaon', 'Dhubri', 'Lakhimpur',
                'Diphu', 'Karimganj', 'Goalpara', 'Sivasagar', 'Haflong',
            ],
            'Bihar' => [
                'Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Darbhanga',
                'Purnia', 'Bihar Sharif', 'Arrah', 'Begusarai', 'Katihar',
                'Munger', 'Chhapra', 'Saharsa', 'Hajipur', 'Sitamarhi',
            ],
            'Chhattisgarh' => [
                'Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Durg',
                'Rajnandgaon', 'Jagdalpur', 'Ambikapur', 'Raigarh', 'Chirmiri',
                'Dhamtari', 'Mahasamund', 'Kanker',
            ],
            'Goa' => [
                'Panaji', 'Margao', 'Vasco da Gama', 'Mapusa', 'Ponda',
                'Calangute', 'Bicholim', 'Sanquelim', 'Curchorem', 'Canacona',
            ],
            'Gujarat' => [
                'Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar',
                'Jamnagar', 'Junagadh', 'Gandhinagar', 'Anand', 'Bharuch',
                'Morbi', 'Nadiad', 'Mehsana', 'Surendranagar', 'Amreli',
                'Patan', 'Godhra', 'Valsad', 'Navsari', 'Botad',
            ],
            'Haryana' => [
                'Faridabad', 'Gurugram', 'Panipat', 'Ambala', 'Yamunanagar',
                'Rohtak', 'Hisar', 'Karnal', 'Sonipat', 'Panchkula',
                'Bhiwani', 'Sirsa', 'Bahadurgarh', 'Rewari', 'Kaithal',
                'Kurukshetra', 'Palwal', 'Fatehabad',
            ],
            'Himachal Pradesh' => [
                'Shimla', 'Dharamsala', 'Mandi', 'Solan', 'Kullu',
                'Manali', 'Bilaspur', 'Hamirpur', 'Chamba', 'Una',
                'Palampur', 'Nahan', 'Sundernagar',
            ],
            'Jharkhand' => [
                'Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Deoghar',
                'Hazaribagh', 'Giridih', 'Ramgarh', 'Dumka', 'Chaibasa',
                'Phusro', 'Medininagar', 'Chirkunda',
            ],
            'Karnataka' => [
                'Bengaluru', 'Mysuru', 'Mangaluru', 'Hubballi', 'Belagavi',
                'Davanagere', 'Ballari', 'Tumakuru', 'Shivamogga', 'Bidar',
                'Kalaburagi', 'Udupi', 'Hassan', 'Vijayapura', 'Dharwad',
                'Raichur', 'Bagalkot', 'Gadag', 'Koppal', 'Chikkamagaluru',
                'Mandya', 'Chitradurga', 'Hassan', 'Kolar',
            ],
            'Kerala' => [
                'Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam',
                'Palakkad', 'Alappuzha', 'Kottayam', 'Kannur', 'Malappuram',
                'Kasaragod', 'Pathanamthitta', 'Idukki', 'Wayanad', 'Ernakulam',
                'Thalassery', 'Ponnani', 'Vatakara',
            ],
            'Madhya Pradesh' => [
                'Bhopal', 'Indore', 'Jabalpur', 'Gwalior', 'Ujjain',
                'Sagar', 'Dewas', 'Satna', 'Ratlam', 'Rewa',
                'Singrauli', 'Burhanpur', 'Khandwa', 'Bhind', 'Chhindwara',
                'Guna', 'Shivpuri', 'Vidisha', 'Damoh', 'Mandsaur',
                'Khargone', 'Neemuch', 'Seoni', 'Hoshangabad',
            ],
            'Maharashtra' => [
                'Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Aurangabad',
                'Solapur', 'Kolhapur', 'Thane', 'Navi Mumbai', 'Pimpri-Chinchwad',
                'Amravati', 'Nanded', 'Sangli', 'Jalgaon', 'Akola',
                'Latur', 'Dhule', 'Ahmednagar', 'Chandrapur', 'Parbhani',
                'Ichalkaranji', 'Jalna', 'Ambarnath', 'Bhiwandi', 'Satara',
                'Ratnagiri', 'Wardha', 'Osmanabad',
            ],
            'Manipur' => [
                'Imphal', 'Thoubal', 'Kakching', 'Churachandpur', 'Bishnupur',
                'Senapati', 'Ukhrul', 'Chandel', 'Tamenglong',
            ],
            'Meghalaya' => [
                'Shillong', 'Tura', 'Jowai', 'Nongstoin', 'Williamnagar',
                'Baghmara', 'Resubelpara', 'Mairang',
            ],
            'Mizoram' => [
                'Aizawl', 'Lunglei', 'Champhai', 'Serchhip', 'Kolasib',
                'Lawngtlai', 'Saiha', 'Mamit',
            ],
            'Nagaland' => [
                'Kohima', 'Dimapur', 'Mokokchung', 'Tuensang', 'Wokha',
                'Zunheboto', 'Phek', 'Mon', 'Longleng',
            ],
            'Odisha' => [
                'Bhubaneswar', 'Cuttack', 'Rourkela', 'Brahmapur', 'Sambalpur',
                'Puri', 'Balasore', 'Baripada', 'Bhadrak', 'Jharsuguda',
                'Koraput', 'Berhampur', 'Barbil', 'Jeypore', 'Kendujhar',
                'Bolangir', 'Paradip', 'Rayagada', 'Sundargarh',
            ],
            'Punjab' => [
                'Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda',
                'Mohali', 'Pathankot', 'Hoshiarpur', 'Batala', 'Moga',
                'Firozpur', 'Kapurthala', 'Gurdaspur', 'Ropar', 'Sangrur',
                'Faridkot', 'Muktsar', 'Barnala', 'Mansa',
            ],
            'Rajasthan' => [
                'Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Ajmer',
                'Udaipur', 'Bhilwara', 'Alwar', 'Bharatpur', 'Sikar',
                'Pali', 'Sri Ganganagar', 'Tonk', 'Hanumangarh', 'Nagaur',
                'Barmer', 'Jaisalmer', 'Bundi', 'Chittorgarh', 'Sirohi',
                'Jhunjhunu', 'Dungarpur', 'Sawai Madhopur', 'Banswara',
            ],
            'Sikkim' => [
                'Gangtok', 'Namchi', 'Gyalshing', 'Mangan', 'Rangpo',
                'Ravangla', 'Jorethang', 'Singtam',
            ],
            'Tamil Nadu' => [
                'Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem',
                'Tirunelveli', 'Tiruppur', 'Vellore', 'Erode', 'Thoothukudi',
                'Dindigul', 'Thanjavur', 'Ranipet', 'Sivakasi', 'Karur',
                'Udhagamandalam', 'Hosur', 'Nagercoil', 'Kancheepuram', 'Kumbakonam',
                'Cuddalore', 'Krishnagiri', 'Ambattur', 'Tambaram', 'Avadi',
            ],
            'Telangana' => [
                'Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Khammam',
                'Ramagundam', 'Mahbubnagar', 'Nalgonda', 'Adilabad', 'Suryapet',
                'Miryalaguda', 'Jagtial', 'Mancherial', 'Kothagudem', 'Siddipet',
                'Sangareddy', 'Secunderabad', 'Bhongir',
            ],
            'Tripura' => [
                'Agartala', 'Udaipur', 'Dharmanagar', 'Kailasahar', 'Belonia',
                'Sabroom', 'Ambassa', 'Khowai',
            ],
            'Uttar Pradesh' => [
                'Lucknow', 'Kanpur', 'Agra', 'Varanasi', 'Meerut',
                'Prayagraj', 'Bareilly', 'Aligarh', 'Moradabad', 'Saharanpur',
                'Gorakhpur', 'Ghaziabad', 'Noida', 'Mathura', 'Firozabad',
                'Muzaffarnagar', 'Jhansi', 'Dehradun', 'Rampur', 'Shahjahanpur',
                'Bulandshahr', 'Hapur', 'Etawah', 'Ayodhya', 'Loni',
                'Unnao', 'Hardoi', 'Sitapur', 'Jaunpur', 'Ambedkar Nagar',
            ],
            'Uttarakhand' => [
                'Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rudrapur',
                'Nainital', 'Rishikesh', 'Kashipur', 'Kotdwar', 'Mussoorie',
                'Pithoragarh', 'Almora', 'Bageshwar', 'Chamoli', 'Tehri',
            ],
            'West Bengal' => [
                'Kolkata', 'Howrah', 'Durgapur', 'Asansol', 'Siliguri',
                'Bardhaman', 'Malda', 'Baharampur', 'Habra', 'Kharagpur',
                'Jalpaiguri', 'Raiganj', 'Krishnanagar', 'Haldia', 'Bankura',
                'Purulia', 'Cooch Behar', 'Balurghat', 'Midnapore', 'Bally',
                'Barasat', 'North Dum Dum', 'Panihati', 'South Dum Dum',
            ],
            // Union Territories
            'Andaman and Nicobar Islands' => [
                'Port Blair', 'Diglipur', 'Rangat', 'Car Nicobar', 'Mayabunder',
            ],
            'Chandigarh' => [
                'Chandigarh',
            ],
            'Dadra and Nagar Haveli and Daman and Diu' => [
                'Daman', 'Diu', 'Silvassa', 'Amli',
            ],
            'Delhi' => [
                'New Delhi', 'Dwarka', 'Rohini', 'Shahdara', 'Janakpuri',
                'Laxmi Nagar', 'Preet Vihar', 'Pitampura', 'Shalimar Bagh',
                'Karol Bagh', 'Connaught Place', 'Saket', 'Vasant Kunj',
                'Nehru Place', 'East Delhi', 'West Delhi', 'North Delhi', 'South Delhi',
            ],
            'Jammu and Kashmir' => [
                'Srinagar', 'Jammu', 'Anantnag', 'Sopore', 'Baramulla',
                'Kathua', 'Udhampur', 'Punch', 'Rajouri', 'Kupwara',
                'Pulwama', 'Budgam', 'Bandipora',
            ],
            'Ladakh' => [
                'Leh', 'Kargil', 'Diskit', 'Padum',
            ],
            'Lakshadweep' => [
                'Kavaratti', 'Agatti', 'Amini', 'Andrott',
            ],
            'Puducherry' => [
                'Puducherry', 'Karaikal', 'Mahe', 'Yanam', 'Ozhukarai',
            ],
        ];

        foreach ($data as $stateName => $cities) {
            $state = State::where('name', $stateName)->where('country_id', 95)->first();

            if (! $state) {
                continue;
            }

            foreach ($cities as $cityName) {
                City::firstOrCreate(['name' => $cityName, 'state_id' => $state->id]);
            }
        }
    }
}
