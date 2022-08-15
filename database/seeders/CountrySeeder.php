<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=CountrySeeder

        DB::table('countries')->delete();

		$countries = array(
			array(
				'id' => 1,
				'country_code' => 'US',
				'country_name' => 'United States'
			),
			array(
				'id' => 2,
				'country_code' => 'CA',
				'country_name' => 'Canada'
			),
			array(
				'id' => 3,
				'country_code' => 'AF',
				'country_name' => 'Afghanistan'
			),
			array(
				'id' => 4,
				'country_code' => 'AL',
				'country_name' => 'Albania'
			),
			array(
				'id' => 5,
				'country_code' => 'DZ',
				'country_name' => 'Algeria'
			),
			array(
				'id' => 6,
				'country_code' => 'DS',
				'country_name' => 'American Samoa'
			),
			array(
				'id' => 7,
				'country_code' => 'AD',
				'country_name' => 'Andorra'
			),
			array(
				'id' => 8,
				'country_code' => 'AO',
				'country_name' => 'Angola'
			),
			array(
				'id' => 9,
				'country_code' => 'AI',
				'country_name' => 'Anguilla'
			),
			array(
				'id' => 10,
				'country_code' => 'AQ',
				'country_name' => 'Antarctica'
			),
			array(
				'id' => 11,
				'country_code' => 'AG',
				'country_name' => 'Antigua and/or Barbuda'
			),
			array(
				'id' => 12,
				'country_code' => 'AR',
				'country_name' => 'Argentina'
			),
			array(
				'id' => 13,
				'country_code' => 'AM',
				'country_name' => 'Armenia'
			),
			array(
				'id' => 14,
				'country_code' => 'AW',
				'country_name' => 'Aruba'
			),
			array(
				'id' => 15,
				'country_code' => 'AU',
				'country_name' => 'Australia'
			),
			array(
				'id' => 16,
				'country_code' => 'AT',
				'country_name' => 'Austria'
			),
			array(
				'id' => 17,
				'country_code' => 'AZ',
				'country_name' => 'Azerbaijan'
			),
			array(
				'id' => 18,
				'country_code' => 'BS',
				'country_name' => 'Bahamas'
			),
			array(
				'id' => 19,
				'country_code' => 'BH',
				'country_name' => 'Bahrain'
			),
			array(
				'id' => 20,
				'country_code' => 'BD',
				'country_name' => 'Bangladesh'
			),
			array(
				'id' => 21,
				'country_code' => 'BB',
				'country_name' => 'Barbados'
			),
			array(
				'id' => 22,
				'country_code' => 'BY',
				'country_name' => 'Belarus'
			),
			array(
				'id' => 23,
				'country_code' => 'BE',
				'country_name' => 'Belgium'
			),
			array(
				'id' => 24,
				'country_code' => 'BZ',
				'country_name' => 'Belize'
			),
			array(
				'id' => 25,
				'country_code' => 'BJ',
				'country_name' => 'Benin'
			),
			array(
				'id' => 26,
				'country_code' => 'BM',
				'country_name' => 'Bermuda'
			),
			array(
				'id' => 27,
				'country_code' => 'BT',
				'country_name' => 'Bhutan'
			),
			array(
				'id' => 28,
				'country_code' => 'BO',
				'country_name' => 'Bolivia'
			),
			array(
				'id' => 29,
				'country_code' => 'BA',
				'country_name' => 'Bosnia and Herzegovina'
			),
			array(
				'id' => 30,
				'country_code' => 'BW',
				'country_name' => 'Botswana'
			),
			array(
				'id' => 31,
				'country_code' => 'BV',
				'country_name' => 'Bouvet Island'
			),
			array(
				'id' => 32,
				'country_code' => 'BR',
				'country_name' => 'Brazil'
			),
			array(
				'id' => 33,
				'country_code' => 'IO',
				'country_name' => 'British lndian Ocean Territory'
			),
			array(
				'id' => 34,
				'country_code' => 'BN',
				'country_name' => 'Brunei Darussalam'
			),
			array(
				'id' => 35,
				'country_code' => 'BG',
				'country_name' => 'Bulgaria'
			),
			array(
				'id' => 36,
				'country_code' => 'BF',
				'country_name' => 'Burkina Faso'
			),
			array(
				'id' => 37,
				'country_code' => 'BI',
				'country_name' => 'Burundi'
			),
			array(
				'id' => 38,
				'country_code' => 'KH',
				'country_name' => 'Cambodia'
			),
			array(
				'id' => 39,
				'country_code' => 'CM',
				'country_name' => 'Cameroon'
			),
			array(
				'id' => 40,
				'country_code' => 'CV',
				'country_name' => 'Cape Verde'
			),
			array(
				'id' => 41,
				'country_code' => 'KY',
				'country_name' => 'Cayman Islands'
			),
			array(
				'id' => 42,
				'country_code' => 'CF',
				'country_name' => 'Central African Republic'
			),
			array(
				'id' => 43,
				'country_code' => 'TD',
				'country_name' => 'Chad'
			),
			array(
				'id' => 44,
				'country_code' => 'CL',
				'country_name' => 'Chile'
			),
			array(
				'id' => 45,
				'country_code' => 'CN',
				'country_name' => 'China'
			),
			array(
				'id' => 46,
				'country_code' => 'CX',
				'country_name' => 'Christmas Island'
			),
			array(
				'id' => 47,
				'country_code' => 'CC',
				'country_name' => 'Cocos (Keeling) Islands'
			),
			array(
				'id' => 48,
				'country_code' => 'CO',
				'country_name' => 'Colombia'
			),
			array(
				'id' => 49,
				'country_code' => 'KM',
				'country_name' => 'Comoros'
			),
			array(
				'id' => 50,
				'country_code' => 'CG',
				'country_name' => 'Congo'
			),
			array(
				'id' => 51,
				'country_code' => 'CK',
				'country_name' => 'Cook Islands'
			),
			array(
				'id' => 52,
				'country_code' => 'CR',
				'country_name' => 'Costa Rica'
			),
			array(
				'id' => 53,
				'country_code' => 'HR',
				'country_name' => 'Croatia (Hrvatska)'
			),
			array(
				'id' => 54,
				'country_code' => 'CU',
				'country_name' => 'Cuba'
			),
			array(
				'id' => 55,
				'country_code' => 'CY',
				'country_name' => 'Cyprus'
			),
			array(
				'id' => 56,
				'country_code' => 'CZ',
				'country_name' => 'Czech Republic'
			),
			array(
				'id' => 57,
				'country_code' => 'DK',
				'country_name' => 'Denmark'
			),
			array(
				'id' => 58,
				'country_code' => 'DJ',
				'country_name' => 'Djibouti'
			),
			array(
				'id' => 59,
				'country_code' => 'DM',
				'country_name' => 'Dominica'
			),
			array(
				'id' => 60,
				'country_code' => 'DO',
				'country_name' => 'Dominican Republic'
			),
			array(
				'id' => 61,
				'country_code' => 'TP',
				'country_name' => 'East Timor'
			),
			array(
				'id' => 62,
				'country_code' => 'EC',
				'country_name' => 'Ecudaor'
			),
			array(
				'id' => 63,
				'country_code' => 'EG',
				'country_name' => 'Egypt'
			),
			array(
				'id' => 64,
				'country_code' => 'SV',
				'country_name' => 'El Salvador'
			),
			array(
				'id' => 65,
				'country_code' => 'GQ',
				'country_name' => 'Equatorial Guinea'
			),
			array(
				'id' => 66,
				'country_code' => 'ER',
				'country_name' => 'Eritrea'
			),
			array(
				'id' => 67,
				'country_code' => 'EE',
				'country_name' => 'Estonia'
			),
			array(
				'id' => 68,
				'country_code' => 'ET',
				'country_name' => 'Ethiopia'
			),
			array(
				'id' => 69,
				'country_code' => 'FK',
				'country_name' => 'Falkland Islands (Malvinas)'
			),
			array(
				'id' => 70,
				'country_code' => 'FO',
				'country_name' => 'Faroe Islands'
			),
			array(
				'id' => 71,
				'country_code' => 'FJ',
				'country_name' => 'Fiji'
			),
			array(
				'id' => 72,
				'country_code' => 'FI',
				'country_name' => 'Finland'
			),
			array(
				'id' => 73,
				'country_code' => 'FR',
				'country_name' => 'France'
			),
			array(
				'id' => 74,
				'country_code' => 'FX',
				'country_name' => 'France, Metropolitan'
			),
			array(
				'id' => 75,
				'country_code' => 'GF',
				'country_name' => 'French Guiana'
			),
			array(
				'id' => 76,
				'country_code' => 'PF',
				'country_name' => 'French Polynesia'
			),
			array(
				'id' => 77,
				'country_code' => 'TF',
				'country_name' => 'French Southern Territories'
			),
			array(
				'id' => 78,
				'country_code' => 'GA',
				'country_name' => 'Gabon'
			),
			array(
				'id' => 79,
				'country_code' => 'GM',
				'country_name' => 'Gambia'
			),
			array(
				'id' => 80,
				'country_code' => 'GE',
				'country_name' => 'Georgia'
			),
			array(
				'id' => 81,
				'country_code' => 'DE',
				'country_name' => 'Germany'
			),
			array(
				'id' => 82,
				'country_code' => 'GH',
				'country_name' => 'Ghana'
			),
			array(
				'id' => 83,
				'country_code' => 'GI',
				'country_name' => 'Gibraltar'
			),
			array(
				'id' => 84,
				'country_code' => 'GR',
				'country_name' => 'Greece'
			),
			array(
				'id' => 85,
				'country_code' => 'GL',
				'country_name' => 'Greenland'
			),
			array(
				'id' => 86,
				'country_code' => 'GD',
				'country_name' => 'Grenada'
			),
			array(
				'id' => 87,
				'country_code' => 'GP',
				'country_name' => 'Guadeloupe'
			),
			array(
				'id' => 88,
				'country_code' => 'GU',
				'country_name' => 'Guam'
			),
			array(
				'id' => 89,
				'country_code' => 'GT',
				'country_name' => 'Guatemala'
			),
			array(
				'id' => 90,
				'country_code' => 'GN',
				'country_name' => 'Guinea'
			),
			array(
				'id' => 91,
				'country_code' => 'GW',
				'country_name' => 'Guinea-Bissau'
			),
			array(
				'id' => 92,
				'country_code' => 'GY',
				'country_name' => 'Guyana'
			),
			array(
				'id' => 93,
				'country_code' => 'HT',
				'country_name' => 'Haiti'
			),
			array(
				'id' => 94,
				'country_code' => 'HM',
				'country_name' => 'Heard and Mc Donald Islands'
			),
			array(
				'id' => 95,
				'country_code' => 'HN',
				'country_name' => 'Honduras'
			),
			array(
				'id' => 96,
				'country_code' => 'HK',
				'country_name' => 'Hong Kong'
			),
			array(
				'id' => 97,
				'country_code' => 'HU',
				'country_name' => 'Hungary'
			),
			array(
				'id' => 98,
				'country_code' => 'IS',
				'country_name' => 'Iceland'
			),
			array(
				'id' => 99,
				'country_code' => 'IN',
				'country_name' => 'India'
			),
			array(
				'id' => 100,
				'country_code' => 'ID',
				'country_name' => 'Indonesia'
			),
			array(
				'id' => 101,
				'country_code' => 'IR',
				'country_name' => 'Iran (Islamic Republic of)'
			),
			array(
				'id' => 102,
				'country_code' => 'IQ',
				'country_name' => 'Iraq'
			),
			array(
				'id' => 103,
				'country_code' => 'IE',
				'country_name' => 'Ireland'
			),
			array(
				'id' => 104,
				'country_code' => 'IL',
				'country_name' => 'Israel'
			),
			array(
				'id' => 105,
				'country_code' => 'IT',
				'country_name' => 'Italy'
			),
			array(
				'id' => 106,
				'country_code' => 'CI',
				'country_name' => 'Ivory Coast'
			),
			array(
				'id' => 107,
				'country_code' => 'JM',
				'country_name' => 'Jamaica'
			),
			array(
				'id' => 108,
				'country_code' => 'JP',
				'country_name' => 'Japan'
			),
			array(
				'id' => 109,
				'country_code' => 'JO',
				'country_name' => 'Jordan'
			),
			array(
				'id' => 110,
				'country_code' => 'KZ',
				'country_name' => 'Kazakhstan'
			),
			array(
				'id' => 111,
				'country_code' => 'KE',
				'country_name' => 'Kenya'
			),
			array(
				'id' => 112,
				'country_code' => 'KI',
				'country_name' => 'Kiribati'
			),
			array(
				'id' => 113,
				'country_code' => 'KP',
				'country_name' => 'Korea, Democratic People\'s Republic of'
			),
			array(
				'id' => 114,
				'country_code' => 'KR',
				'country_name' => 'Korea, Republic of'
			),
			array(
				'id' => 115,
				'country_code' => 'KW',
				'country_name' => 'Kuwait'
			),
			array(
				'id' => 116,
				'country_code' => 'KG',
				'country_name' => 'Kyrgyzstan'
			),
			array(
				'id' => 117,
				'country_code' => 'LA',
				'country_name' => 'Lao People\'s Democratic Republic'
			),
			array(
				'id' => 118,
				'country_code' => 'LV',
				'country_name' => 'Latvia'
			),
			array(
				'id' => 119,
				'country_code' => 'LB',
				'country_name' => 'Lebanon'
			),
			array(
				'id' => 120,
				'country_code' => 'LS',
				'country_name' => 'Lesotho'
			),
			array(
				'id' => 121,
				'country_code' => 'LR',
				'country_name' => 'Liberia'
			),
			array(
				'id' => 122,
				'country_code' => 'LY',
				'country_name' => 'Libyan Arab Jamahiriya'
			),
			array(
				'id' => 123,
				'country_code' => 'LI',
				'country_name' => 'Liechtenstein'
			),
			array(
				'id' => 124,
				'country_code' => 'LT',
				'country_name' => 'Lithuania'
			),
			array(
				'id' => 125,
				'country_code' => 'LU',
				'country_name' => 'Luxembourg'
			),
			array(
				'id' => 126,
				'country_code' => 'MO',
				'country_name' => 'Macau'
			),
			array(
				'id' => 127,
				'country_code' => 'MK',
				'country_name' => 'Macedonia'
			),
			array(
				'id' => 128,
				'country_code' => 'MG',
				'country_name' => 'Madagascar'
			),
			array(
				'id' => 129,
				'country_code' => 'MW',
				'country_name' => 'Malawi'
			),
			array(
				'id' => 130,
				'country_code' => 'MY',
				'country_name' => 'Malaysia'
			),
			array(
				'id' => 131,
				'country_code' => 'MV',
				'country_name' => 'Maldives'
			),
			array(
				'id' => 132,
				'country_code' => 'ML',
				'country_name' => 'Mali'
			),
			array(
				'id' => 133,
				'country_code' => 'MT',
				'country_name' => 'Malta'
			),
			array(
				'id' => 134,
				'country_code' => 'MH',
				'country_name' => 'Marshall Islands'
			),
			array(
				'id' => 135,
				'country_code' => 'MQ',
				'country_name' => 'Martinique'
			),
			array(
				'id' => 136,
				'country_code' => 'MR',
				'country_name' => 'Mauritania'
			),
			array(
				'id' => 137,
				'country_code' => 'MU',
				'country_name' => 'Mauritius'
			),
			array(
				'id' => 138,
				'country_code' => 'TY',
				'country_name' => 'Mayotte'
			),
			array(
				'id' => 139,
				'country_code' => 'MX',
				'country_name' => 'Mexico'
			),
			array(
				'id' => 140,
				'country_code' => 'FM',
				'country_name' => 'Micronesia, Federated States of'
			),
			array(
				'id' => 141,
				'country_code' => 'MD',
				'country_name' => 'Moldova, Republic of'
			),
			array(
				'id' => 142,
				'country_code' => 'MC',
				'country_name' => 'Monaco'
			),
			array(
				'id' => 143,
				'country_code' => 'MN',
				'country_name' => 'Mongolia'
			),
			array(
				'id' => 144,
				'country_code' => 'MS',
				'country_name' => 'Montserrat'
			),
			array(
				'id' => 145,
				'country_code' => 'MA',
				'country_name' => 'Morocco'
			),
			array(
				'id' => 146,
				'country_code' => 'MZ',
				'country_name' => 'Mozambique'
			),
			array(
				'id' => 147,
				'country_code' => 'MM',
				'country_name' => 'Myanmar'
			),
			array(
				'id' => 148,
				'country_code' => 'NA',
				'country_name' => 'Namibia'
			),
			array(
				'id' => 149,
				'country_code' => 'NR',
				'country_name' => 'Nauru'
			),
			array(
				'id' => 150,
				'country_code' => 'NP',
				'country_name' => 'Nepal'
			),
			array(
				'id' => 151,
				'country_code' => 'NL',
				'country_name' => 'Netherlands'
			),
			array(
				'id' => 152,
				'country_code' => 'AN',
				'country_name' => 'Netherlands Antilles'
			),
			array(
				'id' => 153,
				'country_code' => 'NC',
				'country_name' => 'New Caledonia'
			),
			array(
				'id' => 154,
				'country_code' => 'NZ',
				'country_name' => 'New Zealand'
			),
			array(
				'id' => 155,
				'country_code' => 'NI',
				'country_name' => 'Nicaragua'
			),
			array(
				'id' => 156,
				'country_code' => 'NE',
				'country_name' => 'Niger'
			),
			array(
				'id' => 157,
				'country_code' => 'NG',
				'country_name' => 'Nigeria'
			),
			array(
				'id' => 158,
				'country_code' => 'NU',
				'country_name' => 'Niue'
			),
			array(
				'id' => 159,
				'country_code' => 'NF',
				'country_name' => 'Norfork Island'
			),
			array(
				'id' => 160,
				'country_code' => 'MP',
				'country_name' => 'Northern Mariana Islands'
			),
			array(
				'id' => 161,
				'country_code' => 'NO',
				'country_name' => 'Norway'
			),
			array(
				'id' => 162,
				'country_code' => 'OM',
				'country_name' => 'Oman'
			),
			array(
				'id' => 163,
				'country_code' => 'PK',
				'country_name' => 'Pakistan'
			),
			array(
				'id' => 164,
				'country_code' => 'PW',
				'country_name' => 'Palau'
			),
			array(
				'id' => 165,
				'country_code' => 'PA',
				'country_name' => 'Panama'
			),
			array(
				'id' => 166,
				'country_code' => 'PG',
				'country_name' => 'Papua New Guinea'
			),
			array(
				'id' => 167,
				'country_code' => 'PY',
				'country_name' => 'Paraguay'
			),
			array(
				'id' => 168,
				'country_code' => 'PE',
				'country_name' => 'Peru'
			),
			array(
				'id' => 169,
				'country_code' => 'PH',
				'country_name' => 'Philippines'
			),
			array(
				'id' => 170,
				'country_code' => 'PN',
				'country_name' => 'Pitcairn'
			),
			array(
				'id' => 171,
				'country_code' => 'PL',
				'country_name' => 'Poland'
			),
			array(
				'id' => 172,
				'country_code' => 'PT',
				'country_name' => 'Portugal'
			),
			array(
				'id' => 173,
				'country_code' => 'PR',
				'country_name' => 'Puerto Rico'
			),
			array(
				'id' => 174,
				'country_code' => 'QA',
				'country_name' => 'Qatar'
			),
			array(
				'id' => 175,
				'country_code' => 'RE',
				'country_name' => 'Reunion'
			),
			array(
				'id' => 176,
				'country_code' => 'RO',
				'country_name' => 'Romania'
			),
			array(
				'id' => 177,
				'country_code' => 'RU',
				'country_name' => 'Russian Federation'
			),
			array(
				'id' => 178,
				'country_code' => 'RW',
				'country_name' => 'Rwanda'
			),
			array(
				'id' => 179,
				'country_code' => 'KN',
				'country_name' => 'Saint Kitts and Nevis'
			),
			array(
				'id' => 180,
				'country_code' => 'LC',
				'country_name' => 'Saint Lucia'
			),
			array(
				'id' => 181,
				'country_code' => 'VC',
				'country_name' => 'Saint Vincent and the Grenadines'
			),
			array(
				'id' => 182,
				'country_code' => 'WS',
				'country_name' => 'Samoa'
			),
			array(
				'id' => 183,
				'country_code' => 'SM',
				'country_name' => 'San Marino'
			),
			array(
				'id' => 184,
				'country_code' => 'ST',
				'country_name' => 'Sao Tome and Principe'
			),
			array(
				'id' => 185,
				'country_code' => 'SA',
				'country_name' => 'Saudi Arabia'
			),
			array(
				'id' => 186,
				'country_code' => 'SN',
				'country_name' => 'Senegal'
			),
			array(
				'id' => 187,
				'country_code' => 'SC',
				'country_name' => 'Seychelles'
			),
			array(
				'id' => 188,
				'country_code' => 'SL',
				'country_name' => 'Sierra Leone'
			),
			array(
				'id' => 189,
				'country_code' => 'SG',
				'country_name' => 'Singapore'
			),
			array(
				'id' => 190,
				'country_code' => 'SK',
				'country_name' => 'Slovakia'
			),
			array(
				'id' => 191,
				'country_code' => 'SI',
				'country_name' => 'Slovenia'
			),
			array(
				'id' => 192,
				'country_code' => 'SB',
				'country_name' => 'Solomon Islands'
			),
			array(
				'id' => 193,
				'country_code' => 'SO',
				'country_name' => 'Somalia'
			),
			array(
				'id' => 194,
				'country_code' => 'ZA',
				'country_name' => 'South Africa'
			),
			array(
				'id' => 195,
				'country_code' => 'GS',
				'country_name' => 'South Georgia South Sandwich Islands'
			),
			array(
				'id' => 196,
				'country_code' => 'ES',
				'country_name' => 'Spain'
			),
			array(
				'id' => 197,
				'country_code' => 'LK',
				'country_name' => 'Sri Lanka'
			),
			array(
				'id' => 198,
				'country_code' => 'SH',
				'country_name' => 'St. Helena'
			),
			array(
				'id' => 199,
				'country_code' => 'PM',
				'country_name' => 'St. Pierre and Miquelon'
			),
			array(
				'id' => 200,
				'country_code' => 'SD',
				'country_name' => 'Sudan'
			),
			array(
				'id' => 201,
				'country_code' => 'SR',
				'country_name' => 'Suriname'
			),
			array(
				'id' => 202,
				'country_code' => 'SJ',
				'country_name' => 'Svalbarn and Jan Mayen Islands'
			),
			array(
				'id' => 203,
				'country_code' => 'SZ',
				'country_name' => 'Swaziland'
			),
			array(
				'id' => 204,
				'country_code' => 'SE',
				'country_name' => 'Sweden'
			),
			array(
				'id' => 205,
				'country_code' => 'CH',
				'country_name' => 'Switzerland'
			),
			array(
				'id' => 206,
				'country_code' => 'SY',
				'country_name' => 'Syrian Arab Republic'
			),
			array(
				'id' => 207,
				'country_code' => 'TW',
				'country_name' => 'Taiwan'
			),
			array(
				'id' => 208,
				'country_code' => 'TJ',
				'country_name' => 'Tajikistan'
			),
			array(
				'id' => 209,
				'country_code' => 'TZ',
				'country_name' => 'Tanzania, United Republic of'
			),
			array(
				'id' => 210,
				'country_code' => 'TH',
				'country_name' => 'Thailand'
			),
			array(
				'id' => 211,
				'country_code' => 'TG',
				'country_name' => 'Togo'
			),
			array(
				'id' => 212,
				'country_code' => 'TK',
				'country_name' => 'Tokelau'
			),
			array(
				'id' => 213,
				'country_code' => 'TO',
				'country_name' => 'Tonga'
			),
			array(
				'id' => 214,
				'country_code' => 'TT',
				'country_name' => 'Trinidad and Tobago'
			),
			array(
				'id' => 215,
				'country_code' => 'TN',
				'country_name' => 'Tunisia'
			),
			array(
				'id' => 216,
				'country_code' => 'TR',
				'country_name' => 'Turkey'
			),
			array(
				'id' => 217,
				'country_code' => 'TM',
				'country_name' => 'Turkmenistan'
			),
			array(
				'id' => 218,
				'country_code' => 'TC',
				'country_name' => 'Turks and Caicos Islands'
			),
			array(
				'id' => 219,
				'country_code' => 'TV',
				'country_name' => 'Tuvalu'
			),
			array(
				'id' => 220,
				'country_code' => 'UG',
				'country_name' => 'Uganda'
			),
			array(
				'id' => 221,
				'country_code' => 'UA',
				'country_name' => 'Ukraine'
			),
			array(
				'id' => 222,
				'country_code' => 'AE',
				'country_name' => 'United Arab Emirates'
			),
			array(
				'id' => 223,
				'country_code' => 'GB',
				'country_name' => 'United Kingdom'
			),
			array(
				'id' => 224,
				'country_code' => 'UM',
				'country_name' => 'United States minor outlying islands'
			),
			array(
				'id' => 225,
				'country_code' => 'UY',
				'country_name' => 'Uruguay'
			),
			array(
				'id' => 226,
				'country_code' => 'UZ',
				'country_name' => 'Uzbekistan'
			),
			array(
				'id' => 227,
				'country_code' => 'VU',
				'country_name' => 'Vanuatu'
			),
			array(
				'id' => 228,
				'country_code' => 'VA',
				'country_name' => 'Vatican City State'
			),
			array(
				'id' => 229,
				'country_code' => 'VE',
				'country_name' => 'Venezuela'
			),
			array(
				'id' => 230,
				'country_code' => 'VN',
				'country_name' => 'Vietnam'
			),
			array(
				'id' => 231,
				'country_code' => 'VG',
				'country_name' => 'Virigan Islands (British)'
			),
			array(
				'id' => 232,
				'country_code' => 'VI',
				'country_name' => 'Virgin Islands (U.S.)'
			),
			array(
				'id' => 233,
				'country_code' => 'WF',
				'country_name' => 'Wallis and Futuna Islands'
			),
			array(
				'id' => 234,
				'country_code' => 'EH',
				'country_name' => 'Western Sahara'
			),
			array(
				'id' => 235,
				'country_code' => 'YE',
				'country_name' => 'Yemen'
			),
			array(
				'id' => 236,
				'country_code' => 'YU',
				'country_name' => 'Yugoslavia'
			),
			array(
				'id' => 237,
				'country_code' => 'ZR',
				'country_name' => 'Zaire'
			),
			array(
				'id' => 238,
				'country_code' => 'ZM',
				'country_name' => 'Zambia'
			),
			array(
				'id' => 239,
				'country_code' => 'ZW',
				'country_name' => 'Zimbabwe'
			)
		);

		DB::table('countries')->insert($countries);
    }
}
