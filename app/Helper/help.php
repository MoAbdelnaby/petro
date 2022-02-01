<?php

/**
 * To active the tab in menu (Side bar tab color)
 * @param string $name The name of tab
 * @param int $index the index of tab in url
 * * @param bool $has_sub_menu check if tab has submenu or not
 * @return string return the name of active class for tab
 */

use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('active')) {

    function active(string $name, int $index, bool $has_sub_menu = false): string
    {

        if (request()->segment($index) == $name) {
            if ($has_sub_menu) {
                return 'kt-menu__item--open kt-menu__item--here';
            }
            return 'kt-menu__item--active';
        }
        return "";
    }
}


if (!function_exists('phoneHandeler')) {

    function phoneHandeler(string $phoneNumber)
    {
        $phone = str_replace('+', '', $phoneNumber);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $chekk00 = Str::startsWith($phone, '00');
        if ($chekk00) {
            $phone = Str::replaceFirst('00', '', $phone);
        }
        $chekk0 = Str::startsWith($phone, '0');
        if ($chekk0) {
            $phone = Str::replaceFirst('0', '966', $phone);
        }
        return $phone;
    }
}


if (!function_exists('utf8_strrev')) {
    function utf8_strrev($str = null)
    {
        if ($str) {
            preg_match_all('/./us', $str, $ar);
            return join('', array_reverse($ar[0]));
        }
        return null;

    }
}


if (!function_exists('setting')) {
    function setting()
    {

        $setting = \App\Setting::first();
        if (!$setting)
            $setting = \App\Setting::create([
                'name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
                'primary_id' => primaryID()
            ]);
        return $setting;
    }

}

if (!function_exists('languages')) {
    function languages()
    {
        return \App\Language::all();
    }

}

if (!function_exists('parentCategories')) {
    function parentCategories()
    {
        return \App\Category::where('primary_id', primaryID())->whereNull('category_id')->get();
    }

}

if (!function_exists('childCategories')) {
    function childCategories($id)
    {
        return \App\Category::where('primary_id', primaryID())->where('category_id', $id)->get();
    }

}


if (!function_exists('uploadImage')) {
    function uploadImage($storage, $image, $modal)
    {
        $image->store('/' . $modal, $storage);
        return $image->hashName();
    }
}

if (!function_exists('primaryID')) {
    function primaryID()
    {
        return auth()->user()->parent_id ?? auth()->id();
    }
}
if (!function_exists('parentID')) {
    function parentID()
    {

        return auth()->user()->parent_id != null && auth()->user()->type == "subcustomer" ? auth()->user()->parent_id : auth()->id();
    }
}

if (!function_exists('primarySlug')) {
    function primarySlug()
    {
        return \App\User::find(primaryID())->name ?? 'admin';
    }
}

if (!function_exists('convert2ArabicNum')) {

    function convert2ArabicNum($string = null)
    {
        $newNumbers = range(0, 9);
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        return $string ? str_replace($newNumbers, $arabic, $string) : null;
    } // convert2ArabicNum
}


if (!function_exists('convert2EnglishNum')) {

    function convert2EnglishNum($string = null)
    {
        $newNumbers = range(0, 9);
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        return $string ? str_replace($arabic, $newNumbers, $string) : null;
    } // convert2ArabicNum
}


/**
 * resolveDark assets files
 */
if (!function_exists('resolveDark')) {

    function resolveDark()
    {
        return session()->has('darkMode') ? url('/gym_dark') : url('/gym');
    }
}

if (!function_exists('getScreenshotUrl')) {

    function getScreenshotUrl($screenshot, $driver)
    {
        if ($driver == 'azure') {
            return config('app.azure_storage') . config('app.azure_container') . "/storage" . $screenshot;

        } else {
            return url('/storage' . $screenshot);
        }
    }
}


/**
 * resolveDark assets and handle language asset files
 */
if (!function_exists('resolveLang')) {

    function resolveLang()
    {
        $lang = str_replace('_', '-', app()->getLocale());

        return session()->has('darkMode')
            ? url('/asset_dark')
            : ($lang == 'ar'
                ? url('/asset_ar')
                : url('/asset_en')
            );
    }
}

/**
 * UR_exists assets and handle language asset files
 */
if (!function_exists('UR_exists')) {

    function UR_exists($url)
    {
        $headers = get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }
}


if (!function_exists('weekOfMonth')) {
    function weekOfMonth($date)
    {
        $firstOfMonth = strtotime(date("Y-m-01", $date));
        return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
    }
}

if (!function_exists('weekOfYear')) {
    function weekOfYear($date)
    {
        $weekOfYear = intval(date("W", $date));
        if (date('n', $date) == "1" && $weekOfYear > 51) {
            $weekOfYear = 0;
        }
        return $weekOfYear;
    }
}


