<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentLocations = new XentLocations();

class XentLocations
{
    public $address;

    public $city;

    public $country;

    public $db;

    public $id_location;

    public $state;

    public $zipcode;

    //constructor

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function setIdLocation($id_location)
    {
        $this->id_location = $id_location;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setZipCode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    // getters

    public function getAddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->getRealCountry($this->country);
    }

    public function getCountryCode()
    {
        return $this->country;
    }

    public function getIdLocation()
    {
        return $this->id_location;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getZipCode()
    {
        return $this->zipcode;
    }

    // methods

    public function add($inBatch = 0)
    {
        $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_LOCATIONS) . " (address, city, state, country, zipcode) VALUES('" . $this->getAddress() . "', '" . $this->getCity() . "', '" . $this->getState() . "', '" . $this->getCountryCode() . "', '" . $this->getZipCode() . "')";

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('adminlocations.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('adminlocations.php', 4, $this->db->error());
            }
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_LOCATIONS) . " WHERE ID_LOCATION=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminlocations.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminlocations.php', 4, $this->db->error());
        }
    }

    public function getAllLocations()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_LOCATIONS) . ' ORDER BY country, state, city, address';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getLocation($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_LOCATIONS) . " WHERE ID_LOCATION=$id";

        $result = $this->db->query($sql);

        $location = $this->db->fetchArray($result);

        return $location;
    }

    public function getRealCountry($country)
    {
        $country_list = [
            '' => '-',
            'AD' => 'Andorra',
            'AE' => 'United Arab Emirates',
            'AF' => 'Afghanistan',
            'AG' => 'Antigua and Barbuda',
            'AI' => 'Anguilla',
            'AL' => 'Albania',
            'AM' => 'Armenia',
            'AN' => 'Netherlands Antilles',
            'AO' => 'Angola',
            'AQ' => 'Antarctica',
            'AR' => 'Argentina',
            'AS' => 'American Samoa',
            'AT' => 'Austria',
            'AU' => 'Australia',
            'AW' => 'Aruba',
            'AZ' => 'Azerbaijan',
            'BA' => 'Bosnia and Herzegovina',
            'BB' => 'Barbados',
            'BD' => 'Bangladesh',
            'BE' => 'Belgium',
            'BF' => 'Burkina Faso',
            'BG' => 'Bulgaria',
            'BH' => 'Bahrain',
            'BI' => 'Burundi',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BN' => 'Brunei Darussalam',
            'BO' => 'Bolivia',
            'BR' => 'Brazil',
            'BS' => 'Bahamas',
            'BT' => 'Bhutan',
            'BV' => 'Bouvet Island',
            'BW' => 'Botswana',
            'BY' => 'Belarus',
            'BZ' => 'Belize',
            'CA' => 'Canada',
            'CC' => 'Cocos (Keeling) Islands',
            'CF' => 'Central African Republic',
            'CG' => 'Congo',
            'CH' => 'Switzerland',
            'CI' => "Cote D'Ivoire (Ivory Coast)",
            'CK' => 'Cook Islands',
            'CL' => 'Chile',
            'CM' => 'Cameroon',
            'CN' => 'China',
            'CO' => 'Colombia',
            'CR' => 'Costa Rica',
            'CS' => 'Czechoslovakia (former)',
            'CU' => 'Cuba',
            'CV' => 'Cape Verde',
            'CX' => 'Christmas Island',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DE' => 'Germany',
            'DJ' => 'Djibouti',
            'DK' => 'Denmark',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'DZ' => 'Algeria',
            'EC' => 'Ecuador',
            'EE' => 'Estonia',
            'EG' => 'Egypt',
            'EH' => 'Western Sahara',
            'ER' => 'Eritrea',
            'ES' => 'Spain',
            'ET' => 'Ethiopia',
            'FI' => 'Finland',
            'FJ' => 'Fiji',
            'FK' => 'Falkland Islands (Malvinas)',
            'FM' => 'Micronesia',
            'FO' => 'Faroe Islands',
            'FR' => 'France',
            'FX' => 'France, Metropolitan',
            'GA' => 'Gabon',
            'GB' => 'Great Britain (UK)',
            'GD' => 'Grenada',
            'GE' => 'Georgia',
            'GF' => 'French Guiana',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GL' => 'Greenland',
            'GM' => 'Gambia',
            'GN' => 'Guinea',
            'GP' => 'Guadeloupe',
            'GQ' => 'Equatorial Guinea',
            'GR' => 'Greece',
            'GS' => 'S. Georgia and S. Sandwich Isls.',
            'GT' => 'Guatemala',
            'GU' => 'Guam',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HK' => 'Hong Kong',
            'HM' => 'Heard and McDonald Islands',
            'HN' => 'Honduras',
            'HR' => 'Croatia (Hrvatska)',
            'HT' => 'Haiti',
            'HU' => 'Hungary',
            'ID' => 'Indonesia',
            'IE' => 'Ireland',
            'IL' => 'Israel',
            'IN' => 'India',
            'IO' => 'British Indian Ocean Territory',
            'IQ' => 'Iraq',
            'IR' => 'Iran',
            'IS' => 'Iceland',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JO' => 'Jordan',
            'JP' => 'Japan',
            'KE' => 'Kenya',
            'KG' => 'Kyrgyzstan',
            'KH' => 'Cambodia',
            'KI' => 'Kiribati',
            'KM' => 'Comoros',
            'KN' => 'Saint Kitts and Nevis',
            'KP' => 'Korea (North)',
            'KR' => 'Korea (South)',
            'KW' => 'Kuwait',
            'KY' => 'Cayman Islands',
            'KZ' => 'Kazakhstan',
            'LA' => 'Laos',
            'LB' => 'Lebanon',
            'LC' => 'Saint Lucia',
            'LI' => 'Liechtenstein',
            'LK' => 'Sri Lanka',
            'LR' => 'Liberia',
            'LS' => 'Lesotho',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'LV' => 'Latvia',
            'LY' => 'Libya',
            'MA' => 'Morocco',
            'MC' => 'Monaco',
            'MD' => 'Moldova',
            'MG' => 'Madagascar',
            'MH' => 'Marshall Islands',
            'MK' => 'Macedonia',
            'ML' => 'Mali',
            'MM' => 'Myanmar',
            'MN' => 'Mongolia',
            'MO' => 'Macau',
            'MP' => 'Northern Mariana Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MS' => 'Montserrat',
            'MT' => 'Malta',
            'MU' => 'Mauritius',
            'MV' => 'Maldives',
            'MW' => 'Malawi',
            'MX' => 'Mexico',
            'MY' => 'Malaysia',
            'MZ' => 'Mozambique',
            'NA' => 'Namibia',
            'NC' => 'New Caledonia',
            'NE' => 'Niger',
            'NF' => 'Norfolk Island',
            'NG' => 'Nigeria',
            'NI' => 'Nicaragua',
            'NL' => 'Netherlands',
            'NO' => 'Norway',
            'NP' => 'Nepal',
            'NR' => 'Nauru',
            'NT' => 'Neutral Zone',
            'NU' => 'Niue',
            'NZ' => 'New Zealand (Aotearoa)',
            'OM' => 'Oman',
            'PA' => 'Panama',
            'PE' => 'Peru',
            'PF' => 'French Polynesia',
            'PG' => 'Papua New Guinea',
            'PH' => 'Philippines',
            'PK' => 'Pakistan',
            'PL' => 'Poland',
            'PM' => 'St. Pierre and Miquelon',
            'PN' => 'Pitcairn',
            'PR' => 'Puerto Rico',
            'PT' => 'Portugal',
            'PW' => 'Palau',
            'PY' => 'Paraguay',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'SA' => 'Saudi Arabia',
            'Sb' => 'Solomon Islands',
            'SC' => 'Seychelles',
            'SD' => 'Sudan',
            'SE' => 'Sweden',
            'SG' => 'Singapore',
            'SH' => 'St. Helena',
            'SI' => 'Slovenia',
            'SJ' => 'Svalbard and Jan Mayen Islands',
            'SK' => 'Slovak Republic',
            'SL' => 'Sierra Leone',
            'SM' => 'San Marino',
            'SN' => 'Senegal',
            'SO' => 'Somalia',
            'SR' => 'Suriname',
            'ST' => 'Sao Tome and Principe',
            'SU' => 'USSR (former)',
            'SV' => 'El Salvador',
            'SY' => 'Syria',
            'SZ' => 'Swaziland',
            'TC' => 'Turks and Caicos Islands',
            'TD' => 'Chad',
            'TF' => 'French Southern Territories',
            'TG' => 'Togo',
            'TH' => 'Thailand',
            'TJ' => 'Tajikistan',
            'TK' => 'Tokelau',
            'TM' => 'Turkmenistan',
            'TN' => 'Tunisia',
            'TO' => 'Tonga',
            'TP' => 'East Timor',
            'TR' => 'Turkey',
            'TT' => 'Trinidad and Tobago',
            'TV' => 'Tuvalu',
            'TW' => 'Taiwan',
            'TZ' => 'Tanzania',
            'UA' => 'Ukraine',
            'UG' => 'Uganda',
            'UK' => 'United Kingdom',
            'UM' => 'US Minor Outlying Islands',
            'US' => 'United States',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VA' => 'Vatican City State (Holy See)',
            'VC' => 'Saint Vincent and the Grenadines',
            'VE' => 'Venezuela',
            'VG' => 'Virgin Islands (British)',
            'VI' => 'Virgin Islands (U.S.)',
            'VN' => 'Viet Nam',
            'VU' => 'Vanuatu',
            'WF' => 'Wallis and Futuna Islands',
            'WS' => 'Samoa',
            'YE' => 'Yemen',
            'YT' => 'Mayotte',
            'YU' => 'Yugoslavia',
            'ZA' => 'South Africa',
            'ZM' => 'Zambia',
            'ZR' => 'Zaire',
            'ZW' => 'Zimbabwe',
        ];

        asort($country_list);

        reset($country_list);

        return $country_list[$country];
    }

    public function update()
    {
        $sql = 'UPDATE '
               . $this->db->prefix(XENT_DB_XENT_GEN_LOCATIONS)
               . " SET address='"
               . $this->getAddress()
               . "', city='"
               . $this->getCity()
               . "', state='"
               . $this->getState()
               . "', country='"
               . $this->getCountryCode()
               . "', zipcode='"
               . $this->getZipCode()
               . "' WHERE ID_LOCATION="
               . $this->getIdLocation();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminlocations.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminlocations.php', 4, $this->db->error());
        }
    }
}
