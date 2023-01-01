<?php

use App\Kodesign\Shamsi;
use App\Models\Unit;
use Illuminate\Support\Arr;

function activeState($needle, $haystack, $type = 'select', $loose_comparison = true)
{
    switch ($type) {
        case 'select':
            $output = 'selected';
            break;
        case 'check':
            $output = 'checked';
            break;
        default:
            $output = $type;
            break;
    }

    if (is_array($haystack) && in_array($needle, $haystack)) { // for multiple select box
        return $output;
    }



    if ($loose_comparison && $needle == $haystack) {
        return $output;
    }

    if (!$loose_comparison && $needle === $haystack) {
        return $output;
    }

    return null;
}

/**
 * Returns the instance of shamsi class
 *
 * @return Shamsi
 */
function shamsi() {
    return new Shamsi();
}

/**
 * Ads Http prefix to the given url if needed
 *
 * @param $url
 * @return string
 */
function linkFormat($url)
{
    if (!empty(trim($url)) && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

/**
 * Returns all the activity types
 *
 * @return array
 */
function activityTypes() {
    return [
        'buy' => 'خرید نسخه جدید',
        'update' => 'بروزرسانی',
        'renewal' => 'تمدید پشتیبانی',
        'pay' => 'پرداخت بدهی',
        'rename' => 'تغییر دامنه',
        'customize' => 'شخصی سازی و تغییرات'
    ];
}

/**
 * returns the formatted price
 *
 * @param $price
 * @return string
 */
function priceFormat($price, $show_currentcy = true)
{
    if ($show_currentcy) {
        return number_format($price) . ' تومان' ;
    }

    return number_format($price);
}

/**
 * Extracts the requested array($array_to_be_extracted) from the given array($main_array)
 * and only returns the requested elements from $main_array
 *
 * @param array $main_array
 * @param array $array_to_be_extracted
 * @return array
 */
function extractFrom(array $main_array, array $array_to_be_extracted) {
    return array_intersect_key($main_array, array_flip($array_to_be_extracted));
}

/**
 * makes the string camelCased
 *
 * @param $input
 * @param string $separator
 * @return mixed
 */
function camelize($input, $separator = '_')
{
    return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
}


/**
 * Removes extension from file name
 *
 * @param $name
 * @return false|string
 */
function removeExtension($name)
{
    return substr($name, 0, (strlen($name))-(strlen(strrchr($name, '.'))));
}

function translateRole($role) {
    if (empty($role)) return false;

    $roles = [
        'director' => 'کارگردان',
        'actor' => 'بازیگر',
        'writer' => 'نویسنده',
    ];

    return $roles[$role];
}

function correctArabicLetters($string) {
    $unwanted = array("؟", "ئ", ">", "<", "ء", "أ", "إ", "إ", "ؤ", "ی", "ة", "َ", "ُ", "ِ", "ّ", "ۀ", "ـ", "«", "»", "ً", "ٌ", "ٍ", "،", "؛", "ك", "ي");
    $cleaned = array("", "ی", "", "", "", "ا", "ا", "ا", "و", "ی", "ه", "", "", "", "", "ه", "", "", "", "", "", "", "", "", "ک", "ی");

    $string = str_replace($unwanted, $cleaned, $string);

    return trim($string);
}

/**
 * Get an item from an array using "dot" notation.
 *
 * @param  \ArrayAccess|array  $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
    return Arr::get($array, $key, $default);
}

/**
 * check if given mime type is a video or not
 *
 * @param $mime_type
 * @return bool
 */
function isVideo($mime_type) {
    if (str_starts_with($mime_type, 'video/') || in_array($mime_type, ['application/octet-stream'])) {
        return true;
    }
}

/**
 * check if given mime type is an image or not
 *
 * @param $mime_type
 * @return bool
 */
function isImage($mime_type) {
    return str_starts_with($mime_type, 'image/');
}

/**
 * Returns the file type of given mime_type
 *
 * @param $mime_type
 * @return string
 */
function typeOfFile($mime_type) {
    if (isVideo($mime_type)) {
        return 'video';
    }

    return 'image';
}

function defaultImageSizes() {
    return [
        'cover' => [
            'name' => 'کاور',
            'slug' => 'cover',
            'size' => '250x378',
            'resize_type' => 'DYNAMIC',
            'width' => 250,
            'height' => 378
        ],
        'thumb' => [
            'name' => 'بند انگشتی',
            'slug' => 'thumb',
            'size' => '250x250',
            'resize_type' => 'FIT',
            'width' => 250,
            'height' => 250
        ],
        'mini' => [
            'name' => 'کوچک',
            'slug' => 'mini',
            'size' => '92x62',
            'resize_type' => 'FIT',
            'width' => 100,
            'height' => 100
        ],
        'poster' => [
            'name' => 'پوستر',
            'slug' => 'poster',
            'size' => '1045x410',
            'resize_type' => 'LARGE',
            'width' => 1045,
            'height' => 410
        ]
    ];
}