if (!function_exists('handleTableSetting')) {
    function handleTableSetting($userSettings = null): string
    {
        if ($userSettings) {
            if ($userSettings->table_type == 1) {
                return 'theme-1';
            } elseif ($userSettings->table_type == 2) {
                return 'table-bordered';
            } elseif ($userSettings->table_type == 3) {
                return 'table-striped';
            } elseif ($userSettings->table_type == 4) {
                return 'table-striped table-dark';
            }

        }
        return 'theme-1';
    }
}

if (!function_exists('handleTableConfig')) {
    function handleTableConfig($table = null, $type = 'home')
    {
        global $result;
        $result = 'theme-1';
        if ($table) {
            if (isset($table['1'])) {
                if (in_array($type, array_values($table['1']))) {
                    $result = 'theme-1';
                }
            }
            if (isset($table['2'])) {
                if (in_array($type, array_values($table['2']))) {
                    $result = 'table-bordered';
                }
            }
            if (isset($table['3'])) {
                if (in_array($type, array_values($table['3']))) {
                    $result = 'table-striped';
                }
            }
            if (isset($table['4'])) {
                if (in_array($type, array_values($table['4']))) {
                    $result = 'table-striped table-dark';
                }
            }
        }
        return $result;
    }
}
if (!function_exists('diffMonth')) {

    function diffMonth($from, $to)
    {
        $from_array = explode('-', $from);
        $to_array = explode('-', $to);

        $from_correct = $from_array[2] . '-' . $from_array[0] . '-' . $from_array[1];
        $to_correct = $to_array[2] . '-' . $to_array[0] . '-' . $to_array[1];

        $fromYear = date("Y", strtotime($from_correct));
        $fromMonth = date("m", strtotime($from_correct));

        $toYear = date("Y", strtotime($to_correct));
        $toMonth = date("m", strtotime($to_correct));

        if ($fromYear == $toYear) {
            return ($toMonth - $fromMonth) + 1;
        } else {
            return (12 - $fromMonth) + 1 + $toMonth;
        }
    }
}


