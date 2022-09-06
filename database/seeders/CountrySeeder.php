<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
  public function run()
  {
    $countries = [
      [
        'country_id' => 1,
        'short_name' => 'AF',
        'country_name' => 'Afghanistan',
        'phoneCode' => 93
      ],
      [
        'country_id' => 2,
        'short_name' => 'AL',
        'country_name' => 'Albania',
        'phoneCode' => 355
      ],
      [
        'country_id' => 3,
        'short_name' => 'DZ',
        'country_name' => 'Algeria',
        'phoneCode' => 213
      ],
      [
        'country_id' => 4,
        'short_name' => 'AS',
        'country_name' => 'American Samoa',
        'phoneCode' => 1684
      ],
      [
        'country_id' => 5,
        'short_name' => 'AD',
        'country_name' => 'Andorra',
        'phoneCode' => 376
      ],
      [
        'country_id' => 6,
        'short_name' => 'AO',
        'country_name' => 'Angola',
        'phoneCode' => 244
      ],
      [
        'country_id' => 7,
        'short_name' => 'AI',
        'country_name' => 'Anguilla',
        'phoneCode' => 1264
      ],
      [
        'country_id' => 8,
        'short_name' => 'AQ',
        'country_name' => 'Antarctica',
        'phoneCode' => 0
      ],
      [
        'country_id' => 9,
        'short_name' => 'AG',
        'country_name' => 'Antigua And Barbuda',
        'phoneCode' => 1268
      ],
      [
        'country_id' => 10,
        'short_name' => 'AR',
        'country_name' => 'Argentina',
        'phoneCode' => 54
      ],
      [
        'country_id' => 11,
        'short_name' => 'AM',
        'country_name' => 'Armenia',
        'phoneCode' => 374
      ],
      [
        'country_id' => 12,
        'short_name' => 'AW',
        'country_name' => 'Aruba',
        'phoneCode' => 297
      ],
      [
        'country_id' => 13,
        'short_name' => 'AU',
        'country_name' => 'Australia',
        'phoneCode' => 61
      ],
      [
        'country_id' => 14,
        'short_name' => 'AT',
        'country_name' => 'Austria',
        'phoneCode' => 43
      ],
      [
        'country_id' => 15,
        'short_name' => 'AZ',
        'country_name' => 'Azerbaijan',
        'phoneCode' => 994
      ],
      [
        'country_id' => 16,
        'short_name' => 'BS',
        'country_name' => 'Bahamas The',
        'phoneCode' => 1242
      ],
      [
        'country_id' => 17,
        'short_name' => 'BH',
        'country_name' => 'Bahrain',
        'phoneCode' => 973
      ],
      [
        'country_id' => 18,
        'short_name' => 'BD',
        'country_name' => 'Bangladesh',
        'phoneCode' => 880
      ],
      [
        'country_id' => 19,
        'short_name' => 'BB',
        'country_name' => 'Barbados',
        'phoneCode' => 1246
      ],
      [
        'country_id' => 20,
        'short_name' => 'BY',
        'country_name' => 'Belarus',
        'phoneCode' => 375
      ],
      [
        'country_id' => 21,
        'short_name' => 'BE',
        'country_name' => 'Belgium',
        'phoneCode' => 32
      ],
      [
        'country_id' => 22,
        'short_name' => 'BZ',
        'country_name' => 'Belize',
        'phoneCode' => 501
      ],
      [
        'country_id' => 23,
        'short_name' => 'BJ',
        'country_name' => 'Benin',
        'phoneCode' => 229
      ],
      [
        'country_id' => 24,
        'short_name' => 'BM',
        'country_name' => 'Bermuda',
        'phoneCode' => 1441
      ],
      [
        'country_id' => 25,
        'short_name' => 'BT',
        'country_name' => 'Bhutan',
        'phoneCode' => 975
      ],
      [
        'country_id' => 26,
        'short_name' => 'BO',
        'country_name' => 'Bolivia',
        'phoneCode' => 591
      ],
      [
        'country_id' => 27,
        'short_name' => 'BA',
        'country_name' => 'Bosnia and Herzegovina',
        'phoneCode' => 387
      ],
      [
        'country_id' => 28,
        'short_name' => 'BW',
        'country_name' => 'Botswana',
        'phoneCode' => 267
      ],
      [
        'country_id' => 29,
        'short_name' => 'BV',
        'country_name' => 'Bouvet Island',
        'phoneCode' => 0
      ],
      [
        'country_id' => 30,
        'short_name' => 'BR',
        'country_name' => 'Brazil',
        'phoneCode' => 55
      ],
      [
        'country_id' => 31,
        'short_name' => 'IO',
        'country_name' => 'British Indian Ocean Territory',
        'phoneCode' => 246
      ],
      [
        'country_id' => 32,
        'short_name' => 'BN',
        'country_name' => 'Brunei',
        'phoneCode' => 673
      ],
      [
        'country_id' => 33,
        'short_name' => 'BG',
        'country_name' => 'Bulgaria',
        'phoneCode' => 359
      ],
      [
        'country_id' => 34,
        'short_name' => 'BF',
        'country_name' => 'Burkina Faso',
        'phoneCode' => 226
      ],
      [
        'country_id' => 35,
        'short_name' => 'BI',
        'country_name' => 'Burundi',
        'phoneCode' => 257
      ],
      [
        'country_id' => 36,
        'short_name' => 'KH',
        'country_name' => 'Cambodia',
        'phoneCode' => 855
      ],
      [
        'country_id' => 37,
        'short_name' => 'CM',
        'country_name' => 'Cameroon',
        'phoneCode' => 237
      ],
      [
        'country_id' => 38,
        'short_name' => 'CA',
        'country_name' => 'Canada',
        'phoneCode' => 1
      ],
      [
        'country_id' => 39,
        'short_name' => 'CV',
        'country_name' => 'Cape Verde',
        'phoneCode' => 238
      ],
      [
        'country_id' => 40,
        'short_name' => 'KY',
        'country_name' => 'Cayman Islands',
        'phoneCode' => 1345
      ],
      [
        'country_id' => 41,
        'short_name' => 'CF',
        'country_name' => 'Central African Republic',
        'phoneCode' => 236
      ],
      [
        'country_id' => 42,
        'short_name' => 'TD',
        'country_name' => 'Chad',
        'phoneCode' => 235
      ],
      [
        'country_id' => 43,
        'short_name' => 'CL',
        'country_name' => 'Chile',
        'phoneCode' => 56
      ],
      [
        'country_id' => 44,
        'short_name' => 'CN',
        'country_name' => 'China',
        'phoneCode' => 86
      ],
      [
        'country_id' => 45,
        'short_name' => 'CX',
        'country_name' => 'Christmas Island',
        'phoneCode' => 61
      ],
      [
        'country_id' => 46,
        'short_name' => 'CC',
        'country_name' => 'Cocos (Keeling) Islands',
        'phoneCode' => 672
      ],
      [
        'country_id' => 47,
        'short_name' => 'CO',
        'country_name' => 'Colombia',
        'phoneCode' => 57
      ],
      [
        'country_id' => 48,
        'short_name' => 'KM',
        'country_name' => 'Comoros',
        'phoneCode' => 269
      ],
      [
        'country_id' => 49,
        'short_name' => 'CG',
        'country_name' => 'Republic Of The Congo',
        'phoneCode' => 242
      ],
      [
        'country_id' => 50,
        'short_name' => 'CD',
        'country_name' => 'Democratic Republic Of The Congo',
        'phoneCode' => 242
      ],
      [
        'country_id' => 51,
        'short_name' => 'CK',
        'country_name' => 'Cook Islands',
        'phoneCode' => 682
      ],
      [
        'country_id' => 52,
        'short_name' => 'CR',
        'country_name' => 'Costa Rica',
        'phoneCode' => 506
      ],
      [
        'country_id' => 53,
        'short_name' => 'CI',
        'country_name' => 'Cote D Ivoire (Ivory Coast)',
        'phoneCode' => 225
      ],
      [
        'country_id' => 54,
        'short_name' => 'HR',
        'country_name' => 'Croatia (Hrvatska)',
        'phoneCode' => 385
      ],
      [
        'country_id' => 55,
        'short_name' => 'CU',
        'country_name' => 'Cuba',
        'phoneCode' => 53
      ],
      [
        'country_id' => 56,
        'short_name' => 'CY',
        'country_name' => 'Cyprus',
        'phoneCode' => 357
      ],
      [
        'country_id' => 57,
        'short_name' => 'CZ',
        'country_name' => 'Czech Republic',
        'phoneCode' => 420
      ],
      [
        'country_id' => 58,
        'short_name' => 'DK',
        'country_name' => 'Denmark',
        'phoneCode' => 45
      ],
      [
        'country_id' => 59,
        'short_name' => 'DJ',
        'country_name' => 'Djibouti',
        'phoneCode' => 253
      ],
      [
        'country_id' => 60,
        'short_name' => 'DM',
        'country_name' => 'Dominica',
        'phoneCode' => 1767
      ],
      [
        'country_id' => 61,
        'short_name' => 'DO',
        'country_name' => 'Dominican Republic',
        'phoneCode' => 1809
      ],
      [
        'country_id' => 62,
        'short_name' => 'TP',
        'country_name' => 'East Timor',
        'phoneCode' => 670
      ],
      [
        'country_id' => 63,
        'short_name' => 'EC',
        'country_name' => 'Ecuador',
        'phoneCode' => 593
      ],
      [
        'country_id' => 64,
        'short_name' => 'EG',
        'country_name' => 'Egypt',
        'phoneCode' => 20
      ],
      [
        'country_id' => 65,
        'short_name' => 'SV',
        'country_name' => 'El Salvador',
        'phoneCode' => 503
      ],
      [
        'country_id' => 66,
        'short_name' => 'GQ',
        'country_name' => 'Equatorial Guinea',
        'phoneCode' => 240
      ],
      [
        'country_id' => 67,
        'short_name' => 'ER',
        'country_name' => 'Eritrea',
        'phoneCode' => 291
      ],
      [
        'country_id' => 68,
        'short_name' => 'EE',
        'country_name' => 'Estonia',
        'phoneCode' => 372
      ],
      [
        'country_id' => 69,
        'short_name' => 'ET',
        'country_name' => 'Ethiopia',
        'phoneCode' => 251
      ],
      [
        'country_id' => 70,
        'short_name' => 'XA',
        'country_name' => 'External Territories of Australia',
        'phoneCode' => 61
      ],
      [
        'country_id' => 71,
        'short_name' => 'FK',
        'country_name' => 'Falkland Islands',
        'phoneCode' => 500
      ],
      [
        'country_id' => 72,
        'short_name' => 'FO',
        'country_name' => 'Faroe Islands',
        'phoneCode' => 298
      ],
      [
        'country_id' => 73,
        'short_name' => 'FJ',
        'country_name' => 'Fiji Islands',
        'phoneCode' => 679
      ],
      [
        'country_id' => 74,
        'short_name' => 'FI',
        'country_name' => 'Finland',
        'phoneCode' => 358
      ],
      [
        'country_id' => 75,
        'short_name' => 'FR',
        'country_name' => 'France',
        'phoneCode' => 33
      ],
      [
        'country_id' => 76,
        'short_name' => 'GF',
        'country_name' => 'French Guiana',
        'phoneCode' => 594
      ],
      [
        'country_id' => 77,
        'short_name' => 'PF',
        'country_name' => 'French Polynesia',
        'phoneCode' => 689
      ],
      [
        'country_id' => 78,
        'short_name' => 'TF',
        'country_name' => 'French Southern Territories',
        'phoneCode' => 0
      ],
      [
        'country_id' => 79,
        'short_name' => 'GA',
        'country_name' => 'Gabon',
        'phoneCode' => 241
      ],
      [
        'country_id' => 80,
        'short_name' => 'GM',
        'country_name' => 'Gambia The',
        'phoneCode' => 220
      ],
      [
        'country_id' => 81,
        'short_name' => 'GE',
        'country_name' => 'Georgia',
        'phoneCode' => 995
      ],
      [
        'country_id' => 82,
        'short_name' => 'DE',
        'country_name' => 'Germany',
        'phoneCode' => 49
      ],
      [
        'country_id' => 83,
        'short_name' => 'GH',
        'country_name' => 'Ghana',
        'phoneCode' => 233
      ],
      [
        'country_id' => 84,
        'short_name' => 'GI',
        'country_name' => 'Gibraltar',
        'phoneCode' => 350
      ],
      [
        'country_id' => 85,
        'short_name' => 'GR',
        'country_name' => 'Greece',
        'phoneCode' => 30
      ],
      [
        'country_id' => 86,
        'short_name' => 'GL',
        'country_name' => 'Greenland',
        'phoneCode' => 299
      ],
      [
        'country_id' => 87,
        'short_name' => 'GD',
        'country_name' => 'Grenada',
        'phoneCode' => 1473
      ],
      [
        'country_id' => 88,
        'short_name' => 'GP',
        'country_name' => 'Guadeloupe',
        'phoneCode' => 590
      ],
      [
        'country_id' => 89,
        'short_name' => 'GU',
        'country_name' => 'Guam',
        'phoneCode' => 1671
      ],
      [
        'country_id' => 90,
        'short_name' => 'GT',
        'country_name' => 'Guatemala',
        'phoneCode' => 502
      ],
      [
        'country_id' => 91,
        'short_name' => 'XU',
        'country_name' => 'Guernsey and Alderney',
        'phoneCode' => 44
      ],
      [
        'country_id' => 92,
        'short_name' => 'GN',
        'country_name' => 'Guinea',
        'phoneCode' => 224
      ],
      [
        'country_id' => 93,
        'short_name' => 'GW',
        'country_name' => 'Guinea-Bissau',
        'phoneCode' => 245
      ],
      [
        'country_id' => 94,
        'short_name' => 'GY',
        'country_name' => 'Guyana',
        'phoneCode' => 592
      ],
      [
        'country_id' => 95,
        'short_name' => 'HT',
        'country_name' => 'Haiti',
        'phoneCode' => 509
      ],
      [
        'country_id' => 96,
        'short_name' => 'HM',
        'country_name' => 'Heard and McDonald Islands',
        'phoneCode' => 0
      ],
      [
        'country_id' => 97,
        'short_name' => 'HN',
        'country_name' => 'Honduras',
        'phoneCode' => 504
      ],
      [
        'country_id' => 98,
        'short_name' => 'HK',
        'country_name' => 'Hong Kong S.A.R.',
        'phoneCode' => 852
      ],
      [
        'country_id' => 99,
        'short_name' => 'HU',
        'country_name' => 'Hungary',
        'phoneCode' => 36
      ],
      [
        'country_id' => 100,
        'short_name' => 'IS',
        'country_name' => 'Iceland',
        'phoneCode' => 354
      ],
      [
        'country_id' => 101,
        'short_name' => 'IN',
        'country_name' => 'India',
        'phoneCode' => 91
      ],
      [
        'country_id' => 102,
        'short_name' => 'country_id',
        'country_name' => 'Indonesia',
        'phoneCode' => 62
      ],
      [
        'country_id' => 103,
        'short_name' => 'IR',
        'country_name' => 'Iran',
        'phoneCode' => 98
      ],
      [
        'country_id' => 104,
        'short_name' => 'IQ',
        'country_name' => 'Iraq',
        'phoneCode' => 964
      ],
      [
        'country_id' => 105,
        'short_name' => 'IE',
        'country_name' => 'Ireland',
        'phoneCode' => 353
      ],
      [
        'country_id' => 106,
        'short_name' => 'IL',
        'country_name' => 'Israel',
        'phoneCode' => 972
      ],
      [
        'country_id' => 107,
        'short_name' => 'IT',
        'country_name' => 'Italy',
        'phoneCode' => 39
      ],
      [
        'country_id' => 108,
        'short_name' => 'JM',
        'country_name' => 'Jamaica',
        'phoneCode' => 1876
      ],
      [
        'country_id' => 109,
        'short_name' => 'JP',
        'country_name' => 'Japan',
        'phoneCode' => 81
      ],
      [
        'country_id' => 110,
        'short_name' => 'XJ',
        'country_name' => 'Jersey',
        'phoneCode' => 44
      ],
      [
        'country_id' => 111,
        'short_name' => 'JO',
        'country_name' => 'Jordan',
        'phoneCode' => 962
      ],
      [
        'country_id' => 112,
        'short_name' => 'KZ',
        'country_name' => 'Kazakhstan',
        'phoneCode' => 7
      ],
      [
        'country_id' => 113,
        'short_name' => 'KE',
        'country_name' => 'Kenya',
        'phoneCode' => 254
      ],
      [
        'country_id' => 114,
        'short_name' => 'KI',
        'country_name' => 'Kiribati',
        'phoneCode' => 686
      ],
      [
        'country_id' => 115,
        'short_name' => 'KP',
        'country_name' => 'Korea North',
        'phoneCode' => 850
      ],
      [
        'country_id' => 116,
        'short_name' => 'KR',
        'country_name' => 'Korea South',
        'phoneCode' => 82
      ],
      [
        'country_id' => 117,
        'short_name' => 'KW',
        'country_name' => 'Kuwait',
        'phoneCode' => 965
      ],
      [
        'country_id' => 118,
        'short_name' => 'KG',
        'country_name' => 'Kyrgyzstan',
        'phoneCode' => 996
      ],
      [
        'country_id' => 119,
        'short_name' => 'LA',
        'country_name' => 'Laos',
        'phoneCode' => 856
      ],
      [
        'country_id' => 120,
        'short_name' => 'LV',
        'country_name' => 'Latvia',
        'phoneCode' => 371
      ],
      [
        'country_id' => 121,
        'short_name' => 'LB',
        'country_name' => 'Lebanon',
        'phoneCode' => 961
      ],
      [
        'country_id' => 122,
        'short_name' => 'LS',
        'country_name' => 'Lesotho',
        'phoneCode' => 266
      ],
      [
        'country_id' => 123,
        'short_name' => 'LR',
        'country_name' => 'Liberia',
        'phoneCode' => 231
      ],
      [
        'country_id' => 124,
        'short_name' => 'LY',
        'country_name' => 'Libya',
        'phoneCode' => 218
      ],
      [
        'country_id' => 125,
        'short_name' => 'LI',
        'country_name' => 'Liechtenstein',
        'phoneCode' => 423
      ],
      [
        'country_id' => 126,
        'short_name' => 'LT',
        'country_name' => 'Lithuania',
        'phoneCode' => 370
      ],
      [
        'country_id' => 127,
        'short_name' => 'LU',
        'country_name' => 'Luxembourg',
        'phoneCode' => 352
      ],
      [
        'country_id' => 128,
        'short_name' => 'MO',
        'country_name' => 'Macau S.A.R.',
        'phoneCode' => 853
      ],
      [
        'country_id' => 129,
        'short_name' => 'MK',
        'country_name' => 'Macedonia',
        'phoneCode' => 389
      ],
      [
        'country_id' => 130,
        'short_name' => 'MG',
        'country_name' => 'Madagascar',
        'phoneCode' => 261
      ],
      [
        'country_id' => 131,
        'short_name' => 'MW',
        'country_name' => 'Malawi',
        'phoneCode' => 265
      ],
      [
        'country_id' => 132,
        'short_name' => 'MY',
        'country_name' => 'Malaysia',
        'phoneCode' => 60
      ],
      [
        'country_id' => 133,
        'short_name' => 'MV',
        'country_name' => 'Maldives',
        'phoneCode' => 960
      ],
      [
        'country_id' => 134,
        'short_name' => 'ML',
        'country_name' => 'Mali',
        'phoneCode' => 223
      ],
      [
        'country_id' => 135,
        'short_name' => 'MT',
        'country_name' => 'Malta',
        'phoneCode' => 356
      ],
      [
        'country_id' => 136,
        'short_name' => 'XM',
        'country_name' => 'Man (Isle of)',
        'phoneCode' => 44
      ],
      [
        'country_id' => 137,
        'short_name' => 'MH',
        'country_name' => 'Marshall Islands',
        'phoneCode' => 692
      ],
      [
        'country_id' => 138,
        'short_name' => 'MQ',
        'country_name' => 'Martinique',
        'phoneCode' => 596
      ],
      [
        'country_id' => 139,
        'short_name' => 'MR',
        'country_name' => 'Mauritania',
        'phoneCode' => 222
      ],
      [
        'country_id' => 140,
        'short_name' => 'MU',
        'country_name' => 'Mauritius',
        'phoneCode' => 230
      ],
      [
        'country_id' => 141,
        'short_name' => 'YT',
        'country_name' => 'Mayotte',
        'phoneCode' => 269
      ],
      [
        'country_id' => 142,
        'short_name' => 'MX',
        'country_name' => 'Mexico',
        'phoneCode' => 52
      ],
      [
        'country_id' => 143,
        'short_name' => 'FM',
        'country_name' => 'Micronesia',
        'phoneCode' => 691
      ],
      [
        'country_id' => 144,
        'short_name' => 'MD',
        'country_name' => 'Moldova',
        'phoneCode' => 373
      ],
      [
        'country_id' => 145,
        'short_name' => 'MC',
        'country_name' => 'Monaco',
        'phoneCode' => 377
      ],
      [
        'country_id' => 146,
        'short_name' => 'MN',
        'country_name' => 'Mongolia',
        'phoneCode' => 976
      ],
      [
        'country_id' => 147,
        'short_name' => 'MS',
        'country_name' => 'Montserrat',
        'phoneCode' => 1664
      ],
      [
        'country_id' => 148,
        'short_name' => 'MA',
        'country_name' => 'Morocco',
        'phoneCode' => 212
      ],
      [
        'country_id' => 149,
        'short_name' => 'MZ',
        'country_name' => 'Mozambique',
        'phoneCode' => 258
      ],
      [
        'country_id' => 150,
        'short_name' => 'MM',
        'country_name' => 'Myanmar',
        'phoneCode' => 95
      ],
      [
        'country_id' => 151,
        'short_name' => 'NA',
        'country_name' => 'Namibia',
        'phoneCode' => 264
      ],
      [
        'country_id' => 152,
        'short_name' => 'NR',
        'country_name' => 'Nauru',
        'phoneCode' => 674
      ],
      [
        'country_id' => 153,
        'short_name' => 'NP',
        'country_name' => 'Nepal',
        'phoneCode' => 977
      ],
      [
        'country_id' => 154,
        'short_name' => 'AN',
        'country_name' => 'Netherlands Antilles',
        'phoneCode' => 599
      ],
      [
        'country_id' => 155,
        'short_name' => 'NL',
        'country_name' => 'Netherlands The',
        'phoneCode' => 31
      ],
      [
        'country_id' => 156,
        'short_name' => 'NC',
        'country_name' => 'New Caledonia',
        'phoneCode' => 687
      ],
      [
        'country_id' => 157,
        'short_name' => 'NZ',
        'country_name' => 'New Zealand',
        'phoneCode' => 64
      ],
      [
        'country_id' => 158,
        'short_name' => 'NI',
        'country_name' => 'Nicaragua',
        'phoneCode' => 505
      ],
      [
        'country_id' => 159,
        'short_name' => 'NE',
        'country_name' => 'Niger',
        'phoneCode' => 227
      ],
      [
        'country_id' => 160,
        'short_name' => 'NG',
        'country_name' => 'Nigeria',
        'phoneCode' => 234
      ],
      [
        'country_id' => 161,
        'short_name' => 'NU',
        'country_name' => 'Niue',
        'phoneCode' => 683
      ],
      [
        'country_id' => 162,
        'short_name' => 'NF',
        'country_name' => 'Norfolk Island',
        'phoneCode' => 672
      ],
      [
        'country_id' => 163,
        'short_name' => 'MP',
        'country_name' => 'Northern Mariana Islands',
        'phoneCode' => 1670
      ],
      [
        'country_id' => 164,
        'short_name' => 'NO',
        'country_name' => 'Norway',
        'phoneCode' => 47
      ],
      [
        'country_id' => 165,
        'short_name' => 'OM',
        'country_name' => 'Oman',
        'phoneCode' => 968
      ],
      [
        'country_id' => 166,
        'short_name' => 'PK',
        'country_name' => 'Pakistan',
        'phoneCode' => 92
      ],
      [
        'country_id' => 167,
        'short_name' => 'PW',
        'country_name' => 'Palau',
        'phoneCode' => 680
      ],
      [
        'country_id' => 168,
        'short_name' => 'PS',
        'country_name' => 'Palestinian Territory Occupied',
        'phoneCode' => 970
      ],
      [
        'country_id' => 169,
        'short_name' => 'PA',
        'country_name' => 'Panama',
        'phoneCode' => 507
      ],
      [
        'country_id' => 170,
        'short_name' => 'PG',
        'country_name' => 'Papua new Guinea',
        'phoneCode' => 675
      ],
      [
        'country_id' => 171,
        'short_name' => 'PY',
        'country_name' => 'Paraguay',
        'phoneCode' => 595
      ],
      [
        'country_id' => 172,
        'short_name' => 'PE',
        'country_name' => 'Peru',
        'phoneCode' => 51
      ],
      [
        'country_id' => 173,
        'short_name' => 'PH',
        'country_name' => 'Philippines',
        'phoneCode' => 63
      ],
      [
        'country_id' => 174,
        'short_name' => 'PN',
        'country_name' => 'Pitcairn Island',
        'phoneCode' => 0
      ],
      [
        'country_id' => 175,
        'short_name' => 'PL',
        'country_name' => 'Poland',
        'phoneCode' => 48
      ],
      [
        'country_id' => 176,
        'short_name' => 'PT',
        'country_name' => 'Portugal',
        'phoneCode' => 351
      ],
      [
        'country_id' => 177,
        'short_name' => 'PR',
        'country_name' => 'Puerto Rico',
        'phoneCode' => 1787
      ],
      [
        'country_id' => 178,
        'short_name' => 'QA',
        'country_name' => 'Qatar',
        'phoneCode' => 974
      ],
      [
        'country_id' => 179,
        'short_name' => 'RE',
        'country_name' => 'Reunion',
        'phoneCode' => 262
      ],
      [
        'country_id' => 180,
        'short_name' => 'RO',
        'country_name' => 'Romania',
        'phoneCode' => 40
      ],
      [
        'country_id' => 181,
        'short_name' => 'RU',
        'country_name' => 'Russia',
        'phoneCode' => 70
      ],
      [
        'country_id' => 182,
        'short_name' => 'RW',
        'country_name' => 'Rwanda',
        'phoneCode' => 250
      ],
      [
        'country_id' => 183,
        'short_name' => 'SH',
        'country_name' => 'Saint Helena',
        'phoneCode' => 290
      ],
      [
        'country_id' => 184,
        'short_name' => 'KN',
        'country_name' => 'Saint Kitts And Nevis',
        'phoneCode' => 1869
      ],
      [
        'country_id' => 185,
        'short_name' => 'LC',
        'country_name' => 'Saint Lucia',
        'phoneCode' => 1758
      ],
      [
        'country_id' => 186,
        'short_name' => 'PM',
        'country_name' => 'Saint Pierre and Miquelon',
        'phoneCode' => 508
      ],
      [
        'country_id' => 187,
        'short_name' => 'VC',
        'country_name' => 'Saint Vincent And The Grenadines',
        'phoneCode' => 1784
      ],
      [
        'country_id' => 188,
        'short_name' => 'WS',
        'country_name' => 'Samoa',
        'phoneCode' => 684
      ],
      [
        'country_id' => 189,
        'short_name' => 'SM',
        'country_name' => 'San Marino',
        'phoneCode' => 378
      ],
      [
        'country_id' => 190,
        'short_name' => 'ST',
        'country_name' => 'Sao Tome and Principe',
        'phoneCode' => 239
      ],
      [
        'country_id' => 191,
        'short_name' => 'SA',
        'country_name' => 'Saudi Arabia',
        'phoneCode' => 966
      ],
      [
        'country_id' => 192,
        'short_name' => 'SN',
        'country_name' => 'Senegal',
        'phoneCode' => 221
      ],
      [
        'country_id' => 193,
        'short_name' => 'RS',
        'country_name' => 'Serbia',
        'phoneCode' => 381
      ],
      [
        'country_id' => 194,
        'short_name' => 'SC',
        'country_name' => 'Seychelles',
        'phoneCode' => 248
      ],
      [
        'country_id' => 195,
        'short_name' => 'SL',
        'country_name' => 'Sierra Leone',
        'phoneCode' => 232
      ],
      [
        'country_id' => 196,
        'short_name' => 'SG',
        'country_name' => 'Singapore',
        'phoneCode' => 65
      ],
      [
        'country_id' => 197,
        'short_name' => 'SK',
        'country_name' => 'Slovakia',
        'phoneCode' => 421
      ],
      [
        'country_id' => 198,
        'short_name' => 'SI',
        'country_name' => 'Slovenia',
        'phoneCode' => 386
      ],
      [
        'country_id' => 199,
        'short_name' => 'XG',
        'country_name' => 'Smaller Territories of the UK',
        'phoneCode' => 44
      ],
      [
        'country_id' => 200,
        'short_name' => 'SB',
        'country_name' => 'Solomon Islands',
        'phoneCode' => 677
      ],
      [
        'country_id' => 201,
        'short_name' => 'SO',
        'country_name' => 'Somalia',
        'phoneCode' => 252
      ],
      [
        'country_id' => 202,
        'short_name' => 'ZA',
        'country_name' => 'South Africa',
        'phoneCode' => 27
      ],
      [
        'country_id' => 203,
        'short_name' => 'GS',
        'country_name' => 'South Georgia',
        'phoneCode' => 0
      ],
      [
        'country_id' => 204,
        'short_name' => 'SS',
        'country_name' => 'South Sudan',
        'phoneCode' => 211
      ],
      [
        'country_id' => 205,
        'short_name' => 'ES',
        'country_name' => 'Spain',
        'phoneCode' => 34
      ],
      [
        'country_id' => 206,
        'short_name' => 'LK',
        'country_name' => 'Sri Lanka',
        'phoneCode' => 94
      ],
      [
        'country_id' => 207,
        'short_name' => 'SD',
        'country_name' => 'Sudan',
        'phoneCode' => 249
      ],
      [
        'country_id' => 208,
        'short_name' => 'SR',
        'country_name' => 'Suricountry_name',
        'phoneCode' => 597
      ],
      [
        'country_id' => 209,
        'short_name' => 'SJ',
        'country_name' => 'Svalbard And Jan Mayen Islands',
        'phoneCode' => 47
      ],
      [
        'country_id' => 210,
        'short_name' => 'SZ',
        'country_name' => 'Swaziland',
        'phoneCode' => 268
      ],
      [
        'country_id' => 211,
        'short_name' => 'SE',
        'country_name' => 'Sweden',
        'phoneCode' => 46
      ],
      [
        'country_id' => 212,
        'short_name' => 'CH',
        'country_name' => 'Switzerland',
        'phoneCode' => 41
      ],
      [
        'country_id' => 213,
        'short_name' => 'SY',
        'country_name' => 'Syria',
        'phoneCode' => 963
      ],
      [
        'country_id' => 214,
        'short_name' => 'TW',
        'country_name' => 'Taiwan',
        'phoneCode' => 886
      ],
      [
        'country_id' => 215,
        'short_name' => 'TJ',
        'country_name' => 'Tajikistan',
        'phoneCode' => 992
      ],
      [
        'country_id' => 216,
        'short_name' => 'TZ',
        'country_name' => 'Tanzania',
        'phoneCode' => 255
      ],
      [
        'country_id' => 217,
        'short_name' => 'TH',
        'country_name' => 'Thailand',
        'phoneCode' => 66
      ],
      [
        'country_id' => 218,
        'short_name' => 'TG',
        'country_name' => 'Togo',
        'phoneCode' => 228
      ],
      [
        'country_id' => 219,
        'short_name' => 'TK',
        'country_name' => 'Tokelau',
        'phoneCode' => 690
      ],
      [
        'country_id' => 220,
        'short_name' => 'TO',
        'country_name' => 'Tonga',
        'phoneCode' => 676
      ],
      [
        'country_id' => 221,
        'short_name' => 'TT',
        'country_name' => 'Trincountry_idad And Tobago',
        'phoneCode' => 1868
      ],
      [
        'country_id' => 222,
        'short_name' => 'TN',
        'country_name' => 'Tunisia',
        'phoneCode' => 216
      ],
      [
        'country_id' => 223,
        'short_name' => 'TR',
        'country_name' => 'Turkey',
        'phoneCode' => 90
      ],
      [
        'country_id' => 224,
        'short_name' => 'TM',
        'country_name' => 'Turkmenistan',
        'phoneCode' => 7370
      ],
      [
        'country_id' => 225,
        'short_name' => 'TC',
        'country_name' => 'Turks And Caicos Islands',
        'phoneCode' => 1649
      ],
      [
        'country_id' => 226,
        'short_name' => 'TV',
        'country_name' => 'Tuvalu',
        'phoneCode' => 688
      ],
      [
        'country_id' => 227,
        'short_name' => 'UG',
        'country_name' => 'Uganda',
        'phoneCode' => 256
      ],
      [
        'country_id' => 228,
        'short_name' => 'UA',
        'country_name' => 'Ukraine',
        'phoneCode' => 380
      ],
      [
        'country_id' => 229,
        'short_name' => 'AE',
        'country_name' => 'United Arab Emirates',
        'phoneCode' => 971
      ],
      [
        'country_id' => 230,
        'short_name' => 'GB',
        'country_name' => 'United Kingdom',
        'phoneCode' => 44
      ],
      [
        'country_id' => 231,
        'short_name' => 'US',
        'country_name' => 'United States',
        'phoneCode' => 1
      ],
      [
        'country_id' => 232,
        'short_name' => 'UM',
        'country_name' => 'United States Minor Outlying Islands',
        'phoneCode' => 1
      ],
      [
        'country_id' => 233,
        'short_name' => 'UY',
        'country_name' => 'Uruguay',
        'phoneCode' => 598
      ],
      [
        'country_id' => 234,
        'short_name' => 'UZ',
        'country_name' => 'Uzbekistan',
        'phoneCode' => 998
      ],
      [
        'country_id' => 235,
        'short_name' => 'VU',
        'country_name' => 'Vanuatu',
        'phoneCode' => 678
      ],
      [
        'country_id' => 236,
        'short_name' => 'VA',
        'country_name' => 'Vatican City State (Holy See)',
        'phoneCode' => 39
      ],
      [
        'country_id' => 237,
        'short_name' => 'VE',
        'country_name' => 'Venezuela',
        'phoneCode' => 58
      ],
      [
        'country_id' => 238,
        'short_name' => 'VN',
        'country_name' => 'Vietnam',
        'phoneCode' => 84
      ],
      [
        'country_id' => 239,
        'short_name' => 'VG',
        'country_name' => 'Virgin Islands (British)',
        'phoneCode' => 1284
      ],
      [
        'country_id' => 240,
        'short_name' => 'VI',
        'country_name' => 'Virgin Islands (US)',
        'phoneCode' => 1340
      ],
      [
        'country_id' => 241,
        'short_name' => 'WF',
        'country_name' => 'Wallis And Futuna Islands',
        'phoneCode' => 681
      ],
      [
        'country_id' => 242,
        'short_name' => 'EH',
        'country_name' => 'Western Sahara',
        'phoneCode' => 212
      ],
      [
        'country_id' => 243,
        'short_name' => 'YE',
        'country_name' => 'Yemen',
        'phoneCode' => 967
      ],
      [
        'country_id' => 244,
        'short_name' => 'YU',
        'country_name' => 'Yugoslavia',
        'phoneCode' => 38
      ],
      [
        'country_id' => 245,
        'short_name' => 'ZM',
        'country_name' => 'Zambia',
        'phoneCode' => 260
      ],
      [
        'country_id' => 246,
        'short_name' => 'ZW',
        'country_name' => 'Zimbabwe',
        'phoneCode' => 26
      ],
    ];
    foreach ($countries as $country) {
      Country::create([
        'name' => $country['country_name'],
        'short_name' => $country['short_name']
      ]);
    }
  }
}