if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return $needle !== '' && strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('unKnownError')) {
    function unKnownError($message = null)
    {
        $message = trans('app.something_error') . '' . (env('APP_DEBUG') ? " : $message" : '');

        return request()->expectsJson()
            ? response()->json(['message' => $message], 400)
            : redirect()->back()->with(['danger' => $message]);
    }
}
if (!function_exists('getStartEndDate')) {
    function getStartEndDate($time = null): array
    {
        if ($time == "today") {
            $start_name = Carbon::today()->format("Y-m-d");
            $last_name = Carbon::today()->format("Y-m-d");

        } elseif ($time == 'week') {

            $start_name = Carbon::now()->startOfWeek()->subDays(1)->format("Y-m-d");
            $last_name = Carbon::now()->endOfWeek()->subDays(1)->format("Y-m-d");
        }
        elseif ($time == 'last_week') {

            $start_name = Carbon::now()->subWeek(1)->startOfWeek()->addDays(1)->format("Y-m-d");
            $last_name = Carbon::now()->subWeek(1)->endOfWeek()->subDays(1)->format("Y-m-d");

        } elseif ($time == 'month') {

            $start_name = Carbon::now()->startOfMonth()->format('Y-m-d');
            $last_name = Carbon::now()->format('Y-m-d');

        } elseif ($time == 'year') {

            $start_name = Carbon::now()->startOfYear()->format('Y-m-d');
            $last_name = Carbon::now()->format('Y-m-d');

        } else {
            $start_name = Carbon::create(date('Y'), $time)->startOfMonth()->format('Y-m-d');
            $last_name = Carbon::create(date('Y'), $time)->lastOfMonth()->format('Y-m-d');
        }

        return ['start' => $start_name, 'end' => $last_name];
    }
}
define(
    'WELCOME', "أهلاً بك في *بترومين اكسبرس*، سعداء بخدمتك، ونأمل أن تكون تجربتك سعيدة.

Welcome to *Petromin Express*. We are happy to serve you and hope your experience is pleasant.");

define('NOTIFY', "شكرًا لاختيارك *بترومين اكسبرس*، سُعدنا بخدمتك.
تغيير الزيت القادم سيكون على {{1}} كم.
للاطلاع على فاتورتك، اضغط الرقم *1* أو اكتب *فاتورة*.

Thank you for choosing *Petromin Express*. We are glad to serve you.
Your next oil change will be on {{2}} km.
To view your invoice, please press *1* or type *Invoice*.");


const COUNTRY_CODE = [
    "AF" => "Afghanistan",
    "AL" => "Albania",
    "DZ" => "Algeria",
    "AS" => "American Samoa",
    "AD" => "Andorra",
    "AO" => "Angola",
    "AI" => "Anguilla",
    "AQ" => "Antarctica",
    "AG" => "Antigua and Barbuda",
    "AR" => "Argentina",
    "AM" => "Armenia",
    "AW" => "Aruba",
    "AU" => "Australia",
    "AT" => "Austria",
    "AZ" => "Azerbaijan",
    "BS" => "Bahamas",
    "BH" => "Bahrain",
    "BD" => "Bangladesh",
    "BB" => "Barbados",
    "BY" => "Belarus",
    "BE" => "Belgium",
    "BZ" => "Belize",
    "BJ" => "Benin",
    "BM" => "Bermuda",
    "BT" => "Bhutan",
    "BO" => "Bolivia",
    "BA" => "Bosnia and Herzegovina",
    "BW" => "Botswana",
    "BV" => "Bouvet Island",
    "BR" => "Brazil",
    "BQ" => "British Antarctic Territory",
    "IO" => "British Indian Ocean Territory",
    "VG" => "British Virgin Islands",
    "BN" => "Brunei",
    "BG" => "Bulgaria",
    "BF" => "Burkina Faso",
    "BI" => "Burundi",
    "KH" => "Cambodia",
    "CM" => "Cameroon",
    "CA" => "Canada",
    "CT" => "Canton and Enderbury Islands",
    "CV" => "Cabo Verde",
    "KY" => "Cayman Islands",
    "CF" => "CAR",
    "TD" => "Chad",
    "CL" => "Chile",
    "CN" => "China",
    "CX" => "Christmas Island",
    "CC" => "Cocos [Keeling] Islands",
    "CO" => "Colombia",
    "KM" => "Comoros",
    "CG" => "Congo",
    "SX" => "Sint Maarten",
    "CD" => "DRC",
    "MO" => "Macao",
    "CK" => "Cook Islands",
    "CR" => "Costa Rica",
    "HR" => "Croatia",
    "CU" => "Cuba",
    "CY" => "Cyprus",
    "CZ" => "Czechia",
    "ship" => "Diamond Princess",
    "DK" => "Denmark",
    "DJ" => "Djibouti",
    "DM" => "Dominica",
    "DO" => "Dominican Republic",
    "NQ" => "Dronning Maud Land",
    "DD" => "East Germany",
    "EC" => "Ecuador",
    "EG" => "Egypt",
    "SV" => "El Salvador",
    "GQ" => "Equatorial Guinea",
    "ER" => "Eritrea",
    "EE" => "Estonia",
    "ET" => "Ethiopia",
    "FK" => "Falkland Islands",
    "FJ" => "Fiji",
    "FI" => "Finland",
    "FR" => "France",
    "GF" => "French Guiana",
    "PF" => "French Polynesia",
    "TF" => "French Southern Territories",
    "FQ" => "French Southern and Antarctic Territories",
    "GA" => "Gabon",
    "GM" => "Gambia",
    "GE" => "Georgia",
    "DE" => "Germany",
    "GH" => "Ghana",
    "GI" => "Gibraltar",
    "GR" => "Greece",
    "GL" => "Greenland",
    "GD" => "Grenada",
    "GP" => "Guadeloupe",
    "GU" => "Guam",
    "GT" => "Guatemala",
    "GG" => "Guernsey",
    "GN" => "Guinea",
    "GW" => "Guinea-Bissau",
    "GY" => "Guyana",
    "HT" => "Haiti",
    "HM" => "Heard Island and McDonald Islands",
    "HN" => "Honduras",
    "HK" => "Hong Kong",
    "HU" => "Hungary",
    "IS" => "Iceland",
    "IN" => "India",
    "ID" => "Indonesia",
    "IR" => "Iran",
    "IQ" => "Iraq",
    "IE" => "Ireland",
    "IM" => "Isle of Man",
    "IL" => "Israel",
    "IT" => "Italy",
    "JM" => "Jamaica",
    "JP" => "Japan",
    "JE" => "Channel Islands",
    "JT" => "Johnston Island",
    "JO" => "Jordan",
    "KZ" => "Kazakhstan",
    "KE" => "Kenya",
    "KI" => "Kiribati",
    "KW" => "Kuwait",
    "KG" => "Kyrgyzstan",
    "LA" => "Laos",
    "LV" => "Latvia",
    "LB" => "Lebanon",
    "LS" => "Lesotho",
    "LR" => "Liberia",
    "LY" => "Libya",
    "LI" => "Liechtenstein",
    "LT" => "Lithuania",
    "LU" => "Luxembourg",
    "MK" => "North Macedonia",
    "MG" => "Madagascar",
    "MW" => "Malawi",
    "SZ" => "Eswatini",
    "MY" => "Malaysia",
    "MV" => "Maldives",
    "ML" => "Mali",
    "MT" => "Malta",
    "MH" => "Marshall Islands",
    "MQ" => "Martinique",
    "MR" => "Mauritania",
    "MU" => "Mauritius",
    "YT" => "Mayotte",
    "FO" => "Faeroe Islands",
    "CI" => "Ivory Coast",
    "FX" => "Metropolitan France",
    "MX" => "Mexico",
    "FM" => "Micronesia",
    "MI" => "Midway Islands",
    "MD" => "Moldova",
    "MC" => "Monaco",
    "MN" => "Mongolia",
    "ME" => "Montenegro",
    "MS" => "Montserrat",
    "MA" => "Morocco",
    "MZ" => "Mozambique",
    "MM" => "Myanmar",
    "NA" => "Namibia",
    "NR" => "Nauru",
    "NP" => "Nepal",
    "NL" => "Netherlands",
    "AN" => "Netherlands Antilles",
    "NT" => "Neutral Zone",
    "NC" => "New Caledonia",
    "NZ" => "New Zealand",
    "NI" => "Nicaragua",
    "NE" => "Niger",
    "NG" => "Nigeria",
    "NU" => "Niue",
    "NF" => "Norfolk Island",
    "KP" => "North Korea",
    "VD" => "North Vietnam",
    "MP" => "Northern Mariana Islands",
    "NO" => "Norway",
    "OM" => "Oman",
    "PC" => "Pacific Islands Trust Territory",
    "PK" => "Pakistan",
    "PW" => "Palau",
    "PS" => "Palestine",
    "PA" => "Panama",
    "PZ" => "MS Zaandam",
    "PG" => "Papua New Guinea",
    "PY" => "Paraguay",
    "YD" => "People's Democratic Republic of Yemen",
    "PE" => "Peru",
    "PH" => "Philippines",
    "PN" => "Pitcairn Islands",
    "PL" => "Poland",
    "PT" => "Portugal",
    "PR" => "Puerto Rico",
    "VC" => "St. Vincent Grenadines",
    "QA" => "Qatar",
    "RO" => "Romania",
    "RU" => "Russia",
    "RW" => "Rwanda",
    "RE" => "Réunion",
    "BL" => "St. Barth",
    "SH" => "Saint Helena",
    "KN" => "Saint Kitts and Nevis",
    "LC" => "Saint Lucia",
    "MF" => "Saint Martin",
    "PM" => "Saint Pierre and Miquelon",
    "WS" => "Samoa",
    "SM" => "San Marino",
    "SA" => "Saudi Arabia",
    "SN" => "Senegal",
    "RS" => "Serbia",
    "CS" => "Serbia and Montenegro",
    "SC" => "Seychelles",
    "SL" => "Sierra Leone",
    "SG" => "Singapore",
    "SK" => "Slovakia",
    "SI" => "Slovenia",
    "SB" => "Solomon Islands",
    "SO" => "Somalia",
    "ZA" => "South Africa",
    "GS" => "South Georgia and the South Sandwich Islands",
    "KR" => "S. Korea",
    "ES" => "Spain",
    "LK" => "Sri Lanka",
    "SD" => "Sudan",
    "SR" => "Suriname",
    "SJ" => "Svalbard and Jan Mayen",
    "SE" => "Sweden",
    "CH" => "Switzerland",
    "CW" => "Curaçao",
    "SY" => "Syria",
    "ST" => "São Tomé and Príncipe",
    "TW" => "Taiwan",
    "TJ" => "Tajikistan",
    "TZ" => "Tanzania",
    "TH" => "Thailand",
    "TL" => "Timor-Leste",
    "TG" => "Togo",
    "TK" => "Tokelau",
    "TO" => "Tonga",
    "TT" => "Trinidad and Tobago",
    "TN" => "Tunisia",
    "TR" => "Turkey",
    "TM" => "Turkmenistan",
    "TC" => "Turks and Caicos",
    "TV" => "Tuvalu",
    "UM" => "U.S. Minor Outlying Islands",
    "PU" => "U.S. Miscellaneous Pacific Islands",
    "VI" => "U.S. Virgin Islands",
    "UG" => "Uganda",
    "UA" => "Ukraine",
    "SU" => "Union of Soviet Socialist Republics",
    "AE" => "UAE",
    "GB" => "UK",
    "US" => "USA",
    "ZZ" => "Unknown or Invalid Region",
    "UY" => "Uruguay",
    "UZ" => "Uzbekistan",
    "VU" => "Vanuatu",
    "VA" => "Vatican City",
    "VE" => "Venezuela",
    "VN" => "Vietnam",
    "WK" => "Wake Island",
    "WF" => "Wallis and Futuna",
    "EH" => "Western Sahara",
    "YE" => "Yemen",
    "ZM" => "Zambia",
    "ZW" => "Zimbabwe",
    "AX" => "Åland Islands",
];
