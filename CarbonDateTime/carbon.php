<?php

require_once __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\Factory;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Carbon\CarbonDateTime;
use Carbon\Carbonite;
use Carbon\CarbonTimeZone;
/*
$mutable = Carbon::now();
$immutable = CarbonImmutable::now();
$modifiedMutable = $mutable->add(1, 'day');
$modifiedImmutable = CarbonImmutable::now()->add(1, 'day');

printf($modifiedImmutable . "\n");

var_dump($modifiedMutable === $mutable);             
var_dump($mutable->isoFormat('dddd D'));             
var_dump($modifiedMutable->isoFormat('dddd D'));

var_dump($modifiedImmutable === $immutable);         
var_dump($immutable->isoFormat('dddd D'));           
var_dump($modifiedImmutable->isoFormat('dddd D')); 

////////////////////////////////////////////////////////////////////////////////

$mutable = CarbonImmutable::now()->toMutable();
var_dump($mutable->isMutable());                  
var_dump($mutable->isImmutable());                  
$immutable = Carbon::now()->toImmutable();
var_dump($immutable->isMutable());                  
var_dump($immutable->isImmutable());



$dtToronto = Carbon::create(2012, 1, 1, 0, 0, 0, 'America/Toronto');
$dtVancouver = Carbon::create(2012, 1, 1, 0, 0, 0, 'America/Vancouver');

echo ($dtVancouver->diffInHours($dtToronto));

$carbon = new Carbon();                  // equivalent to Carbon::now()
$carbon = new Carbon('first day of January 2008', 'America/Vancouver');
echo get_class($carbon);                 // 'Carbon\Carbon'

$carbon = new Carbon(new DateTime('first day of January 2008'), 
new DateTimeZone('America/Vancouver')); 

echo "\n".$carbon;

$now = Carbon::now(); // will use timezone as set with date_default_timezone_set
// PS: we recommend you to work with UTC as default timezone and only use
// other timezones (such as the user timezone) on display

$nowInLondonTz = Carbon::now(new DateTimeZone('Europe/London'));

// or just pass the timezone as a string
$nowInLondonTz = Carbon::now('Europe/London');
echo $nowInLondonTz->tzName;             // Europe/London
echo "\n";

// or to create a date with a custom fixed timezone offset
$date = Carbon::now('+13:30');
echo $date->tzName;                      // +13:30
echo "\n";

// Get/set minutes offset from UTC
echo $date->utcOffset();                 // 810
echo "\n";

$date->utcOffset(180);

echo $date->tzName;                      // +03:00
echo "\n";
echo $date->utcOffset();                 // 180
////////////////////////////////////////////////////////////////////////////////
echo (new Carbon('first day of December 2008'))->addWeeks(2);   // 2008-12-15 00:00:00
echo "\n";
echo Carbon::parse('first day of December 2008')->addWeeks(2);  // 2008-12-15 00:00:00

////////////////////////////////////////////////////////////////////////////////
$string = 'first day of next month';
if (strtotime($string) === false) {
    echo "'$string' is not a valid date/time string.";
} elseif (Carbon::hasRelativeKeywords($string)) {
    echo "'$string' is a relative valid date/time string, it will returns 
    different dates depending on the current date.";
} else {
    echo "'$string' is an absolute date/time string, it will always returns 
    the same date.";
}

////////////////////////////////////////////////////////////////////////////////
$now = Carbon::now();
echo $now;                               // 2024-03-30 22:42:51
echo "\n";
$today = Carbon::today();
echo $today;                             // 2024-03-30 00:00:00
echo "\n";
$tomorrow = Carbon::tomorrow('Europe/London');
echo $tomorrow;                          // 2024-03-31 00:00:00
echo "\n";
$yesterday = Carbon::yesterday();
echo $yesterday;                         // 2024-03-29 00:00:00

////////////////////////////////////////////////////////////////////////////////
$year = 2000; $month = 4; $day = 19;
$hour = 20; $minute = 30; $second = 15; $tz = 'Europe/Madrid';
echo Carbon::createFromDate($year, $month, $day, $tz)."\n";
echo Carbon::createMidnightDate($year, $month, $day, $tz)."\n";
echo Carbon::createFromTime($hour, $minute, $second, $tz)."\n";
echo Carbon::createFromTimeString("$hour:$minute:$second", $tz)."\n";
echo Carbon::create($year, $month, $day, $hour, $minute, $second, $tz)."\n";

////////////////////////////////////////////////////////////////////////////////


$xmasThisYear = Carbon::createFromDate(null, 12, 25);  // Year defaults to current year
$Y2K = Carbon::create(2000, 1, 1, 0, 0, 0); // equivalent to Carbon::createMidnightDate(2000, 1, 1)
$alsoY2K = Carbon::create(1999, 12, 31, 24);
$noonLondonTz = Carbon::createFromTime(12, 0, 0, 'Europe/London');
$teaTime = Carbon::createFromTimeString('17:00:00', 'Europe/London');

try { Carbon::create(1975, 5, 21, 22, -2, 0); } catch(InvalidArgumentException $x) { echo $x->getMessage(); }
// minute must be between 0 and 99, -2 given

// Be careful, as Carbon::createFromDate() default values to current date, it can trigger overflow:
// For example, if we are the 15th of June 2020, the following will set the date on 15:
Carbon::createFromDate(2019, 4); // 2019-04-15
// If we are the 31th of October, as 31th April does not exist, it overflows to May:
Carbon::createFromDate(2019, 4); // 2019-05-01
// That's why you simply should not use Carbon::createFromDate() with only 2 parameters (1 or 3 are safe, but no 2)

////////////////////////////////////////////////////////////////////////////////

echo Carbon::create(2000, 1, 35, 13, 0, 0);
// 2000-02-04 13:00:00
echo "\n";

try {
    Carbon::createSafe(2000, 1, 35, 13, 0, 0);
} catch (\Carbon\Exceptions\InvalidDateException $exp) {
    echo $exp->getMessage();
}
// day : 35 is not a valid value.

////////////////////////////////////////////////////////////////////////////////

var_dump(Carbon::hasFormatWithModifiers('21/05/1975', 'd#m#Y!')); // bool(true)
// As 21 is too high for a month number and day is expected to be formatted "05":
var_dump(Carbon::hasFormatWithModifiers('5/21/1975', 'd#m#Y!')); // bool(false)
// 5 is ok for N format:
var_dump(Carbon::hasFormatWithModifiers('5', 'N')); // bool(true)
// but not enough to create an instance:
var_dump(Carbon::canBeCreatedFromFormat('5', 'N')); // bool(false)
// Both hasFormatWithModifiers() and hasFormat() exist because
// hasFormat() does not interpret modifiers, it checks strictly if ->format() 
//could have produce the given
// string with the given format:
var_dump(Carbon::hasFormat('21/05/1975', 'd#m#Y!')); // bool(false)
var_dump(Carbon::hasFormat('21#05#1975!', 'd#m#Y!')); // bool(true)

////////////////////////////////////////////////////////////////////////////////


echo Carbon::createFromTimestamp(-1)->toDateTimeString();                                             // 1969-12-31 23:59:59
echo "\n";
echo Carbon::createFromTimestamp(-1.5, 'Europe/London')->toDateTimeString();                          // 1970-01-01 00:59:58
echo "\n";
echo Carbon::createFromTimestampUTC(-1)->toDateTimeString();                                          // 1969-12-31 23:59:59
echo "\n";
echo Carbon::createFromTimestamp('1601735792.198956', 'Europe/London')->format('Y-m-d\TH:i:s.uP');    // 2020-10-03T15:36:32.198956+01:00
echo "\n";
echo Carbon::createFromTimestampUTC('0.198956 1601735792')->format('Y-m-d\TH:i:s.uP');                // 2020-10-03T14:36:32.198956+00:00
echo "\n";
echo Carbon::createFromTimestampMs(1)->format('Y-m-d\TH:i:s.uP');                                     // 1970-01-01T00:00:00.001000+00:00
echo "\n";
echo Carbon::createFromTimestampMs('1601735792198.956', 'Europe/London')->format('Y-m-d\TH:i:s.uP');  // 2020-10-03T15:36:32.198956+01:00
echo "\n";
echo Carbon::createFromTimestampMsUTC('0.956 1601735792198')->format('Y-m-d\TH:i:s.uP');              // 2020-10-03T14:36:32.198956+00:00

////////////////////////////////////////////////////////////////////////////////


$dt = Carbon::now();
echo $dt->diffInYears($dt->copy()->addYear());  // 1

// $dt was unchanged and still holds the value of Carbon:now()

// Without ->copy() it would return 0 because addYear() modify $dt so
// diffInYears() compare $dt with itself:
echo $dt->diffInYears($dt->addYear());  // 0

// Note that this would not happen neither with CarbonImmutable
// When immutable, any add/sub methods return a new instance:
$dt = CarbonImmutable::now();
echo $dt->diffInYears($dt->addYear());  // 1

// Last, when your variable can be either a Carbon or CarbonImmutable,
// You can use avoidMutation() which will copy() only if the given date
// is mutable:
echo $dt->diffInYears($dt->avoidMutation()->addYear());  // 1

////////////////////////////////////////////////////////////////////////////////

$meeting = Carbon::createFromTime(19, 15, 00, 'Africa/Johannesburg');

// 19:15 in Johannesburg
echo 'Meeting starts at '.$meeting->format('H:i').' in Johannesburg.';                  // Meeting starts at 19:15 in Johannesburg.
// now in Johannesburg
echo "It's ".$meeting->nowWithSameTz()->format('H:i').' right now in Johannesburg.';    // It's 00:42 right now in Johannesburg.

////////////////////////////////////////////////////////////////////////////////

$dt = new \DateTime('first day of January 2008'); // <== instance from another API
$carbon = Carbon::instance($dt);
echo get_class($carbon);                               // 'Carbon\Carbon'
echo $carbon->toDateTimeString();                      // 2008-01-01 00:00:00

////////////////////////////////////////////////////////////////////////////////
// we recommend to use custom language name/variant
// rather than overriding an existing language
// to avoid conflict such as "en_Boring" in the example below:
$boringLanguage = 'en_Boring';
$translator = \Carbon\Translator::get($boringLanguage);
$translator->setTranslations([
    'day' => ':count boring day|:count boring days',
]);
// as this language starts with "en_" it will inherit from the locale "en"

$date1 = Carbon::create(2018, 1, 1, 0, 0, 0);
$date2 = Carbon::create(2018, 1, 4, 4, 0, 0);

echo $date1->locale($boringLanguage)->diffForHumans($date2); // 3 boring days before

$translator->setTranslations([
    'before' => function ($time) {
        return '['.strtoupper($time).']';
    },
]);

echo $date1->locale($boringLanguage)->diffForHumans($date2); // [3 BORING DAYS]
////////////////////////////////////////////////////////////////////////////////

\Carbon\Translator::get('xx')->setTranslations([
    'day' => ':count Xday',
]);
\Carbon\Translator::get('xy')->setTranslations([
    'day' => ':count Yday',
    'hour' => ':count Yhour',
]);

$date = Carbon::now()->locale('xx', 'xy', 'es')->sub('3 days 6 hours 40 minutes');

echo $date->ago(['parts' => 3]); // hace 3 Xday 6 Yhour 40 minutos

////////////////////////////////////////////////////////////////////////////////

echo implode(', ', array_slice(Carbon::getAvailableLocales(), 0, 3)).'...';      // aa, aa_DJ, aa_ER...

// Support diff syntax (before, after, from now, ago)
var_dump(Carbon::localeHasDiffSyntax('en'));                                     // bool(true)
var_dump(Carbon::localeHasDiffSyntax('zh_TW'));                                  // bool(true)
// Support 1-day diff words (just now, yesterday, tomorrow)
var_dump(Carbon::localeHasDiffOneDayWords('en'));                                // bool(true)
var_dump(Carbon::localeHasDiffOneDayWords('zh_TW'));                             // bool(true)
// Support 2-days diff words (before yesterday, after tomorrow)
var_dump(Carbon::localeHasDiffTwoDayWords('en'));                                // bool(true)
var_dump(Carbon::localeHasDiffTwoDayWords('zh_TW'));                             // bool(false)
// Support short units (1y = 1 year, 1mo = 1 month, etc.)
var_dump(Carbon::localeHasShortUnits('en'));                                     // bool(true)
var_dump(Carbon::localeHasShortUnits('zh_TW'));                                  // bool(false)
// Support period syntax (X times, every X, from X, to X)
var_dump(Carbon::localeHasPeriodSyntax('en'));                                   // bool(true)
var_dump(Carbon::localeHasPeriodSyntax('zh_TW'));                                // bool(false)

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::now()->locale('fr_FR');

echo $date->locale();            // fr_FR
echo "\n";
echo $date->diffForHumans();     // il y a 0 seconde
echo "\n";
echo $date->monthName;           // mars
echo "\n";
echo $date->isoFormat('LLLL');   // samedi 30 mars 2024 22:42

////////////////////////////////////////////////////////////////////////////////


// Let say Martin from Paris and John from Chicago play chess
$martinDateFactory = new Factory([
    'locale' => 'fr_FR',
    'timezone' => 'Europe/Paris',
]);
$johnDateFactory = new Factory([
    'locale' => 'en_US',
    'timezone' => 'America/Chicago',
]);
// Each one will see date in his own language and timezone

// When Martin moves, we display things in French, but we notify John in English:
$gameStart = Carbon::parse('2018-06-15 12:34:00', 'UTC');
$move = Carbon::now('UTC');
$toDisplay = $martinDateFactory->make($gameStart)->isoFormat('lll')."\n".
    $martinDateFactory->make($move)->calendar()."\n";
$notificationForJohn = $johnDateFactory->make($gameStart)->isoFormat('lll')."\n".
    $johnDateFactory->make($move)->calendar()."\n";
echo $toDisplay;

//15 juin 2018 14:34
//Aujourd’hui à 23:42


echo $notificationForJohn;

//Jun 15, 2018 7:34 AM
//Today at 5:42 PM

////////////////////////////////////////////////////////////////////////////////

$factory = new Factory([
    'locale' => 'fr_FR',
    'timezone' => 'Europe/Paris',
]);
$factory->now(); // You can recall $factory as needed to generate new instances with same settings
// is equivalent to:
Carbon::now()->settings([
    'locale' => 'fr_FR',
    'timezone' => 'Europe/Paris',
]);
// Important note: timezone setting calls ->shiftTimezone() and not ->setTimezone(),
// It means it does not just set the timezone, but shift the time too:
echo Carbon::today()->setTimezone('Asia/Tokyo')->format('d/m G\h e');        // 30/03 9h Asia/Tokyo
echo "\n";
echo Carbon::today()->shiftTimezone('Asia/Tokyo')->format('d/m G\h e');      // 30/03 0h Asia/Tokyo

// You can find back which factory created a given object:
$a = $factory->now();
$b = Carbon::now();
var_dump($a->getClock()->unwrap() === $factory);  // bool(true)
var_dump($b->getClock());                         // NULL

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::parse('Today 12:34:56')->settings([
    'macros' => [
        'lastSecondDigit' => fn () => self::this()->second % 10,
    ],
]);

echo $date->lastSecondDigit();                         // 6
var_dump($date->hasLocalMacro('lastSecondDigit'));     // bool(true)
// You can also retrieve the macro closure using ->getLocalMacro('lastSecondDigit')

////////////////////////////////////////////////////////////////////////////////

$factory = new Factory(['locale' => 'ja'], CarbonImmutable::class);
var_dump($factory->now()->locale);                                           // string(2) "ja"
var_dump(get_class($factory->now()));                                        // string(22) "Carbon\CarbonImmutable"

class MyCustomCarbonSubClass extends Carbon {  }
$factory
    ->setSettings(['locale' => 'zh_CN'])
    ->setClassName(MyCustomCarbonSubClass::class);
var_dump($factory->now()->locale);                                           // string(5) "zh_CN"
var_dump(get_class($factory->now()));                                        // string(22) "MyCustomCarbonSubClass"

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::parse('2018-06-15 17:34:15.984512', 'UTC');
echo $date->isoFormat('MMMM Do YYYY, h:mm:ss a'); // June 15th 2018, 5:34:15 pm
echo "\n";
echo $date->isoFormat('dddd');           // Friday
echo "\n";
echo $date->isoFormat('MMM Do YY');      // Jun 15th 18
echo "\n";
echo $date->isoFormat('YYYY [escaped] YYYY'); // 2018 escaped 2018

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::createFromIsoFormat('!YYYY-MMMM-D h:mm:ss a', '2019-January-3 6:33:24 pm', 'UTC');
echo $date->isoFormat('M/D/YY HH:mm'); // 1/3/19 18:33

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::parse('2018-03-16')->locale('uk');
echo $date->getTranslatedDayName('[в] dddd'); // п’ятницю
// By providing a context, we're saying translate day name like in a format such as [в] dddd
// So the context itself has to be translated first consistently.
echo "\n";
echo $date->getTranslatedDayName('[наступної] dddd'); // п’ятниці
echo "\n";
echo $date->getTranslatedDayName('dddd, MMM'); // п’ятниця
echo "\n";
// The same goes for short/minified variants:
echo $date->getTranslatedShortDayName('[наступної] dd'); // пт
echo "\n";
echo $date->getTranslatedMinDayName('[наступної] ddd'); // пт
echo "\n";

// And the same goes for months
$date->locale('ru');
echo $date->getTranslatedMonthName('Do MMMM'); // марта
echo "\n";
echo $date->getTranslatedMonthName('MMMM YYYY'); // март
echo "\n";
// Short variant
echo $date->getTranslatedShortMonthName('Do MMM'); // мар
echo "\n";
echo $date->getTranslatedShortMonthName('MMM YYYY'); // мар
echo "\n";

// And so you can force a different context to get those variants:
echo $date->isoFormat('Do MMMM');        // 16-го марта
echo "\n";
echo $date->isoFormat('MMMM YYYY');      // март 2018
echo "\n";
echo $date->isoFormat('Do MMMM', 'MMMM YYYY'); // 16-го март
echo "\n";
echo $date->isoFormat('MMMM YYYY', 'Do MMMM'); // марта 2018
echo "\n";

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::createFromIsoFormat('LLLL', 'Monday 11 March 2019 16:28', null, 'fr');
echo $date->isoFormat('M/D/YY HH:mm'); // 3/11/19 16:28

////////////////////////////////////////////////////////////////////////////////

$date = CarbonImmutable::now();
echo $date->calendar();                                      // Today at 10:42 PM
echo "\n";
echo $date->sub('1 day 3 hours')->calendar();                // Yesterday at 7:42 PM
echo "\n";
echo $date->sub('3 days 10 hours 23 minutes')->calendar();   // Last Wednesday at 12:19 PM
echo "\n";
echo $date->sub('8 days')->calendar();                       // 03/22/2024
echo "\n";
echo $date->add('1 day 3 hours')->calendar();                // Monday at 1:42 AM
echo "\n";
echo $date->add('3 days 10 hours 23 minutes')->calendar();   // Wednesday at 9:05 AM
echo "\n";
echo $date->add('8 days')->calendar();                       // 04/07/2024
echo "\n";
echo $date->locale('fr')->calendar();                        // Aujourd’hui à 22:42

$date1 = CarbonImmutable::parse('2018-01-01 12:00:00');
$date2 = CarbonImmutable::parse('2018-01-02 8:00:00');

////////////////////////////////////////////////////////////////////////////////

echo $date1->calendar($date2, [
    'lastDay' => '[Previous day at] LT',
]);
// Previous day at 12:00 PM


////////////////////////////////////////////////////////////////////////////////
$date = Carbon::parse('2018-03-16 15:45')->locale('uk');

echo $date->translatedFormat('g:i a l jS F Y'); // 3:45 дня п’ятниця 16-го березня 2018


$date = Carbon::parse('2018-03-16 15:45')->locale('ja');

echo $date->format('g:i a l jS F Y');    // 3:45 pm Friday 16th March 2018
echo "\n";

$date->settings(['formatFunction' => 'translatedFormat']);

echo $date->format('g:i a l jS F Y');    // 3:45 午後 金曜日 16日 3月 2018
echo "\n";

$date->settings(['formatFunction' => 'isoFormat']);

echo $date->format('LL');                // 2018年3月16日
echo "\n";

// When you set a custom format() method you still can access the native method using rawFormat()
echo $date->rawFormat('D');              // Fri

echo Carbon::translateTimeString('mercredi 8 juillet', 'fr', 'nl');
// woensdag 8 juli
echo "\n";

// You can select translations to use among available constants:
// - CarbonInterface::TRANSLATE_MONTHS
// - CarbonInterface::TRANSLATE_DAYS
// - CarbonInterface::TRANSLATE_UNITS
// - CarbonInterface::TRANSLATE_MERIDIEM
// - CarbonInterface::TRANSLATE_ALL (all above)
// You can combine them with pipes: like below (translate units and days but not months and meridiem):
echo Carbon::translateTimeString('mercredi 8 juillet + 3 jours', 'fr', 'nl', CarbonInterface::TRANSLATE_DAYS | CarbonInterface::TRANSLATE_UNITS);
// woensdag 8 juillet + 3 dagen

////////////////////////////////////////////////////////////////////////////////

echo Carbon::now()->locale('fr')->translateTimeStringTo('mercredi 8 juillet + 3 jours', 'nl');
// woensdag 8 juli + 3 dagen

////////////////////////////////////////////////////////////////////////////////

$date = Carbon::parseFromLocale('mercredi 6 mars 2019 + 3 jours', 'fr', 'UTC'); // timezone is optional
// 'fr' stands for French but can be replaced with any locale code.
// if you don't pass the locale parameter, Carbon::getLocale() (current global locale) is used.

echo $date->isoFormat('LLLL'); // Saturday, March 9, 2019 12:00 AM

////////////////////////////////////////////////////////////////////////////////
$date = Carbon::createFromLocaleFormat('!d/F/y', 'fr', '25/Août/19', 'Europe/Paris'); // timezone is optional

echo $date->isoFormat('LLLL'); // Sunday, August 25, 2019 12:00 AM

////////////////////////////////////////////////////////////////////////////////
$date = Carbon::createFromLocaleIsoFormat('!DD/MMMM/YY', 'fr', '25/Août/19', 'Europe/Paris'); // timezone is optional

echo $date->isoFormat('LLLL'); // Sunday, August 25, 2019 12:00 AM

////////////////////////////////////////////////////////////////////////////////
$zhTwInfo = Carbon::getAvailableLocalesInfo()['zh_TW'];
$srCyrlInfo = Carbon::getAvailableLocalesInfo()['sr_Cyrl'];
$caInfo = Carbon::getAvailableLocalesInfo()['ca'];

var_dump($zhTwInfo->getId());                      // string(5) "zh_TW"
var_dump($zhTwInfo->getNames());

//array(2) {
//  ["isoName"]=>
//  string(7) "Chinese"
//  ["nativeName"]=>
//  string(38) "中文 (Zhōngwén), 汉语, 漢語"
//}

var_dump($zhTwInfo->getCode());                    // string(2) "zh"
var_dump($zhTwInfo->getVariant());                 // NULL
var_dump($srCyrlInfo->getVariant());               // string(4) "Cyrl"
var_dump($zhTwInfo->getVariantName());             // NULL
var_dump($srCyrlInfo->getVariantName());           // string(8) "Cyrillic"
var_dump($zhTwInfo->getRegion());                  // string(2) "TW"
var_dump($srCyrlInfo->getRegion());                // NULL
var_dump($zhTwInfo->getRegionName());              // string(6) "Taiwan"
var_dump($srCyrlInfo->getRegionName());            // NULL
var_dump($zhTwInfo->getFullIsoName());             // string(7) "Chinese"
var_dump($caInfo->getFullIsoName());               // string(18) "Catalan, Valencian"
var_dump($zhTwInfo->getFullNativeName());          // string(38) "中文 (Zhōngwén), 汉语, 漢語"
var_dump($caInfo->getFullNativeName());            // string(18) "català, valencià"
var_dump($zhTwInfo->getIsoName());                 // string(7) "Chinese"
var_dump($caInfo->getIsoName());                   // string(7) "Catalan"
var_dump($zhTwInfo->getNativeName());              // string(20) "中文 (Zhōngwén)"
var_dump($caInfo->getNativeName());                // string(7) "català"
var_dump($zhTwInfo->getIsoDescription());          // string(16) "Chinese (Taiwan)"
var_dump($srCyrlInfo->getIsoDescription());        // string(18) "Serbian (Cyrillic)"
var_dump($caInfo->getIsoDescription());            // string(7) "Catalan"
var_dump($zhTwInfo->getNativeDescription());       // string(29) "中文 (Zhōngwén) (Taiwan)"
var_dump($srCyrlInfo->getNativeDescription());     // string(34) "српски језик (Cyrillic)"
var_dump($caInfo->getNativeDescription());         // string(7) "català"
var_dump($zhTwInfo->getFullIsoDescription());      // string(16) "Chinese (Taiwan)"
var_dump($srCyrlInfo->getFullIsoDescription());    // string(18) "Serbian (Cyrillic)"
var_dump($caInfo->getFullIsoDescription());        // string(18) "Catalan, Valencian"
var_dump($zhTwInfo->getFullNativeDescription());   // string(47) "中文 (Zhōngwén), 汉语, 漢語 (Taiwan)"
var_dump($srCyrlInfo->getFullNativeDescription()); // string(34) "српски језик (Cyrillic)"
var_dump($caInfo->getFullNativeDescription());     // string(18) "català, valencià"

$srCyrlInfo->setIsoName('foo, bar')->setNativeName('biz, baz');
var_dump($srCyrlInfo->getIsoName());               // string(3) "foo"
var_dump($srCyrlInfo->getFullIsoName());           // string(8) "foo, bar"
var_dump($srCyrlInfo->getFullIsoDescription());    // string(19) "foo, bar (Cyrillic)"
var_dump($srCyrlInfo->getNativeName());            // string(3) "biz"
var_dump($srCyrlInfo->getFullNativeName());        // string(8) "biz, baz"
var_dump($srCyrlInfo->getFullNativeDescription()); // string(19) "biz, baz (Cyrillic)"

// You can also access directly regions/languages lists:
var_dump(\Carbon\Language::all()['zh']);
//
array(2) {
//  ["isoName"]=>
//  string(7) "Chinese"
 // ["nativeName"]=>
 // string(38) "中文 (Zhōngwén), 汉语, 漢語"
}
//
var_dump(\Carbon\Language::regions()['TW']);
//
//string(6) "Taiwan"
//

////////////////////////////////////////////////////////////////////////////////
//Carbon::executeWithLocale('fr', function () {
//    echo CarbonInterval::create(2, 1)->forHumans() . "\n";
//    echo Carbon::parse('-2 hours')->diffForHumans();
//});
//
$knownDate = Carbon::create(2001, 5, 21, 12);          // create testing date
Carbon::setTestNow($knownDate);                        // set the mock (of course this could be a real mock object)
echo Carbon::getTestNow();                             // 2001-05-21 12:00:00
echo Carbon::now();                                    // 2001-05-21 12:00:00
echo new Carbon();                                     // 2001-05-21 12:00:00
echo new Carbon('now');                                // 2001-05-21 12:00:00
echo Carbon::parse('now');                             // 2001-05-21 12:00:00
echo Carbon::create(2001, 4, 21, 12)->diffForHumans(); // 1 month ago

// This will trigger an actual sleep(3) in prod, but when time is mocked,
// This will set the test-now to 3 seconds later:
Carbon::sleep(3);
echo Carbon::now();                                    // 2001-05-21 12:00:03

var_dump(Carbon::hasTestNow());                        // bool(true)
Carbon::setTestNow();                                  // clear the mock
var_dump(Carbon::hasTestNow());                        // bool(false)
echo Carbon::now();                                    // 2024-03-30 22:42:52
// Instead of mock and clear mock, you also can use withTestNow():

Carbon::withTestNow('2010-09-15', static function () {
    echo Carbon::now();
});                                                    // 2010-09-15 00:00:00

class SeasonalProduct
{
    protected $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function getPrice() {
        $multiplier = 1;
        if (Carbon::now()->month == 12) {
            $multiplier = 2;
        }

        return $this->price * $multiplier;
    }
}

$product = new SeasonalProduct(100);
Carbon::setTestNow(Carbon::parse('first day of March 2000'));
echo $product->getPrice();                                             // 100
Carbon::setTestNow(Carbon::parse('first day of December 2000'));
echo $product->getPrice();                                             // 200
Carbon::setTestNow(Carbon::parse('first day of May 2000'));
echo $product->getPrice();                                             // 100
Carbon::setTestNow();

$knownDate = Carbon::create(2001, 5, 21, 12);          // create testing date
Carbon::setTestNow($knownDate);                        // set the mock
echo new Carbon('tomorrow');                           // 2001-05-22 00:00:00  ... notice the time !
echo new Carbon('yesterday');                          // 2001-05-20 00:00:00
echo new Carbon('next wednesday');                     // 2001-05-23 00:00:00
echo new Carbon('last friday');                        // 2001-05-18 00:00:00
echo new Carbon('this thursday');                      // 2001-05-24 00:00:00
Carbon::setTestNow();                                  // always clear it !

Carbon::setTestNowAndTimezone(Carbon::parse('2022-01-24 10:45 America/Toronto'));
// or
Carbon::setTestNowAndTimezone('2022-01-24 10:45', 'America/Toronto');
echo Carbon::now()->format('Y-m-d e'); // 2022-01-24 America/Toronto
Carbon::setTestNow(); // clear time mock
date_default_timezone_set('UTC'); // restore default timezone

echo Carbon::parse('2012-9-5 23:26:11.223', 'Europe/Paris')->timezone->getName(); // Europe/Paris


$holidays = CarbonPeriod::create('2019-12-23', '2020-01-06', CarbonPeriod::EXCLUDE_END_DATE);

Carbonite::freeze('2019-12-22'); // Freeze the time to a given date

var_dump($holidays->isStarted());     // bool(false)

// Then go to anytime:
Carbonite::elapse('1 day');

var_dump($holidays->isInProgress());  // bool(true)

Carbonite::jumpTo('2020-01-05 22:00');

var_dump($holidays->isEnded());       // bool(false)

Carbonite::elapse('2 hours');

var_dump($holidays->isEnded());       // bool(true)

Carbonite::rewind('1 microsecond');

var_dump($holidays->isEnded());       // bool(false)

Carbonite::release(); // Release time after each test


$dt = Carbon::parse('2012-10-5 23:26:11.123789');

// These getters specifically return integers, ie intval()
var_dump($dt->year);                                         // int(2012)
var_dump($dt->month);                                        // int(10)
var_dump($dt->day);                                          // int(5)
var_dump($dt->hour);                                         // int(23)
var_dump($dt->minute);                                       // int(26)
var_dump($dt->second);                                       // int(11)
var_dump($dt->micro);                                        // int(123789)
// dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
var_dump($dt->dayOfWeek);                                    // int(5)
// dayOfWeekIso returns a number between 1 (monday) and 7 (sunday)
var_dump($dt->dayOfWeekIso);                                 // int(5)
var_dump($dt->englishDayOfWeek);                             // string(6) "Friday"
var_dump($dt->shortEnglishDayOfWeek);                        // string(3) "Fri"
var_dump($dt->locale('de')->dayName);                        // string(7) "Freitag"
var_dump($dt->locale('de')->shortDayName);                   // string(3) "Fr."
var_dump($dt->locale('de')->minDayName);                     // string(2) "Fr"
var_dump($dt->englishMonth);                                 // string(7) "October"
var_dump($dt->shortEnglishMonth);                            // string(3) "Oct"
var_dump($dt->locale('de')->monthName);                      // string(7) "Oktober"
var_dump($dt->locale('de')->shortMonthName);                 // string(3) "Okt"

var_dump($dt->dayOfYear);                                    // int(279)
var_dump($dt->weekNumberInMonth);                            // int(1)
// weekNumberInMonth consider weeks from monday to sunday, so the week 1 will
// contain 1 day if the month start with a sunday, and up to 7 if it starts with a monday
var_dump($dt->weekOfMonth);                                  // int(1)
// weekOfMonth will returns 1 for the 7 first days of the month, then 2 from the 8th to
// the 14th, 3 from the 15th to the 21st, 4 from 22nd to 28th and 5 above
var_dump($dt->weekOfYear);                                   // int(40)
var_dump($dt->daysInMonth);                                  // int(31)
var_dump($dt->timestamp);                                    // int(1349479571)
var_dump($dt->getTimestamp());                               // int(1349479571)
// Millisecond-precise timestamp as int
var_dump($dt->getTimestampMs());                             // int(1349479571124)
// Millisecond-precise timestamp as float (useful to pass it to JavaScript)
var_dump($dt->valueOf());                                    // float(1349479571124)
// Custom-precision timestamp
var_dump($dt->getPreciseTimestamp(6));                       // float(1349479571123789)
var_dump(Carbon::createFromDate(1975, 5, 21)->age);          // int(48) calculated vs now in the same tz
var_dump($dt->quarter);                                      // int(4)

// Returns an int of seconds difference from UTC (+/- sign included)
var_dump(Carbon::createFromTimestampUTC(0)->offset);         // int(0)
var_dump(Carbon::createFromTimestamp(0, 'Europe/Paris')->offset);                // int(3600)
var_dump(Carbon::createFromTimestamp(0, 'Europe/Paris')->getOffset());           // int(3600)

// Returns an int of hours difference from UTC (+/- sign included)
var_dump(Carbon::createFromTimestamp(0, 'Europe/Paris')->offsetMinutes);         // int(60)
var_dump(Carbon::createFromTimestamp(0, 'Europe/Paris')->offsetHours);           // int(1)

// Returns timezone offset as string
var_dump(Carbon::createFromTimestamp(0, 'Europe/Paris')->getOffsetString());     // string(6) "+01:00"

// Returns timezone as CarbonTimeZone
var_dump(Carbon::createFromTimestamp(0, 'Europe/Paris')->getTimezone());
// object(Carbon\CarbonTimeZone)#532 (3) {
//  ["clock":"Carbon\CarbonTimeZone":private]=>
//  NULL
//  ["timezone_type"]=>
//  int(3)
//  ["timezone"]=>
//  string(12) "Europe/Paris"
//} 

// Indicates if day light savings time is on
var_dump(Carbon::createFromDate(2012, 1, 1)->dst);           // bool(false)
var_dump(Carbon::createFromDate(2012, 9, 1)->dst);           // bool(false)
var_dump(Carbon::createFromDate(2012, 9, 1)->isDST());       // bool(false)

// Indicates if the instance is in the same timezone as the local timezone
var_dump(Carbon::now()->local);                              // bool(true)
var_dump(Carbon::now('America/Vancouver')->local);           // bool(false)
var_dump(Carbon::now()->isLocal());                          // bool(true)
var_dump(Carbon::now('America/Vancouver')->isLocal());       // bool(false)
var_dump(Carbon::now()->isUtc());                            // bool(true)
var_dump(Carbon::now('America/Vancouver')->isUtc());         // bool(false)
// can also be written ->isUTC()

// Indicates if the instance is in the UTC timezone
var_dump(Carbon::now()->utc);                                // bool(true)
// London is not UTC on summer time
var_dump(Carbon::parse('2018-10-01', 'Europe/London')->utc); // bool(false)
// London is UTC on winter time
var_dump(Carbon::parse('2018-11-01', 'Europe/London')->utc); // bool(true)
var_dump(Carbon::createFromTimestampUTC(0)->utc);            // bool(true)

// Gets the DateTimeZone instance
echo get_class(Carbon::now()->timezone);                     // Carbon\CarbonTimeZone
echo "\n";
echo get_class(Carbon::now()->tz);                           // Carbon\CarbonTimeZone
echo "\n";

// Gets the DateTimeZone instance name, shortcut for ->timezone->getName()
echo Carbon::now()->timezoneName;                            // UTC
echo "\n";
echo Carbon::now()->tzName;                                  // UTC
echo "\n";

// You can get any property dynamically too:
$unit = 'second';
var_dump(Carbon::now()->get($unit));                         // int(52)
// equivalent to:
var_dump(Carbon::now()->$unit);                              // int(52)
// If you have plural unit name, use singularUnit()
$unit = Carbon::singularUnit('seconds');
var_dump(Carbon::now()->get($unit));                         // int(52)
// Prefer using singularUnit() because some plurals are not the word with S:
var_dump(Carbon::pluralUnit('century'));                     // string(9) "centuries"
var_dump(Carbon::pluralUnit('millennium'));                  // string(9) "millennia"



$dt = Carbon::now();

$dt->year = 1975;
$dt->month = 13;             // would force year++ and month = 1
$dt->month = 5;
$dt->day = 21;
$dt->hour = 22;
$dt->minute = 32;
$dt->second = 5;

$dt->timestamp = 169957925;  // This will not change the timezone
// Same as:
$dt->setTimestamp(169957925);
$dt->timestamp(169957925);

// Set the timezone via DateTimeZone instance or string
$dt->tz = new DateTimeZone('Europe/London');
$dt->tz = 'Europe/London';

// The ->timezone is also available for backward compatibility but
// it will be overridden by native php DateTime class as soon as
// the object is dump (passed foreach, serialize, var_export, clone, etc.)
// making the Carbon setter inefficient, if it happen, you can cleanup
// those overridden properties by calling ->cleanupDumpProperties() on
// the instance, but we rather recommend to simply use ->tz instead
// of ->timezone everywhere.

// verbose way:
$dt->setYear(2001);
echo $dt->year;      // 2001
echo "\n";

// set/get method:
$dt->year(2002);
echo $dt->year();    // 0000-05-22 03:32:05
echo "\n";

// dynamic way:
$dt->set('year', 2003);
echo $dt->get('year'); // 2003
echo "\n";

// these methods exist for every units even for calculated properties such as:
echo $dt->dayOfYear(35)->format('Y-m-d'); // 2003-02-04

$en = CarbonImmutable::now()->locale('en_US');
$ar = CarbonImmutable::now()->locale('ar');

var_dump($en->firstWeekDay);                           // int(0)
var_dump($en->lastWeekDay);                            // int(6)
var_dump($en->startOfWeek()->format('Y-m-d H:i'));     // string(16) "2024-03-24 00:00"
var_dump($en->endOfWeek()->format('Y-m-d H:i'));       // string(16) "2024-03-30 23:59"

echo "-----------\n";

// We still can force to use an other day as start/end of week
$start = $en->startOfWeek(Carbon::TUESDAY);
$end = $en->endOfWeek(Carbon::MONDAY);
var_dump($start->format('Y-m-d H:i'));                 // string(16) "2024-03-26 00:00"
var_dump($end->format('Y-m-d H:i'));                   // string(16) "2024-04-01 23:59"

echo "-----------\n";

var_dump($ar->firstWeekDay);                           // int(6)
var_dump($ar->lastWeekDay);                            // int(5)
var_dump($ar->startOfWeek()->format('Y-m-d H:i'));     // string(16) "2024-03-30 00:00"
var_dump($ar->endOfWeek()->format('Y-m-d H:i'));       // string(16) "2024-04-05 23:59"

$en = CarbonImmutable::parse('2015-02-05'); // use en_US as default locale

echo "-----------\n";

var_dump($en->weeksInYear());                          // int(52)
var_dump($en->isoWeeksInYear());                       // int(53)

$en = CarbonImmutable::parse('2017-02-05');

echo "-----------\n";

var_dump($en->week());                                 // int(6)
var_dump($en->isoWeek());                              // int(5)
var_dump($en->week(1)->format('Y-m-d H:i'));           // string(16) "2017-01-01 00:00"
var_dump($en->isoWeek(1)->format('Y-m-d H:i'));        // string(16) "2017-01-08 00:00"

// weekday/isoWeekday are meant to be used with days constants
var_dump($en->weekday());                              // int(0)
var_dump($en->isoWeekday());                           // int(7)
var_dump($en->weekday(CarbonInterface::WEDNESDAY)
    ->format('Y-m-d H:i'));                                                                               // string(16) "2017-02-01 00:00"
var_dump($en->isoWeekday(CarbonInterface::WEDNESDAY)
    ->format('Y-m-d H:i'));                                                                                  // string(16) "2017-02-01 00:00"

// getDaysFromStartOfWeek/setDaysFromStartOfWeek return and take a number of days
// taking the current locale into account
$date = CarbonImmutable::parse('2022-12-05')->locale('en_US');

var_dump($date->getDaysFromStartOfWeek());                     // int(1)

$date = CarbonImmutable::parse('2022-12-05')->locale('de_AT');

var_dump($date->getDaysFromStartOfWeek());                     // int(0)
var_dump($date->setDaysFromStartOfWeek(3)->format('Y-m-d'));   // string(10) "2022-12-08"

// Or specify explicitly the first day of week
var_dump($date->setDaysFromStartOfWeek(3, CarbonInterface::SUNDAY)->format('Y-m-d')); // string(10) "2022-12-07"

$en = CarbonImmutable::parse('2017-01-01');

echo "-----------\n";

var_dump($en->weekYear());                             // int(2017)
var_dump($en->isoWeekYear());                          // int(2016)
var_dump($en->weekYear(2016)->format('Y-m-d H:i'));    // string(16) "2016-01-03 00:00"
var_dump($en->isoWeekYear(2016)->format('Y-m-d H:i')); // string(16) "2017-01-01 00:00"
var_dump($en->weekYear(2015)->format('Y-m-d H:i'));    // string(16) "2015-01-04 00:00"
var_dump($en->isoWeekYear(2015)->format('Y-m-d H:i')); // string(16) "2015-12-27 00:00"

// Note you still can force first day of week and year to use:
$en = CarbonImmutable::parse('2017-01-01');

echo "-----------\n";

var_dump($en->weeksInYear(null, 6, 12));               // int(52)
var_dump($en->isoWeeksInYear(null, 6, 12));            // int(52)
var_dump($en->week(null, 6, 12));                      // int(52)
var_dump($en->isoWeek(null, 6, 12));                   // int(52)
var_dump($en->weekYear(null, 6, 12));                  // int(2016)
var_dump($en->isoWeekYear(null, 6, 12));               // int(2016)
var_dump($en->weekYear(2016, 6, 12)->format('Y-m-d H:i')); // string(16) "2017-01-01 00:00"
var_dump($en->isoWeekYear(2016, 6, 12)->format('Y-m-d H:i')); // string(16) "2017-01-01 00:00"
// Then you can see using a method or its ISO variant return identical results


$dt = Carbon::now();

$dt->year(1975)->month(5)->day(21)->hour(22)->minute(32)->second(5)->toDateTimeString();
$dt->setDate(1975, 5, 21)->setTime(22, 32, 5)->toDateTimeString();
$dt->setDate(1975, 5, 21)->setTimeFromTimeString('22:32:05')->toDateTimeString();
$dt->setDateTime(1975, 5, 21, 22, 32, 5)->toDateTimeString();

// All allow microsecond as optional argument
$dt->year(1975)->month(5)->day(21)->hour(22)->minute(32)->second(5)->microsecond(123456)->toDateTimeString();
$dt->setDate(1975, 5, 21)->setTime(22, 32, 5, 123456)->toDateTimeString();
$dt->setDate(1975, 5, 21)->setTimeFromTimeString('22:32:05.123456')->toDateTimeString();
$dt->setDateTime(1975, 5, 21, 22, 32, 5, 123456)->toDateTimeString();

$dt->timestamp(169957925); // Note: timestamps are UTC but do not change the date timezone

$dt->timezone('Europe/London')->tz('America/Toronto')->setTimezone('America/Vancouver');

$source1 = new Carbon('2010-05-16 22:40:10.1');

$dt = new Carbon('2001-01-01 01:01:01.2');
$dt->setTimeFrom($source1);

echo $dt; // 2001-01-01 22:40:10

$source2 = new DateTime('2013-09-01 09:22:56.2');

$dt->setDateFrom($source2);

echo $dt; // 2013-09-01 22:40:10

$dt->setDateTimeFrom($source2); // set date and time including microseconds
// bot not settings as locale, timezone, options.

var_dump(isset(Carbon::now()->iDoNotExist));       // bool(false)
var_dump(isset(Carbon::now()->hour));              // bool(true)
var_dump(empty(Carbon::now()->iDoNotExist));       // bool(true)
var_dump(empty(Carbon::now()->year));              // bool(false)

$dt = Carbon::create(1975, 12, 25, 14, 15, 16);

var_dump($dt->toDateTimeString() == $dt);          // bool(true) => uses __toString()
echo $dt->toDateString();                          // 1975-12-25
echo $dt->toFormattedDateString();                 // Dec 25, 1975
echo $dt->toFormattedDayDateString();              // Thu, Dec 25, 1975
echo $dt->toTimeString();                          // 14:15:16
echo $dt->toDateTimeString();                      // 1975-12-25 14:15:16
echo $dt->toDayDateTimeString();                   // Thu, Dec 25, 1975 2:15 PM

// ... of course format() is still available
echo $dt->format('l jS \\of F Y h:i:s A');         // Thursday 25th of December 1975 02:15:16 PM

// The reverse hasFormat method allows you to test if a string looks like a given format
var_dump(Carbon::hasFormat('Thursday 25th December 1975 02:15:16 PM', 'l jS F Y h:i:s A')); // bool(true)

echo $dt;                                          // 1975-12-25 14:15:16
echo "\n";
$dt->settings([
    'toStringFormat' => 'jS \o\f F, Y g:i:s a',
]);
echo $dt;                                          // 25th of December, 1975 2:15:16 pm

// As any setting, you can get the current value for a given date using:
var_dump($dt->getSettings());

$dt = Carbon::create(1975, 12, 25, 14, 15, 16);
Carbon::setToStringFormat('jS \o\f F, Y g:i:s a');
echo $dt;                                          // 25th of December, 1975 2:15:16 pm
echo "\n";
Carbon::resetToStringFormat();
echo $dt;                                          // 1975-12-25 14:15:16

$dt = Carbon::createFromFormat('Y-m-d H:i:s.u', '2019-02-01 03:45:27.612584');

// $dt->toAtomString() is the same as $dt->format(DateTime::ATOM);
echo $dt->toAtomString();           // 2019-02-01T03:45:27+00:00
echo $dt->toCookieString();         // Friday, 01-Feb-2019 03:45:27 UTC

echo $dt->toIso8601String();        // 2019-02-01T03:45:27+00:00
// Be aware we chose to use the full-extended format of the ISO 8601 norm
// Natively, DateTime::ISO8601 format is not compatible with ISO-8601 as it
// is explained here in the PHP documentation:
// https://php.net/manual/class.datetime.php#datetime.constants.iso8601
// We consider it as a PHP mistake and chose not to provide method for this
// format, but you still can use it this way:
echo $dt->format(DateTime::ISO8601); // 2019-02-01T03:45:27+0000

echo $dt->toISOString();            // 2019-02-01T03:45:27.612584Z
echo $dt->toJSON();                 // 2019-02-01T03:45:27.612584Z

echo $dt->toIso8601ZuluString();    // 2019-02-01T03:45:27Z
echo $dt->toDateTimeLocalString();  // 2019-02-01T03:45:27
echo $dt->toRfc822String();         // Fri, 01 Feb 19 03:45:27 +0000
echo $dt->toRfc850String();         // Friday, 01-Feb-19 03:45:27 UTC
echo $dt->toRfc1036String();        // Fri, 01 Feb 19 03:45:27 +0000
echo $dt->toRfc1123String();        // Fri, 01 Feb 2019 03:45:27 +0000
echo $dt->toRfc2822String();        // Fri, 01 Feb 2019 03:45:27 +0000
echo $dt->toRfc3339String();        // 2019-02-01T03:45:27+00:00
echo $dt->toRfc7231String();        // Fri, 01 Feb 2019 03:45:27 GMT
echo $dt->toRssString();            // Fri, 01 Feb 2019 03:45:27 +0000
echo $dt->toW3cString();            // 2019-02-01T03:45:27+00:00


$dt = Carbon::createFromFormat('Y-m-d H:i:s.u', '2019-02-01 03:45:27.612584');
var_dump($dt->toArray());
var_dump($dt->toObject());
var_dump($dt->toDate());
var_dump($dt->toDateTimeImmutable());
class MySubClass extends Carbon {}
$copy = $dt->cast(MySubClass::class);
// Since 2.23.0, cast() can also take as argument any class that extend DateTime or DateTimeImmutable

echo get_class($copy).': '.$copy; // Same as MySubClass::instance($dt)


$dt = Carbon::createFromFormat('Y-m-d H:i:s.u', '2019-02-01 03:45:27.612584', 'Europe/Paris');
var_dump($dt->carbonize('2019-03-21'));
var_dump($dt->carbonize(CarbonPeriod::create('2019-12-10', '2020-01-05')));
var_dump($dt->carbonize(CarbonInterval::days(3)));

echo Carbon::now()->tzName;                        // UTC
$first = Carbon::create(2012, 9, 5, 23, 26, 11);
$second = Carbon::create(2012, 9, 5, 20, 26, 11, 'America/Vancouver');

echo $first->toDateTimeString();                   // 2012-09-05 23:26:11
echo $first->tzName;                               // UTC
echo $second->toDateTimeString();                  // 2012-09-05 20:26:11
echo $second->tzName;                              // America/Vancouver

var_dump($first->equalTo($second));                // bool(false)
// equalTo is also available on CarbonInterval and CarbonPeriod
var_dump($first->notEqualTo($second));             // bool(true)
// notEqualTo is also available on CarbonInterval and CarbonPeriod
var_dump($first->greaterThan($second));            // bool(false)
// greaterThan is also available on CarbonInterval
var_dump($first->greaterThanOrEqualTo($second));   // bool(false)
// greaterThanOrEqualTo is also available on CarbonInterval
var_dump($first->lessThan($second));               // bool(true)
// lessThan is also available on CarbonInterval
var_dump($first->lessThanOrEqualTo($second));      // bool(true)
// lessThanOrEqualTo is also available on CarbonInterval

$first->setDateTime(2012, 1, 1, 0, 0, 0);
$second->setDateTime(2012, 1, 1, 0, 0, 0);         // Remember tz is 'America/Vancouver'

var_dump($first->equalTo($second));                // bool(false)
var_dump($first->notEqualTo($second));             // bool(true)
var_dump($first->greaterThan($second));            // bool(false)
var_dump($first->greaterThanOrEqualTo($second));   // bool(false)
var_dump($first->lessThan($second));               // bool(true)
var_dump($first->lessThanOrEqualTo($second));      // bool(true)

// All have short hand aliases and PHP equivalent code:

var_dump($first->eq($second));                     // bool(false)
var_dump($first->equalTo($second));                // bool(false)
var_dump($first == $second);                       // bool(false)

var_dump($first->ne($second));                     // bool(true)
var_dump($first->notEqualTo($second));             // bool(true)
var_dump($first != $second);                       // bool(true)

var_dump($first->gt($second));                     // bool(false)
var_dump($first->greaterThan($second));            // bool(false)
var_dump($first->isAfter($second));                // bool(false)
var_dump($first > $second);                        // bool(false)

var_dump($first->gte($second));                    // bool(false)
var_dump($first->greaterThanOrEqualTo($second));   // bool(false)
var_dump($first >= $second);                       // bool(false)

var_dump($first->lt($second));                     // bool(true)
var_dump($first->lessThan($second));               // bool(true)
var_dump($first->isBefore($second));               // bool(true)
var_dump($first < $second);                        // bool(true)

var_dump($first->lte($second));                    // bool(true)
var_dump($first->lessThanOrEqualTo($second));      // bool(true)
var_dump($first <= $second);                       // bool(true)

$first = Carbon::create(2012, 9, 5, 1);
$second = Carbon::create(2012, 9, 5, 5);
var_dump(Carbon::create(2012, 9, 5, 3)->between($first, $second));          // bool(true)
var_dump(Carbon::create(2012, 9, 5, 5)->between($first, $second));          // bool(true)
var_dump(Carbon::create(2012, 9, 5, 5)->between($first, $second, false));   // bool(false)
var_dump(Carbon::create(2012, 9, 5, 5)->isBetween($first, $second, false)); // bool(false)
// Rather than passing false as a third argument, you can use betweenIncluded and betweenExcluded
var_dump(Carbon::create(2012, 9, 5, 5)->betweenIncluded($first, $second));  // bool(true)
var_dump(Carbon::create(2012, 9, 5, 5)->betweenExcluded($first, $second));  // bool(false)
// All those methods are also available on CarbonInterval

$dt1 = Carbon::createMidnightDate(2012, 1, 1);
$dt2 = Carbon::createMidnightDate(2014, 1, 30);
echo $dt1->min($dt2);                              // 2012-01-01 00:00:00
echo $dt1->minimum($dt2);                          // 2012-01-01 00:00:00
// Also works with string
echo $dt1->minimum('2014-01-30');                  // 2012-01-01 00:00:00

$dt1 = Carbon::createMidnightDate(2012, 1, 1);
$dt2 = Carbon::createMidnightDate(2014, 1, 30);
echo $dt1->max($dt2);                              // 2014-01-30 00:00:00
echo $dt1->maximum($dt2);                          // 2014-01-30 00:00:00

// now is the default param
$dt1 = Carbon::createMidnightDate(2000, 1, 1);
echo $dt1->max();                                  // 2024-03-30 22:42:52
echo $dt1->maximum();                              // 2024-03-30 22:42:52

// Remember min and max PHP native function work fine with dates too:
echo max(Carbon::create('2002-03-15'), Carbon::create('2003-01-07'), Carbon::create('2002-08-25')); // 2003-01-07 00:00:00
echo min(Carbon::create('2002-03-15'), Carbon::create('2003-01-07'), Carbon::create('2002-08-25')); // 2002-03-15 00:00:00
// This way you can pass as many dates as you want and get no ambiguities about parameters order

$dt1 = Carbon::createMidnightDate(2010, 4, 1);
$dt2 = Carbon::createMidnightDate(2010, 3, 28);
$dt3 = Carbon::createMidnightDate(2010, 4, 16);

// returns the closest of two date (no matter before or after)
echo $dt1->closest($dt2, $dt3);                    // 2010-03-28 00:00:00
echo $dt2->closest($dt1, $dt3);                    // 2010-04-01 00:00:00
echo $dt3->closest($dt2, $dt1);                    // 2010-04-01 00:00:00

// returns the farthest of two date (no matter before or after)
echo $dt1->farthest($dt2, $dt3);                   // 2010-04-16 00:00:00
echo $dt2->farthest($dt1, $dt3);                   // 2010-04-16 00:00:00
echo $dt3->farthest($dt2, $dt1);                   // 2010-03-28 00:00:00

$dt = Carbon::now();
$dt2 = Carbon::createFromDate(1987, 4, 23);

$dt->isSameAs('w', $dt2); // w is the date of the week, so this will return true if $dt and $dt2
                          // the same day of week (both monday or both sunday, etc.)
                          // you can use any format and combine as much as you want.
$dt->isFuture();
$dt->isPast();

$dt->isSameYear($dt2);
$dt->isCurrentYear();
$dt->isNextYear();
$dt->isLastYear();
$dt->isLongIsoYear(); // see https://en.wikipedia.org/wiki/ISO_8601#Week_dates
Carbon::create(2015)->isLongYear(); // isLongIsoYear() check a given date,
    // while isLongYear() will ignore month/day and just check a given year number
$dt->isLeapYear();

$dt->isSameQuarter($dt2); // same quarter of the same year of the given date
$dt->isSameQuarter($dt2, false); // same quarter (3 months) no matter the year of the given date
$dt->isCurrentQuarter();
$dt->isNextQuarter(); // date is in the next quarter
$dt->isLastQuarter(); // in previous quarter

$dt->isSameMonth($dt2); // same month of the same year of the given date
$dt->isSameMonth($dt2, false); // same month no matter the year of the given date
$dt->isCurrentMonth();
$dt->isNextMonth();
$dt->isLastMonth();

$dt->isWeekday();
$dt->isWeekend();
$dt->isMonday();
$dt->isTuesday();
$dt->isWednesday();
$dt->isThursday();
$dt->isFriday();
$dt->isSaturday();
$dt->isSunday();
$dt->isDayOfWeek(Carbon::SATURDAY); // is a saturday
$dt->isLastOfMonth(); // is the last day of the month

$dt->is('Sunday');
$dt->is('June');
$dt->is('2019');
$dt->is('12:23');
$dt->is('2 June 2019');
$dt->is('06-02');

$dt->isSameDay($dt2); // Same day of same month of same year
$dt->isCurrentDay();
$dt->isYesterday();
$dt->isToday();
$dt->isTomorrow();
$dt->isNextWeek();
$dt->isLastWeek();

$dt->isSameHour($dt2);
$dt->isCurrentHour();
$dt->isSameMinute($dt2);
$dt->isCurrentMinute();
$dt->isSameSecond($dt2);
$dt->isCurrentSecond();

$dt->isStartOfDay(); // check if hour is 00:00:00
$dt->isMidnight(); // check if hour is 00:00:00 (isStartOfDay alias)
$dt->isEndOfDay(); // check if hour is 23:59:59
$dt->isMidday(); // check if hour is 12:00:00 (or other midday hour set with Carbon::setMidDayAt())
$born = Carbon::createFromDate(1987, 4, 23);
$noCake = Carbon::createFromDate(2014, 9, 26);
$yesCake = Carbon::createFromDate(2014, 4, 23);
$overTheHill = Carbon::now()->subYears(50);
var_dump($born->isBirthday($noCake));              // bool(false)
var_dump($born->isBirthday($yesCake));             // bool(true)
var_dump($overTheHill->isBirthday());              // bool(true) -> default compare it to today!

// isCurrentX, isSameX, isNextX and isLastX are available for each unit



$dt = Carbon::create(2012, 1, 31, 0);

echo $dt->toDateTimeString();            // 2012-01-31 00:00:00

echo $dt->addCenturies(5);               // 2512-01-31 00:00:00
echo $dt->addCentury();                  // 2612-01-31 00:00:00
echo $dt->subCentury();                  // 2512-01-31 00:00:00
echo $dt->subCenturies(5);               // 2012-01-31 00:00:00

echo $dt->addYears(5);                   // 2017-01-31 00:00:00
echo $dt->addYear();                     // 2018-01-31 00:00:00
echo $dt->subYear();                     // 2017-01-31 00:00:00
echo $dt->subYears(5);                   // 2012-01-31 00:00:00

echo $dt->addQuarters(2);                // 2012-07-31 00:00:00
echo $dt->addQuarter();                  // 2012-10-31 00:00:00
echo $dt->subQuarter();                  // 2012-07-31 00:00:00
echo $dt->subQuarters(2);                // 2012-01-31 00:00:00

echo $dt->addMonths(60);                 // 2017-01-31 00:00:00
echo $dt->addMonth();                    // 2017-03-03 00:00:00 equivalent of $dt->month($dt->month + 1); so it wraps
echo $dt->subMonth();                    // 2017-02-03 00:00:00
echo $dt->subMonths(60);                 // 2012-02-03 00:00:00

echo $dt->addDays(29);                   // 2012-03-03 00:00:00
echo $dt->addDay();                      // 2012-03-04 00:00:00
echo $dt->subDay();                      // 2012-03-03 00:00:00
echo $dt->subDays(29);                   // 2012-02-03 00:00:00

echo $dt->addWeekdays(4);                // 2012-02-09 00:00:00
echo $dt->addWeekday();                  // 2012-02-10 00:00:00
echo $dt->subWeekday();                  // 2012-02-09 00:00:00
echo $dt->subWeekdays(4);                // 2012-02-03 00:00:00

echo $dt->addWeeks(3);                   // 2012-02-24 00:00:00
echo $dt->addWeek();                     // 2012-03-02 00:00:00
echo $dt->subWeek();                     // 2012-02-24 00:00:00
echo $dt->subWeeks(3);                   // 2012-02-03 00:00:00

echo $dt->addHours(24);                  // 2012-02-04 00:00:00
echo $dt->addHour();                     // 2012-02-04 01:00:00
echo $dt->subHour();                     // 2012-02-04 00:00:00
echo $dt->subHours(24);                  // 2012-02-03 00:00:00

echo $dt->addMinutes(61);                // 2012-02-03 01:01:00
echo $dt->addMinute();                   // 2012-02-03 01:02:00
echo $dt->subMinute();                   // 2012-02-03 01:01:00
echo $dt->subMinutes(61);                // 2012-02-03 00:00:00

echo $dt->addSeconds(61);                // 2012-02-03 00:01:01
echo $dt->addSecond();                   // 2012-02-03 00:01:02
echo $dt->subSecond();                   // 2012-02-03 00:01:01
echo $dt->subSeconds(61);                // 2012-02-03 00:00:00

echo $dt->addMilliseconds(61);           // 2012-02-03 00:00:00
echo $dt->addMillisecond();              // 2012-02-03 00:00:00
echo $dt->subMillisecond();              // 2012-02-03 00:00:00
echo $dt->subMillisecond(61);            // 2012-02-03 00:00:00

echo $dt->addMicroseconds(61);           // 2012-02-03 00:00:00
echo $dt->addMicrosecond();              // 2012-02-03 00:00:00
echo $dt->subMicrosecond();              // 2012-02-03 00:00:00
echo $dt->subMicroseconds(61);           // 2012-02-03 00:00:00

// and so on for any unit: millenium, century, decade, year, quarter, month, week, day, weekday,
// hour, minute, second, microsecond.

// Generic methods add/sub (or subtract alias) can take many different arguments:
echo $dt->add(61, 'seconds');                      // 2012-02-03 00:01:01
echo $dt->sub('1 day');                            // 2012-02-02 00:01:01
echo $dt->add(CarbonInterval::months(2));          // 2012-04-02 00:01:01
echo $dt->subtract(new DateInterval('PT1H'));      // 2012-04-01 23:01:01


$dt = CarbonImmutable::create(2017, 1, 31, 0);

echo $dt->addMonth();                    // 2017-03-03 00:00:00
echo "\n";
echo $dt->subMonths(2);                  // 2016-12-01 00:00:00


$dt = CarbonImmutable::create(2017, 1, 31, 0);
$dt->settings([
    'monthOverflow' => false,
]);

echo $dt->addMonth();                    // 2017-02-28 00:00:00
echo "\n";
echo $dt->subMonths(2);                  // 2016-11-30 00:00:00


$dt = Carbon::createMidnightDate(2017, 1, 31)->settings([
    'monthOverflow' => false,
]);

echo $dt->copy()->addMonthWithOverflow();          // 2017-03-03 00:00:00
// plural addMonthsWithOverflow() method is also available
echo $dt->copy()->subMonthsWithOverflow(2);        // 2016-12-01 00:00:00
// singular subMonthWithOverflow() method is also available
echo $dt->copy()->addMonthNoOverflow();            // 2017-02-28 00:00:00
// plural addMonthsNoOverflow() method is also available
echo $dt->copy()->subMonthsNoOverflow(2);          // 2016-11-30 00:00:00
// singular subMonthNoOverflow() method is also available

echo $dt->copy()->addMonth();                      // 2017-02-28 00:00:00
echo $dt->copy()->subMonths(2);                    // 2016-11-30 00:00:00

$dt = Carbon::createMidnightDate(2017, 1, 31)->settings([
    'monthOverflow' => true,
]);

echo $dt->copy()->addMonthWithOverflow();          // 2017-03-03 00:00:00
echo $dt->copy()->subMonthsWithOverflow(2);        // 2016-12-01 00:00:00
echo $dt->copy()->addMonthNoOverflow();            // 2017-02-28 00:00:00
echo $dt->copy()->subMonthsNoOverflow(2);          // 2016-11-30 00:00:00

echo $dt->copy()->addMonth();                      // 2017-03-03 00:00:00
echo $dt->copy()->subMonths(2);                    // 2016-12-01 00:00:00


$dt = CarbonImmutable::create(2018, 8, 30, 12, 00, 00);

// Add hours without overflowing day
echo $dt->addUnitNoOverflow('hour', 7, 'day');     // 2018-08-30 19:00:00
echo "\n";
echo $dt->addUnitNoOverflow('hour', 14, 'day');    // 2018-08-30 23:59:59
echo "\n";
echo $dt->addUnitNoOverflow('hour', 48, 'day');    // 2018-08-30 23:59:59

echo "\n-------\n";

// Substract hours without overflowing day
echo $dt->subUnitNoOverflow('hour', 7, 'day');     // 2018-08-30 05:00:00
echo "\n";
echo $dt->subUnitNoOverflow('hour', 14, 'day');    // 2018-08-30 00:00:00
echo "\n";
echo $dt->subUnitNoOverflow('hour', 48, 'day');    // 2018-08-30 00:00:00

echo "\n-------\n";

// Set hours without overflowing day
echo $dt->setUnitNoOverflow('hour', -7, 'day');    // 2018-08-30 00:00:00
echo "\n";
echo $dt->setUnitNoOverflow('hour', 14, 'day');    // 2018-08-30 14:00:00
echo "\n";
echo $dt->setUnitNoOverflow('hour', 25, 'day');    // 2018-08-30 23:59:59

echo "\n-------\n";

// Adding hours without overflowing month
echo $dt->addUnitNoOverflow('hour', 7, 'month');   // 2018-08-30 19:00:00
echo "\n";
echo $dt->addUnitNoOverflow('hour', 14, 'month');  // 2018-08-31 02:00:00
echo "\n";
echo $dt->addUnitNoOverflow('hour', 48, 'month');  // 2018-08-31 23:59:59


$units = [];
foreach (['millennium', 'century', 'decade', 'year', 'quarter', 'month', 'week',
 'weekday', 'day', 'hour', 'minute', 'second', 'millisecond', 'microsecond'] as $unit) {
    $units[$unit] = Carbon::isModifiableUnit($unit);
}

echo json_encode($units, JSON_PRETTY_PRINT);


echo Carbon::now('America/Vancouver')->diffInSeconds(Carbon::now('Europe/London')); // 1.0E-5

$dtOttawa = Carbon::createMidnightDate(2000, 1, 1, 'America/Toronto');
$dtVancouver = Carbon::createMidnightDate(2000, 1, 1, 'America/Vancouver');
echo $dtOttawa->diffInHours($dtVancouver);                             // 3
echo $dtVancouver->diffInHours($dtOttawa);                             // -3

echo $dtOttawa->diffInHours($dtVancouver, false);                      // 3
echo $dtVancouver->diffInHours($dtOttawa, false);                      // -3

$dt = Carbon::createMidnightDate(2012, 1, 31);
echo $dt->diffInDays($dt->copy()->addMonth());                         // 31
echo $dt->diffInDays($dt->copy()->subMonth(), false);                  // -31

$dt = Carbon::createMidnightDate(2012, 4, 30);
echo $dt->diffInDays($dt->copy()->addMonth());                         // 30
echo $dt->diffInDays($dt->copy()->addWeek());                          // 7

$dt = Carbon::createMidnightDate(2012, 1, 1);
echo $dt->diffInMinutes($dt->copy()->addSeconds(59));                  // 0.98333333333333
echo $dt->diffInMinutes($dt->copy()->addSeconds(60));                  // 1
echo $dt->diffInMinutes($dt->copy()->addSeconds(119));                 // 1.9833333333333
echo $dt->diffInMinutes($dt->copy()->addSeconds(120));                 // 2

echo $dt->addSeconds(120)->secondsSinceMidnight();                     // 120

$interval = $dt->diffAsCarbonInterval($dt->copy()->subYears(3), false);
// diffAsCarbonInterval use same arguments as diff($other, $absolute)
// (native method from \DateTime)
// except $absolute is true by default for diffAsCarbonInterval and false for diff
// $absolute parameter allow to get signed value if false, or always positive if true

echo ($interval->invert ? 'minus ' : 'plus ') . $interval->years;      // minus 3
echo Carbon::parse('06:01:23.252987')->floatDiffInSeconds('06:02:34.321450');    // 71.068463
echo Carbon::parse('06:01:23')->floatDiffInMinutes('06:02:34');                  // 1.1833333333333
echo Carbon::parse('06:01:23')->floatDiffInHours('06:02:34');                    // 0.019722222222222
// Those methods are absolute by default but can return negative value
// setting the second argument to false when start date is greater than end date
echo Carbon::parse('12:01:23')->floatDiffInHours('06:02:34', false);             // -5.9802777777778
echo Carbon::parse('2000-01-01 12:00')->floatDiffInDays('2000-02-11 06:00');     // 40.75
echo Carbon::parse('2000-01-01')->floatDiffInWeeks('2000-02-11');                // 5.8571428571429
echo Carbon::parse('2000-01-15')->floatDiffInMonths('2000-02-24');               // 1.3103448275862
// floatDiffInMonths count as many full months as possible from the start date
// (for instance 31 days if the start is in January), then consider the number
// of days in the months for ending chunks to reach the end date.
// So the following result (ending with 24 march is different from previous one with 24 february):
echo Carbon::parse('2000-02-15 12:00')->floatDiffInMonths('2000-03-24 06:00');   // 1.2822580645161
// floatDiffInYears apply the same logic (and so different results with leap years)
echo Carbon::parse('2000-02-15 12:00')->floatDiffInYears('2010-03-24 06:00');    // 10.100684931507

$date = new DateTime('2014-03-30 00:00:00', new DateTimeZone('Europe/London')); // DST off
echo $date->modify('+25 hours')->format('H:i');                   // 01:00 (DST on, 24 hours only have been actually added)

$date = new Carbon('2014-03-30 00:00:00', 'Europe/London');       // DST off
echo $date->addRealHours(25)->format('H:i');                      // 02:00 (DST on)
echo $date->diffInRealHours('2014-03-30 00:00:00');               // -25
echo $date->diffInHours('2014-03-30 00:00:00');                   // -25
echo $date->diffInRealMinutes('2014-03-30 00:00:00');             // -1500
echo $date->diffInMinutes('2014-03-30 00:00:00');                 // -1500
echo $date->diffInRealSeconds('2014-03-30 00:00:00');             // -90000
echo $date->diffInSeconds('2014-03-30 00:00:00');                 // -90000
echo $date->diffInRealMilliseconds('2014-03-30 00:00:00');        // -90000000
echo $date->diffInMilliseconds('2014-03-30 00:00:00');            // -90000000
echo $date->diffInRealMicroseconds('2014-03-30 00:00:00');        // -90000000000
echo $date->diffInMicroseconds('2014-03-30 00:00:00');            // -90000000000
echo $date->subRealHours(25)->format('H:i');                      // 00:00 (DST off)

// with float diff:
$date = new Carbon('2019-10-27 00:00:00', 'Europe/Paris');
echo $date->floatDiffInRealHours('2019-10-28 12:30:00');          // 37.5
echo $date->floatDiffInHours('2019-10-28 12:30:00');              // 37.5
echo $date->floatDiffInRealMinutes('2019-10-28 12:00:30');        // 2220.5
echo $date->floatDiffInMinutes('2019-10-28 12:00:30');            // 2220.5
echo $date->floatDiffInRealSeconds('2019-10-28 12:00:00.5');      // 133200.5
echo $date->floatDiffInSeconds('2019-10-28 12:00:00.5');          // 133200.5
// above day unit, "real" will affect the decimal part based on hours and smaller units
echo $date->floatDiffInRealDays('2019-10-28 12:30:00');           // 1.5625
echo $date->floatDiffInDays('2019-10-28 12:30:00');               // 1.5208333333333
echo $date->floatDiffInRealWeeks('2019-10-28 12:30:00');          // 0.22321428571429
echo $date->floatDiffInWeeks('2019-10-28 12:30:00');              // 0.2172619047619
echo $date->floatDiffInRealMonths('2019-10-28 12:30:00');         // 0.050403225806452
echo $date->floatDiffInMonths('2019-10-28 12:30:00');             // 0.049059139784946
echo $date->floatDiffInRealYears('2019-10-28 12:30:00');          // 0.0042808219178082
echo $date->floatDiffInYears('2019-10-28 12:30:00');              // 0.0041666666666667


$dt = Carbon::create(2014, 1, 1);
$dt2 = Carbon::create(2014, 12, 31);
$daysForExtraCoding = $dt->diffInDaysFiltered(function(Carbon $date) {
   return $date->isWeekend();
}, $dt2);

echo $daysForExtraCoding;      // 104

$dt = Carbon::create(2014, 1, 1)->endOfDay();
$dt2 = $dt->copy()->startOfDay();
$littleHandRotations = $dt->diffFiltered(CarbonInterval::minute(), function(Carbon $date) {
   return $date->minute === 0;
}, $dt2, true); // true as last parameter returns absolute value

echo $littleHandRotations;     // 24

$date = Carbon::now()->addSeconds(3666);

echo $date->diffInSeconds();                       // -3665.999904
echo $date->diffInMinutes();                       // -61.09999695
echo $date->diffInHours();                         // -1.0183332602778
echo $date->diffInDays();                          // -0.042430551481481

$date = Carbon::create(2016, 1, 5, 22, 40, 32);

echo $date->secondsSinceMidnight();                // 81632
echo $date->secondsUntilEndOfDay();                // 4767.999999

$date1 = Carbon::createMidnightDate(2016, 1, 5);
$date2 = Carbon::createMidnightDate(2017, 3, 15);

echo $date1->diffInDays($date2);                   // 435
echo $date1->diffInWeekdays($date2);               // 311
echo $date1->diffInWeekendDays($date2);            // 124
echo $date1->diffInWeeks($date2);                  // 62.142857142857
echo $date1->diffInMonths($date2);                 // 14.322580645161
echo $date1->diffInQuarters($date2);               // 4.7741935483871
echo $date1->diffInYears($date2);                  // 1.1890410958904

echo implode(', ', Carbon::getDays());                       // Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday

$saturday = new Carbon('first saturday of 2019');
$sunday = new Carbon('first sunday of 2019');
$monday = new Carbon('first monday of 2019');

echo implode(', ', Carbon::getWeekendDays());                // 6, 0
var_dump($saturday->isWeekend());                            // bool(true)
var_dump($sunday->isWeekend());                              // bool(true)
var_dump($monday->isWeekend());                              // bool(false)

Carbon::setWeekendDays([
    Carbon::SUNDAY,
    Carbon::MONDAY,
]);

echo implode(', ', Carbon::getWeekendDays());                // 0, 1
var_dump($saturday->isWeekend());                            // bool(false)
var_dump($sunday->isWeekend());                              // bool(true)
var_dump($monday->isWeekend());                              // bool(true)

Carbon::setWeekendDays([
    Carbon::SATURDAY,
    Carbon::SUNDAY,
]);
// weekend days and start/end of week or not linked
// start/end of week are driven by the locale

var_dump(Carbon::getWeekStartsAt());                         // int(1)
var_dump(Carbon::getWeekEndsAt());                           // int(0)
var_dump(Carbon::getWeekStartsAt('ar_EG'));                  // int(6)
var_dump(Carbon::getWeekEndsAt('ar_EG'));                    // int(5)



// The most typical usage is for comments
// The instance is the date the comment was created and its being compared to default now()
echo Carbon::now()->subDays(5)->diffForHumans();               // 5 days ago

echo Carbon::now()->diffForHumans(Carbon::now()->subYear());   // 11 months after

$dt = Carbon::createFromDate(2011, 8, 1);

echo $dt->diffForHumans($dt->copy()->addMonth());                        // 1 month before
echo $dt->diffForHumans($dt->copy()->subMonth());                        // 1 month after

echo Carbon::now()->addSeconds(5)->diffForHumans();                      // 4 seconds from now

echo Carbon::now()->subDays(24)->diffForHumans();                        // 3 weeks ago
echo Carbon::now()->subDays(24)->longAbsoluteDiffForHumans();            // 3 weeks

echo Carbon::parse('2019-08-03')->diffForHumans('2019-08-13');           // 1 week before
echo Carbon::parse('2000-01-01 00:50:32')->diffForHumans('@946684800');  // 50 minutes after

echo Carbon::create(2018, 2, 26, 4, 29, 43)->longRelativeDiffForHumans(Carbon::create(2016, 6, 21, 0, 0, 0), 6); 
// 1 year 8 months 5 days 4 hours 29 minutes 43 seconds after

echo Carbon::now()->diffForHumans(['options' => 0]); // 0 seconds ago
echo "\n";
// default options:
echo Carbon::now()->diffForHumans(['options' => Carbon::NO_ZERO_DIFF]); // 1 second ago
echo "\n";
echo Carbon::now()->diffForHumans(['options' => Carbon::JUST_NOW]); // just now
echo "\n";
echo Carbon::now()->subDay()->diffForHumans(['options' => 0]); // 1 day ago
echo "\n";
echo Carbon::now()->subDay()->diffForHumans(['options' => Carbon::ONE_DAY_WORDS]); // yesterday
echo "\n";
echo Carbon::now()->subDays(2)->diffForHumans(['options' => 0]); // 2 days ago
echo "\n";
echo Carbon::now()->subDays(2)->diffForHumans(['options' => Carbon::TWO_DAY_WORDS]); // before yesterday
echo "\n";

// Options can be combined with pipes
$now = Carbon::now();

echo $now->diffForHumans(['options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS]); // just now
echo "\n";

// Reference date for differences is `now` but you can use any other date (string, DateTime or Carbon instance):
$yesterday = $now->copy()->subDay();
echo $now->diffForHumans($yesterday); // 1 day after
echo "\n";
// By default differences methods produce "ago"/"from now" syntax using default reference (now),
// and "after"/"before" with other references
// But you can customize the syntax:
echo $now->diffForHumans($yesterday, ['syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW]); // 1 day from now
echo "\n";
echo $now->diffForHumans($yesterday, ['syntax' => 0]); // 1 day after
echo "\n";
echo $yesterday->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE]); // 1 day
echo "\n";
// Combined with options:
echo $now->diffForHumans($yesterday, [
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
    'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
]); // tomorrow
echo "\n";

// Other parameters:
echo $now->copy()->subHours(5)->subMinutes(30)->subSeconds(10)->diffForHumans([
    'parts' => 2,
]); // 5 hours 30 minutes ago
echo "\n";
echo $now->copy()->subHours(5)->subMinutes(30)->subSeconds(10)->diffForHumans([
    'parts' => 3, // Use -1 or INF for no limit
]); // 5 hours 30 minutes 10 seconds ago
echo "\n";
echo $now->copy()->subHours(5)->subMinutes(30)->subSeconds(10)->diffForHumans([
    'parts' => 3,
    'join' => ', ', // join with commas
]); // 5 hours, 30 minutes, 10 seconds ago
echo "\n";
echo $now->copy()->subHours(5)->subMinutes(30)->subSeconds(10)->diffForHumans([
    'parts' => 3,
    'join' => true, // join with natural syntax as per current locale
]); // 5 hours, 30 minutes and 10 seconds ago
echo "\n";
echo $now->copy()->subHours(5)->subMinutes(30)->subSeconds(10)->locale('fr')->diffForHumans([
    'parts' => 3,
    'join' => true, // join with natural syntax as per current locale
]); // il y a 5 heures, 30 minutes et 10 secondes
echo "\n";
echo $now->copy()->subHours(5)->subMinutes(30)->subSeconds(10)->diffForHumans([
    'parts' => 3,
    'short' => true, // short syntax as per current locale
]); // 5h 30m 10s ago
// 'aUnit' option added in 2.13.0 allows you to prefer "a day", "an hour", etc. over "1 day", "1 hour"
// for singular values when it's available in the current locale
echo $now->copy()->subHour()->diffForHumans([
    'aUnit' => true,
]); // an hour ago

// Before 2.9.0, you need to pass parameters as ordered parameters:
// ->diffForHumans($other, $syntax, $short, $parts, $options)
// and 'join' was not supported



$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->startOfSecond()->format('s.u');          // 45.000000


$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->endOfSecond()->format('s.u');            // 45.999999

$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->startOf('second')->format('s.u');        // 45.000000

$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->endOf('second')->format('s.u');          // 45.999999
// ->startOf() and ->endOf() are dynamic equivalents to those methods

$dt = Carbon::create(2012, 1, 31, 15, 32, 45);
echo $dt->startOfMinute();                         // 2012-01-31 15:32:00

$dt = Carbon::create(2012, 1, 31, 15, 32, 45);
echo $dt->endOfMinute();                           // 2012-01-31 15:32:59

$dt = Carbon::create(2012, 1, 31, 15, 32, 45);
echo $dt->startOfHour();                           // 2012-01-31 15:00:00

$dt = Carbon::create(2012, 1, 31, 15, 32, 45);
echo $dt->endOfHour();                             // 2012-01-31 15:59:59

$dt = Carbon::create(2012, 1, 31, 15, 32, 45);
echo Carbon::getMidDayAt();                        // 12
echo $dt->midDay();                                // 2012-01-31 12:00:00
Carbon::setMidDayAt(13);
echo Carbon::getMidDayAt();                        // 13
echo $dt->midDay();                                // 2012-01-31 13:00:00
Carbon::setMidDayAt(12);

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfDay();                            // 2012-01-31 00:00:00

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->endOfDay();                              // 2012-01-31 23:59:59

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfMonth();                          // 2012-01-01 00:00:00

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->endOfMonth();                            // 2012-01-31 23:59:59

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfYear();                           // 2012-01-01 00:00:00

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->endOfYear();                             // 2012-12-31 23:59:59

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfDecade();                         // 2010-01-01 00:00:00

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->endOfDecade();                           // 2019-12-31 23:59:59

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfCentury();                        // 2001-01-01 00:00:00

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->endOfCentury();                          // 2100-12-31 23:59:59

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfWeek();                           // 2012-01-30 00:00:00
var_dump($dt->dayOfWeek == Carbon::MONDAY);        // bool(true) : ISO8601 week starts on Monday

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->endOfWeek();                             // 2012-02-05 23:59:59
var_dump($dt->dayOfWeek == Carbon::SUNDAY);        // bool(true) : ISO8601 week ends on Sunday

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->next(Carbon::WEDNESDAY);                 // 2012-02-01 00:00:00
var_dump($dt->dayOfWeek == Carbon::WEDNESDAY);     // bool(true)
echo $dt->next('Wednesday');                       // 2012-02-08 00:00:00
echo $dt->next('04:00');                           // 2012-02-08 04:00:00
echo $dt->next('12:00');                           // 2012-02-08 12:00:00
echo $dt->next('04:00');                           // 2012-02-09 04:00:00

$dt = Carbon::create(2012, 1, 1, 12, 0, 0);
echo $dt->next();                                  // 2012-01-08 00:00:00

$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->previous(Carbon::WEDNESDAY);             // 2012-01-25 00:00:00
var_dump($dt->dayOfWeek == Carbon::WEDNESDAY);     // bool(true)

$dt = Carbon::create(2012, 1, 1, 12, 0, 0);
echo $dt->previous();                              // 2011-12-25 00:00:00

$start = Carbon::create(2014, 1, 1, 0, 0, 0);
$end = Carbon::create(2014, 1, 30, 0, 0, 0);
echo $start->average($end);                        // 2014-01-15 12:00:00

echo Carbon::create(2014, 5, 30, 0, 0, 0)->firstOfMonth();                       // 2014-05-01 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->firstOfMonth(Carbon::MONDAY);         // 2014-05-05 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->lastOfMonth();                        // 2014-05-31 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->lastOfMonth(Carbon::TUESDAY);         // 2014-05-27 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->nthOfMonth(2, Carbon::SATURDAY);      // 2014-05-10 00:00:00

echo Carbon::create(2014, 5, 30, 0, 0, 0)->firstOfQuarter();                     // 2014-04-01 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->firstOfQuarter(Carbon::MONDAY);       // 2014-04-07 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->lastOfQuarter();                      // 2014-06-30 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->lastOfQuarter(Carbon::TUESDAY);       // 2014-06-24 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->nthOfQuarter(2, Carbon::SATURDAY);    // 2014-04-12 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->startOfQuarter();                     // 2014-04-01 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->endOfQuarter();                       // 2014-06-30 23:59:59

echo Carbon::create(2014, 5, 30, 0, 0, 0)->firstOfYear();                        // 2014-01-01 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->firstOfYear(Carbon::MONDAY);          // 2014-01-06 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->lastOfYear();                         // 2014-12-31 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->lastOfYear(Carbon::TUESDAY);          // 2014-12-30 00:00:00
echo Carbon::create(2014, 5, 30, 0, 0, 0)->nthOfYear(2, Carbon::SATURDAY);       // 2014-01-11 00:00:00

echo Carbon::create(2018, 2, 23, 0, 0, 0)->nextWeekday();                        // 2018-02-26 00:00:00
echo Carbon::create(2018, 2, 23, 0, 0, 0)->previousWeekday();                    // 2018-02-22 00:00:00
echo Carbon::create(2018, 2, 21, 0, 0, 0)->nextWeekendDay();                     // 2018-02-24 00:00:00
echo Carbon::create(2018, 2, 21, 0, 0, 0)->previousWeekendDay();                 // 2018-02-18 00:00:00

$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->roundMillisecond()->format('H:i:s.u');   // 15:32:45.654000

$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->roundSecond()->format('H:i:s.u');        // 15:32:46.000000

$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->floorSecond()->format('H:i:s.u');        // 15:32:45.000000

$dt = new Carbon('2012-01-31 15:32:15');
echo $dt->roundMinute()->format('H:i:s');          // 15:32:00

$dt = new Carbon('2012-01-31 15:32:15');
echo $dt->ceilMinute()->format('H:i:s');           // 15:33:00

// and so on up to millennia!

// precision rounding can be set, example: rounding to ten minutes
$dt = new Carbon('2012-01-31 15:32:15');
echo $dt->roundMinute(10)->format('H:i:s');        // 15:30:00

// and round, floor and ceil methods are shortcut for second rounding:
$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->round()->format('H:i:s.u');              // 15:32:46.000000
$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->floor()->format('H:i:s.u');              // 15:32:45.000000
$dt = new Carbon('2012-01-31 15:32:45.654321');
echo $dt->ceil()->format('H:i:s.u');               // 15:32:46.000000

// you can also pass the unit dynamically (and still precision as second argument):
$dt = new Carbon('2012-01-31');
echo $dt->roundUnit('month', 2)->format('Y-m-d');  // 2012-01-01
$dt = new Carbon('2012-01-31');
echo $dt->floorUnit('month')->format('Y-m-d');     // 2012-01-01
$dt = new Carbon('2012-01-31');
echo $dt->ceilUnit('month', 4)->format('Y-m-d');   // 2012-05-01



// These getters specifically return integers, ie intval()
var_dump(Carbon::SUNDAY);                          // int(0)
var_dump(Carbon::MONDAY);                          // int(1)
var_dump(Carbon::TUESDAY);                         // int(2)
var_dump(Carbon::WEDNESDAY);                       // int(3)
var_dump(Carbon::THURSDAY);                        // int(4)
var_dump(Carbon::FRIDAY);                          // int(5)
var_dump(Carbon::SATURDAY);                        // int(6)

var_dump(Carbon::YEARS_PER_CENTURY);               // int(100)
var_dump(Carbon::YEARS_PER_DECADE);                // int(10)
var_dump(Carbon::MONTHS_PER_YEAR);                 // int(12)
var_dump(Carbon::WEEKS_PER_YEAR);                  // int(52)
var_dump(Carbon::DAYS_PER_WEEK);                   // int(7)
var_dump(Carbon::HOURS_PER_DAY);                   // int(24)
var_dump(Carbon::MINUTES_PER_HOUR);                // int(60)
var_dump(Carbon::SECONDS_PER_MINUTE);              // int(60)

$dt = Carbon::createFromDate(2012, 10, 6);
if ($dt->dayOfWeek === Carbon::SATURDAY) {
    echo 'Place bets on Ottawa Senators Winning!';
}

$dt = Carbon::create(2012, 12, 25, 20, 30, 00, 'Europe/Moscow');

echo serialize($dt);                                              // O:13:"Carbon\Carbon":3:{s:4:"date";s:26:"2012-12-25 20:30:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Europe/Moscow";}
// same as:
echo $dt->serialize();                                            // O:13:"Carbon\Carbon":3:{s:4:"date";s:26:"2012-12-25 20:30:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Europe/Moscow";}

$dt = 'O:13:"Carbon\Carbon":3:{s:4:"date";s:26:"2012-12-25 20:30:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Europe/Moscow";}';

echo unserialize($dt)->format('Y-m-d\TH:i:s.uP T');               // 2012-12-25T20:30:00.000000+04:00 MSK
// same as:
echo Carbon::fromSerialized($dt)->format('Y-m-d\TH:i:s.uP T');    // 2012-12-25T20:30:00.000000+04:00 MSK



$dt = Carbon::create(2012, 12, 25, 20, 30, 00, 'Europe/Moscow');
echo json_encode($dt);
// "2012-12-25T16:30:00.000000Z"

$json = '{"date":"2012-12-25 20:30:00.000000","timezone_type":3,"timezone":"Europe\/Moscow"}';
$dt = Carbon::__set_state(json_decode($json, true));
echo $dt->format('Y-m-d\TH:i:s.uP T');
// 2012-12-25T20:30:00.000000+04:00 MSK

$dt = Carbon::create(2012, 12, 25, 20, 30, 00, 'Europe/Moscow')->settings([
    'toJsonFormat' => function ($date) {
        return $date->getTimestamp();
    },
]);
echo json_encode($dt); // 1356453000

$dt = Carbon::create(2012, 12, 25, 20, 30, 00, 'Europe/Moscow');
Carbon::serializeUsing(function ($date) {
    return $date->valueOf();
});
echo json_encode($dt); // 1356453000000

// Call serializeUsing with null to reset the serializer:
Carbon::serializeUsing(null);

Carbon::macro('diffFromYear', static function ($year, $absolute = false, $short = false, $parts = 1) {
    return self::this()->diffForHumans(Carbon::create($year, 1, 1, 0, 0, 0), $absolute, $short, $parts);
});

// Can be called on Carbon instances:
//    self::context() = current instance ($this) or null when called statically
//    self::this() = current instance ($this) or Carbon::now() when called statically
echo Carbon::parse('2020-01-12 12:00:00')->diffFromYear(2019);                 // 1 year after
echo "\n";
echo Carbon::parse('2020-01-12 12:00:00')->diffFromYear(2019, true);           // 1 year
echo "\n";
echo Carbon::parse('2020-01-12 12:00:00')->diffFromYear(2019, true, true);     // 1yr
echo "\n";
echo Carbon::parse('2020-01-12 12:00:00')->diffFromYear(2019, true, true, 5);  // 1yr 1w 4d 12h

// Can also be called statically, in this case self::this() = Carbon::now()
echo "\n";
echo Carbon::diffFromYear(2017);                                               // 7 years after



// Let assume you get user settings from the browser or preferences stored in a database
$userTimezone = 'Europe/Paris';
$userLanguage = 'fr_FR';

Carbon::macro('formatForUser', static function () use ($userTimezone, $userLanguage) {
    $date = self::this()->copy()->tz($userTimezone)->locale($userLanguage);

    return $date->calendar(); // or ->isoFormat($customFormat), ->diffForHumans(), etc.
});

// Then let assume you store all your dates/times in UTC (because you definitely should)
$dateString = '2010-01-23 10:00:00'; // Get this from your database or any input

// Then now you can easily display any date in a page/e-mail using those user settings and the chosen format
echo Carbon::parse($dateString, 'UTC')->formatForUser();   // 23/01/2010
echo "\n";
echo Carbon::tomorrow()->formatForUser();                  // Demain à 01:00
echo "\n";
echo Carbon::now()->subDays(3)->formatForUser();           // mercredi dernier à 23:42

class BeerDayCarbonMixin
{
    public function nextBeerDay()
    {
        return static function () {
            return self::this()->modify('next wednesday');
        };
    }

    public function previousBeerDay()
    {
        return static function () {
            return self::this()->modify('previous wednesday');
        };
    }
}

Carbon::mixin(new BeerDayCarbonMixin());

$date = Carbon::parse('First saturday of December 2018');

echo $date->previousBeerDay();                                                 // 2018-11-28 00:00:00
echo "\n";
echo $date->nextBeerDay();                                                     // 2018-12-05 00:00:00


trait BeerDayCarbonTrait
{
    public function nextBeerDay()
    {
        return $this->modify('next wednesday');
    }

    public function previousBeerDay()
    {
        return $this->modify('previous wednesday');
    }
}

Carbon::mixin(BeerDayCarbonTrait::class);

$date = Carbon::parse('First saturday of December 2018');

echo $date->previousBeerDay();                                                 // 2018-11-28 00:00:00
echo "\n";
echo $date->nextBeerDay();                                                     // 2018-12-05 00:00:00


var_dump(Carbon::hasMacro('previousBeerDay'));                                 // bool(true)
var_dump(Carbon::hasMacro('diffFromYear'));                                    // bool(true)
echo "\n";
var_dump(Carbon::hasMacro('dontKnowWhat'));                                    // bool(false)

// Let's say a school year starts 5 months before the start of the year, so the school year of 2018 actually begins in August 2017 and ends in July 2018,
// Then you can create get/set method this way:
Carbon::macro('setSchoolYear', static function ($schoolYear) {
    $date = self::this();
    $date->year = $schoolYear;

    if ($date->month > 7) {
        $date->year--;
    }
});
Carbon::macro('getSchoolYear', static function () {
    $date = self::this();
    $schoolYear = $date->year;

    if ($date->month > 7) {
        $schoolYear++;
    }

    return $schoolYear;
});
// This will make getSchoolYear/setSchoolYear as usual, but get/set prefix will also enable
// the getter and setter methods for the ->schoolYear property.

$date = Carbon::parse('2016-06-01');

var_dump($date->schoolYear);                   // int(2016)
$date->addMonths(3);
var_dump($date->schoolYear);                   // int(2017)
$date->schoolYear++;
var_dump($date->format('Y-m-d'));              // string(10) "2017-09-01"
$date->schoolYear = 2020;
var_dump($date->format('Y-m-d'));              // string(10) "2019-09-01"

Carbon::genericMacro(static function ($method) {
    // As an example we will convert firstMondayOfDecember into first Monday Of December to get strings that
    // DateTime can parse.
    $time = preg_replace('/[A-Z]/', ' $0', $method);

    try {
        return self::this()->modify($time);
    } catch (\Throwable $exception) {
        if (stripos($exception->getMessage(), 'Failed to parse') !== false) {
            // When throwing BadMethodCallException from inside a generic macro will go to next generic macro
            // if there are other registered.
            throw new \BadMethodCallException('Try next macro', 0, $exception);
        }

        // Other exceptions thrown will not be caught
        throw $exception;
    }
},);  1 // you can optionally pass a priority as a second argument, 0 by default, can be negative, higher priority ran first 
// Generic macro get the asked method name as first argument, and method arguments as others.
// They can return any value.
// They can be added via "genericMacros" setting and this setting has precedence over statically declared generic macros.

$date = Carbon::parse('2016-06-01');

echo $date->nextSunday();                  // 2016-06-05 00:00:00
echo "\n";
echo $date->lastMondayOfPreviousMonth();   // 2016-05-30 00:00:00
Carbon::resetMacros(); // resetMacros remove all macros and generic macro declared statically

CarbonInterval::macro('twice', static function () {
    return self::this()->times(2);
});
echo CarbonInterval::day()->twice()->forHumans(); // 2 days
$interval = CarbonInterval::hours(2)->addMinutes(15)->twice();
echo $interval->forHumans(['short' => true]); // 4h 30m

CarbonPeriod::macro('countWeekdays', static function () {
    return self::this()->filter('isWeekday')->count();
});
echo CarbonPeriod::create('2017-11-01', '2017-11-30')->countWeekdays();  // 22
echo CarbonPeriod::create('2017-12-01', '2017-12-31')->countWeekdays();  // 21

class CurrentDaysCarbonMixin
{
    //
     // Get the all dates of week
     //
     // @return array
     //
    public static function getCurrentWeekDays()
    {
        return static function () {
            $startOfWeek = self::this()->startOfWeek()->subDay();
            $weekDays = [];

            for ($i = 0; $i < static::DAYS_PER_WEEK; $i++) {
                $weekDays[] = $startOfWeek->addDay()->startOfDay()->copy();
            }

            return $weekDays;
        };
    }

    //
     // Get the all dates of month
     //
     // @return array
     //
    public static function getCurrentMonthDays()
    {
        return static function () {
            $date = self::this();
            $startOfMonth = $date->copy()->startOfMonth()->subDay();
            $endOfMonth = $date->copy()->endOfMonth()->format('d');
            $monthDays = [];

            for ($i = 0; $i < $endOfMonth; $i++)
            {
                $monthDays[] = $startOfMonth->addDay()->startOfDay()->copy();
            }

            return $monthDays;
        };
    }
}

Carbon::mixin(new CurrentDaysCarbonMixin());

function dumpDateList($dates) {
    echo substr(implode(', ', $dates), 0, 100).'...';
}

dumpDateList(Carbon::getCurrentWeekDays());                       // 2024-03-25 00:00:00, 2024-03-26 00:00:00, 2024-03-27 00:00:00, 2024-03-28 00:00:00, 2024-03-29 00:00...
dumpDateList(Carbon::getCurrentMonthDays());                      // 2024-03-01 00:00:00, 2024-03-02 00:00:00, 2024-03-03 00:00:00, 2024-03-04 00:00:00, 2024-03-05 00:00...
dumpDateList(Carbon::now()->subMonth()->getCurrentWeekDays());    // 2024-02-26 00:00:00, 2024-02-27 00:00:00, 2024-02-28 00:00:00, 2024-02-29 00:00:00, 2024-03-01 00:00...
dumpDateList(Carbon::now()->subMonth()->getCurrentMonthDays());   // 2024-03-01 00:00:00, 2024-03-02 00:00:00, 2024-03-03 00:00:00, 2024-03-04 00:00:00, 2024-03-05 00:00...




Carbon::macro('toAtomStringWithNoTimezone', static function () {
    return self::this()->format('Y-m-d\TH:i:s');
});
echo Carbon::parse('2021-06-16 20:08:34')->toAtomStringWithNoTimezone(); // 2021-06-16T20:08:34

Carbon::macro('easterDate', static function ($year) {
    return Carbon::createMidnightDate($year, 3, 21)->addDays(easter_days($year));
});
echo Carbon::easterDate(2015)->format('d/m'); // 05/04
echo Carbon::easterDate(2016)->format('d/m'); // 27/03
echo Carbon::easterDate(2017)->format('d/m'); // 16/04
echo Carbon::easterDate(2018)->format('d/m'); // 01/04
echo Carbon::easterDate(2019)->format('d/m'); // 21/04


Carbon::macro('datePeriod', static function ($startDate, $endDate) {
    return new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
});
foreach (Carbon::datePeriod(Carbon::createMidnightDate(2019, 3, 28), Carbon::createMidnightDate(2019, 4, 3)) as $date) {
    echo $date->format('Y-m-d') . "\n";
}


class UserTimezoneCarbonMixin
{
    public $userTimeZone;

    ///
     //Set user timezone, will be used before format function to apply current user timezone
     //
     // @param $timezone
     //
    public function setUserTimezone()
    {
        $mixin = $this;

        return static function ($timezone) use ($mixin) {
            $mixin->userTimeZone = $timezone;
        };
    }
    public function tzFormat()
    {
        $mixin = $this;

        return static function ($format) use ($mixin) {
            $date = self::this();

            if (!is_null($mixin->userTimeZone)) {
                $date->timezone($mixin->userTimeZone);
            }

            return $date->format($format);
        };
    }
}

Carbon::mixin(new UserTimezoneCarbonMixin());

Carbon::setUserTimezone('Europe/Berlin');
echo Carbon::createFromTime(12, 0, 0, 'UTC')->tzFormat('H:i'); // 13:00
echo "\n";
echo Carbon::createFromTime(15, 0, 0, 'UTC')->tzFormat('H:i'); // 16:00
echo "\n";
Carbon::setUserTimezone('America/Toronto');
echo Carbon::createFromTime(12, 0, 0, 'UTC')->tzFormat('H:i'); // 08:00
echo "\n";
echo Carbon::createFromTime(15, 0, 0, 'UTC')->tzFormat('H:i'); // 11:00
echo "\n";


class MyDateClass extends Carbon
{
    protected static $formatFunction = 'translatedFormat';

    protected static $createFromFormatFunction = 'createFromLocaleFormat';

    protected static $parseFunction = 'myCustomParse';

    public static function myCustomParse($string)
    {
        return static::rawCreateFromFormat('d m Y', $string);
    }
}

$date = MyDateClass::parse('20 12 2001')->locale('de');
echo $date->format('jS F y');            // 20. Dezember 01
echo "\n";

$date = MyDateClass::createFromFormat('j F Y', 'pt', '20 fevereiro 2001')->locale('pt');

echo $date->format('d/m/Y');             // 20/02/2001
echo "\n";

// Note than you can still access native methods using rawParse, rawFormat and rawCreateFromFormat:
$date = MyDateClass::rawCreateFromFormat('j F Y', '20 February 2001', 'UTC')->locale('pt');

echo $date->rawFormat('jS F y');         // 20th February 01
echo "\n";

$date = MyDateClass::rawParse('2001-02-01', 'UTC')->locale('pt');

echo $date->format('jS F y');            // 1º fevereiro 01
echo "\n";


Carbon::macro('goTo', function (string $city) {
    static $cities = null;

    if ($cities === null) {
        foreach (DateTimeZone::listIdentifiers() as $identifier) {
            $chunks = explode('/', $identifier);

            if (isset($chunks[1])) {
                $id = strtolower(end($chunks));
                $cities[$id] = $identifier;
            }
        }
    }

    $city = str_replace(' ', '_', strtolower($city));

    if (!isset($cities[$city])) {
        throw new InvalidArgumentException("$city not found.");
    }

    return $this->tz($cities[$city]);
});

echo Carbon::now()->goTo('Chicago')->tzName; // America/Chicago
echo "\n";
echo Carbon::now()->goTo('Buenos Aires')->tzName; // America/Argentina/Buenos_Aires


// Carbon Interval


echo CarbonInterval::createFromFormat('H:i:s', '10:20:00'); // 10 hours 20 minutes
echo "\n";
echo CarbonInterval::year();                           // 1 year
echo "\n";
echo CarbonInterval::months(3);                        // 3 months
echo "\n";
echo CarbonInterval::days(3)->addSeconds(32);          // 3 days 32 seconds
echo "\n";
echo CarbonInterval::weeks(3);                         // 3 weeks
echo "\n";
echo CarbonInterval::days(23);                         // 3 weeks 2 days
echo "\n";
// years, months, weeks, days, hours, minutes, seconds, microseconds
echo CarbonInterval::create(2, 0, 5, 1, 1, 2, 7, 123); // 2 years 5 weeks 1 day 1 hour 2 minutes 7 seconds
echo "\n";
echo CarbonInterval::createFromDateString('3 months'); // 3 months



// Allow decimal numbers
CarbonInterval::enableFloatSetters();
echo CarbonInterval::days(3.5);                        // 3 days 12 hours
echo "\n";
// Disallow decimal numbers
CarbonInterval::enableFloatSetters(false);
echo CarbonInterval::days(3.5);                        // 3 days

$interval = CarbonInterval::months(3);
echo $interval;                                        // 3 months
echo "\n";

$interval->subMonths(1);
echo $interval;                                        // 2 months
echo "\n";

$interval->addDays(15);
echo $interval;                                        // 2 months 2 weeks 1 day

$interval = CarbonInterval::months(3);
echo $interval;                          // 3 months
echo "\n";

$interval->minus(months: 1);
echo $interval;                          // 2 months
echo "\n";

$interval->plus(days: 15, hours: 20);
echo $interval;                          // 2 months 2 weeks 1 day 20 hours

$di = new \DateInterval('P1Y2M'); // <== instance from another API
$ci = CarbonInterval::instance($di);
echo get_class($ci);                                   // 'Carbon\CarbonInterval'
echo $ci;                                              // 1 year 2 months

// It creates a new copy of the object when given a CarbonInterval value
$ci2 = CarbonInterval::instance($ci);
var_dump($ci2 === $ci);                                // bool(false)

// but you can tell to return same object if already an instance of  CarbonInterval
$ci3 = CarbonInterval::instance($ci, skipCopy: true);
var_dump($ci3 === $ci);                                // bool(true)

// the same option is available on make()
$ci4 = CarbonInterval::make($ci, skipCopy: true);
var_dump($ci4 === $ci);                                // bool(true)

$ci = CarbonInterval::days(2);
$di = $ci->toDateInterval();
echo get_class($di);   // 'DateInterval'
echo $di->d;           // 2

// Your custom class can also extends CarbonInterval
class CustomDateInterval extends \DateInterval {}

$di = $ci->cast(\CustomDateInterval::class);
echo get_class($di);   // 'CustomDateInterval'
echo $di->d;           // 2

echo CarbonInterval::year()->years;                    // 1
echo CarbonInterval::year()->dayz;                     // 0
echo CarbonInterval::days(24)->dayz;                   // 24
echo CarbonInterval::days(24)->daysExcludeWeeks;       // 3
echo CarbonInterval::weeks(3)->days(14)->weeks;        // 2  <-- days setter overwrites the current value
echo CarbonInterval::weeks(3)->addDays(14)->weeks;     // 5
echo CarbonInterval::weeks(3)->weeks;                  // 3
echo CarbonInterval::minutes(3)->weeksAndDays(2, 5);   // 2 weeks 5 days 3 minutes

$ci = CarbonInterval::create('P1Y2M3D');
var_dump($ci->isEmpty()); // bool(false)
$ci = new CarbonInterval('PT0S');
var_dump($ci->isEmpty()); // bool(true)

CarbonInterval::fromString('2 minutes 15 seconds');
CarbonInterval::fromString('2m 15s'); // or abbreviated

$ci = new CarbonInterval(new DateInterval('P1Y2M3D'));
var_dump($ci->isEmpty()); // bool(false)

CarbonInterval::setLocale('fr');
echo CarbonInterval::create(2, 1)->forHumans();        // 2 ans 1 mois
echo CarbonInterval::hour()->addSeconds(3);            // 1 heure 3 secondes
CarbonInterval::setLocale('en');

$dateInterval = new DateInterval('P2D');
$carbonInterval = CarbonInterval::month();
echo CarbonInterval::make($dateInterval)->forHumans();       // 2 days
echo CarbonInterval::make($carbonInterval)->forHumans();     // 1 month
echo CarbonInterval::make(5, 'days')->forHumans();           // 5 days
echo CarbonInterval::make('PT3H')->forHumans();              // 3 hours
echo CarbonInterval::make('1h 15m')->forHumans();            // 1 hour 15 minutes
// forHumans has many options, since version 2.9.0, the recommended way is to pass them as an associative array:
echo CarbonInterval::make('1h 15m')->forHumans(['short' => true]); // 1h 15m

// You can create interval from a string in any language:
echo CarbonInterval::parseFromLocale('3 jours et 2 heures', 'fr'); // 3 days 2 hours
// 'fr' stands for French but can be replaced with any locale code.
// if you don't pass the locale parameter, Carbon::getLocale() (current global locale) is used.

$interval = CarbonInterval::make('1h 15m 45s');
echo $interval->forHumans(['join' => true]);                 // 1 hour, 15 minutes and 45 seconds
$esInterval = CarbonInterval::make('1h 15m 45s');
echo $esInterval->forHumans(['join' => true]);               // 1 hour, 15 minutes and 45 seconds
echo $interval->forHumans(['join' => true, 'parts' => 2]);   // 1 hour and 15 minutes
echo $interval->forHumans(['join' => ' - ']);                // 1 hour - 15 minutes - 45 seconds

// Available syntax modes:
// ago/from now (translated in the current locale)
echo $interval->forHumans(['syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW]);      // 1 hour 15 minutes 45 seconds ago
// before/after (translated in the current locale)
echo $interval->forHumans(['syntax' => CarbonInterface::DIFF_RELATIVE_TO_OTHER]);    // 1 hour 15 minutes 45 seconds before
// default for intervals (no prefix/suffix):
echo $interval->forHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE]);             // 1 hour 15 minutes 45 seconds

// Available options:
// transform empty intervals into "just now":
echo CarbonInterval::hours(0)->forHumans([
    'options' => CarbonInterface::JUST_NOW,
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
]);                                                                                  // just now
// transform empty intervals into "1 second":
echo CarbonInterval::hours(0)->forHumans([
    'options' => CarbonInterface::NO_ZERO_DIFF,
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
]);                                                                                  // 1 second ago
// transform "1 day ago"/"1 day from now" into "yesterday"/"tomorrow":
echo CarbonInterval::day()->forHumans([
    'options' => CarbonInterface::ONE_DAY_WORDS,
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
]);                                                                                  // 1 day ago
// transform "2 days ago"/"2 days from now" into "before yesterday"/"after tomorrow":
echo CarbonInterval::days(2)->forHumans([
    'options' => CarbonInterface::TWO_DAY_WORDS,
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
]);                                                                                  // 2 days ago
// options can be piped:
echo CarbonInterval::days(2)->forHumans([
    'options' => CarbonInterface::ONE_DAY_WORDS | CarbonInterface::TWO_DAY_WORDS,
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
]);                                                                                  // 2 days ago

// Before version 2.9.0, parameters could only be passed sequentially:
// $interval->forHumans($syntax, $short, $parts, $options)
// and join parameter was not available

$interval = CarbonInterval::make('7h 55m');
$interval->add(CarbonInterval::make('17h 35m'));
$interval->subtract(10, 'minutes');
// add(), sub() and subtract() can take DateInterval, CarbonInterval, interval as string or 2 arguments factor and unit
$interval->times(3);
echo $interval->forHumans();                                       // 72 hours 240 minutes
echo "\n";
$interval->shares(7);
echo $interval->forHumans();                                       // 10 hours 34 minutes
echo "\n";
// As you can see add(), times() and shares() operate naively a rounded calculation on each unit

// You also can use multiply() of divide() to cascade units and get precise calculation:
echo CarbonInterval::make('19h 55m')->multiply(3)->forHumans();    // 2 days 11 hours 45 minutes
echo "\n";
echo CarbonInterval::make('19h 55m')->divide(3)->forHumans();      // 6 hours 38 minutes 20 seconds

echo $interval->forHumans();             // 10 hours 34 minutes
echo $interval->cascade()->forHumans();  // 10 hours 34 minutes

$cascades = CarbonInterval::getCascadeFactors(); // save initial factors

CarbonInterval::setCascadeFactors([
    'minute' => [60, 'seconds'],
    'hour' => [60, 'minutes'],
    'day' => [8, 'hours'],
    'week' => [5, 'days'],
    // in this example the cascade won't go farther than week unit
]);

echo CarbonInterval::fromString('20h')->cascade()->forHumans();              // 2 days 4 hours
echo CarbonInterval::fromString('10d')->cascade()->forHumans();              // 2 weeks
echo CarbonInterval::fromString('3w 18d 53h 159m')->cascade()->forHumans();  // 7 weeks 4 days 7 hours 39 minutes

// You can see currently set factors with getFactor:
echo CarbonInterval::getFactor('minutes', 'hour');                           // 60
echo CarbonInterval::getFactor('days', 'week');                              // 5

// And common factors can be get with short-cut methods:
echo CarbonInterval::getDaysPerWeek();                                       // 5
echo CarbonInterval::getHoursPerDay();                                       // 8
echo CarbonInterval::getMinutesPerHour();                                    // 60
echo CarbonInterval::getSecondsPerMinute();                                  // 60
echo CarbonInterval::getMillisecondsPerSecond();                             // 1000
echo CarbonInterval::getMicrosecondsPerMillisecond();                        // 1000

CarbonInterval::setCascadeFactors($cascades); // restore original factors

echo CarbonInterval::days(3)->addHours(5)->total('hours'); // 77
echo CarbonInterval::days(3)->addHours(5)->totalHours;     // 77
echo CarbonInterval::months(6)->totalWeeks;                // 24
echo CarbonInterval::year()->totalDays;                    // 336

echo CarbonInterval::minutes(1200)->cascade()->total('hours'); // 20
echo CarbonInterval::minutes(1200)->cascade()->totalHours; // 20

echo CarbonInterval::days(3)->addHours(5)->spec(); // P3DT5H
// By default microseconds are trimmed (as they would fail to recreate a proper DateInterval)
echo CarbonInterval::days(3)->addSeconds(5)->addMicroseconds(987654)->spec(); // P3DT5S
// But you can explicitly add them:
echo CarbonInterval::days(3)->addSeconds(5)->addMicroseconds(987654)->spec(true); // P3DT5.987654S

echo CarbonInterval::getDateIntervalSpec(new DateInterval('P3DT6M10S')); // P3DT6M10S

$halfDay = CarbonInterval::hours(12);
$oneDay = CarbonInterval::day();
$twoDay = CarbonInterval::days(2);

echo CarbonInterval::compareDateIntervals($oneDay, $oneDay);   // 0
echo $oneDay->compare($oneDay);                                // 0
echo CarbonInterval::compareDateIntervals($oneDay, $halfDay);  // 1
echo $oneDay->compare($halfDay);                               // 1
echo CarbonInterval::compareDateIntervals($oneDay, $twoDay);   // -1
echo $oneDay->compare($twoDay);                                // -1

$list = [$twoDay, $halfDay, $oneDay];
usort($list, ['Carbon\CarbonInterval', 'compareDateIntervals']);

echo implode(', ', $list);                                     // 12 hours, 1 day, 2 days

$weekDayInterval = new CarbonInterval(function (CarbonInterface $date, bool $negated): DateTime {
    // $negated is true when a subtraction is requested, false when an addition is requested
    return $negated
        ? $date->subWeekday()
        : $date->addWeekday();
});

echo Carbon::parse('Wednesday')->sub($weekDayInterval)->dayName; // Tuesday
echo "\n";
echo Carbon::parse('Friday')->add($weekDayInterval)->dayName; // Monday
echo "\n";

foreach (Carbon::parse('2020-06-01')->range('2020-06-17', $weekDayInterval) as $date) {
    // every week day
    echo ' '.$date->day;
}
// 1 2 3 4 5 8 9 10 11 12 15 16 17

echo $weekDayInterval->convertDate(new DateTime('Wednesday'), true)->dayName; // Tuesday
echo $weekDayInterval->convertDate(new DateTime('Friday'))->dayName; // Monday

$interval = CarbonInterval::months(2)->addHours(12)->addSeconds(50);
// All the values:
print_r($interval->toArray());
// Values sequence from the biggest to the smallest non-zero ones:
print_r($interval->getValuesSequence());
// Non-zero values:
print_r($interval->getNonZeroValues());

//Carbon Period

// Create a new instance:
$period = new CarbonPeriod('2018-04-21', '3 days', '2018-04-27');
// Use static constructor:
$period = CarbonPeriod::create('2018-04-21', '3 days', '2018-04-27');
// Use the fluent setters:
$period = CarbonPeriod::since('2018-04-21')->days(3)->until('2018-04-27');
// Start from a CarbonInterval:
$period = CarbonInterval::days(3)->toPeriod('2018-04-21', '2018-04-27');
// From a diff:
$period = Carbon::parse('2020-08-29')->diff('2020-09-02')->stepBy('day');
$period = Carbon::parse('2020-08-29')->diff('2020-09-02')->stepBy(12, 'hours');
// toPeriod can also be called from a Carbon or CarbonImmutable instance:
$period = Carbon::parse('2018-04-21')->toPeriod('2018-04-27', '3 days'); // pass end and interval
// interval can be a string, a DateInterval or a CarbonInterval
// You also can pass 2 arguments: number an string:
$period = Carbon::parse('2018-04-21')->toPeriod('2018-04-27', 3, 'days');
// Same as above:
$period = Carbon::parse('2018-04-21')->range('2018-04-27', 3, 'days'); // Carbon::range is an alias of Carbon::toPeriod
// Still the same:
$period = Carbon::parse('2018-04-21')->daysUntil('2018-04-27', 3);
// By default daysUntil will use a 1-day interval:
$period = Carbon::parse('2018-04-21')->daysUntil('2018-04-27'); // same as CarbonPeriod::create('2018-04-21', '1 day', '2018-04-27')
// 
//     microsUntil() or microsecondsUntil() provide the same feature for microseconds intervals
//     millisUntil() or millisecondsUntil() provide the same feature for milliseconds intervals
//     secondsUntil() provides the same feature for seconds intervals
//     minutesUntil() provides the same feature for minutes intervals
//     hoursUntil() provides the same feature for hours intervals
//     weeksUntil() provides the same feature for weeks intervals
//     monthsUntil() provides the same feature for months intervals
//     quartersUntil() provides the same feature for quarters intervals
//     yearsUntil() provides the same feature for years intervals
//     decadesUntil() provides the same feature for decades intervals
//     centuriesUntil() provides the same feature for centuries intervals
//     millenniaUntil() provides the same feature for millennia intervals
// 
// Using number of recurrences:
CarbonPeriod::create('now', '1 day', 3); // now, now + 1 day, now + 2 day
// Can be infinite:
CarbonPeriod::create('now', '2 days', INF); // infinite iteration
CarbonPeriod::create('now', '2 days', INF)->calculateEnd()->isEndOfTime(); // true
CarbonPeriod::create('now', CarbonInterval::days(-2), INF)->calculateEnd()->isStartOfTime(); // true

// Create a new instance:
$period = new CarbonPeriod('2018-04-21', '3 days', '2018-04-27');
// Use static constructor:
$period = CarbonPeriod::create('2018-04-21', '3 days', '2018-04-27');
// Use the fluent setters:
$period = CarbonPeriod::since('2018-04-21')->days(3)->until('2018-04-27');
// Start from a CarbonInterval:
$period = CarbonInterval::days(3)->toPeriod('2018-04-21', '2018-04-27');
// From a diff:
$period = Carbon::parse('2020-08-29')->diff('2020-09-02')->stepBy('day');
$period = Carbon::parse('2020-08-29')->diff('2020-09-02')->stepBy(12, 'hours');
// toPeriod can also be called from a Carbon or CarbonImmutable instance:
$period = Carbon::parse('2018-04-21')->toPeriod('2018-04-27', '3 days'); // pass end and interval
// interval can be a string, a DateInterval or a CarbonInterval
// You also can pass 2 arguments: number an string:
$period = Carbon::parse('2018-04-21')->toPeriod('2018-04-27', 3, 'days');
// Same as above:
$period = Carbon::parse('2018-04-21')->range('2018-04-27', 3, 'days'); // Carbon::range is an alias of Carbon::toPeriod
// Still the same:
$period = Carbon::parse('2018-04-21')->daysUntil('2018-04-27', 3);
// By default daysUntil will use a 1-day interval:
$period = Carbon::parse('2018-04-21')->daysUntil('2018-04-27'); // same as CarbonPeriod::create('2018-04-21', '1 day', '2018-04-27')

    // microsUntil() or microsecondsUntil() provide the same feature for microseconds intervals
    // millisUntil() or millisecondsUntil() provide the same feature for milliseconds intervals
    // secondsUntil() provides the same feature for seconds intervals
    // minutesUntil() provides the same feature for minutes intervals
    // hoursUntil() provides the same feature for hours intervals
    // weeksUntil() provides the same feature for weeks intervals
    // monthsUntil() provides the same feature for months intervals
    // quartersUntil() provides the same feature for quarters intervals
    // yearsUntil() provides the same feature for years intervals
    // decadesUntil() provides the same feature for decades intervals
    // centuriesUntil() provides the same feature for centuries intervals
    // millenniaUntil() provides the same feature for millennia intervals

// Using number of recurrences:
CarbonPeriod::create('now', '1 day', 3); // now, now + 1 day, now + 2 day
// Can be infinite:
CarbonPeriod::create('now', '2 days', INF); // infinite iteration
CarbonPeriod::create('now', '2 days', INF)->calculateEnd()->isEndOfTime(); // true
CarbonPeriod::create('now', CarbonInterval::days(-2), INF)->calculateEnd()->isStartOfTime(); // true

$period = CarbonPeriod::create('2018-04-21', '3 days', '2018-04-27');
foreach ($period as $key => $date) {
    if ($key) {
        echo ', ';
    }
    echo $date->format('m-d');
}
// 04-21, 04-24, 04-27
echo "\n";

// Here is what happens under the hood:
$period->rewind(); // restart the iteration
while ($period->valid()) { // check if current item is valid
    if ($period->key()) { // echo comma if current key is greater than 0
        echo ', ';
    }
    echo $period->current()->format('m-d'); // echo current date
    $period->next(); // move to the next item
}
// 04-21, 04-24, 04-27

$period = CarbonPeriod::create('2018-04-29', 7);
$dates = [];
foreach ($period as $key => $date) {
    if ($key === 3) {
        $period->invert()->start($date); // invert() is an alias for invertDateInterval()
    }
    $dates[] = $date->format('m-d');
}

echo implode(', ', $dates); // 04-29, 04-30, 05-01, 05-02, 05-01, 04-30, 04-29

// Possible options are: CarbonPeriod::EXCLUDE_START_DATE | CarbonPeriod::EXCLUDE_END_DATE
// Default value is 0 which will have the same effect as when no options are given.
$period = CarbonPeriod::createFromIso('R4/2012-07-01T00:00:00Z/P7D', CarbonPeriod::EXCLUDE_START_DATE);
$dates = [];
foreach ($period as $date) {
    $dates[] = $date->format('m-d');
}

echo implode(', ', $dates); // 07-08, 07-15, 07-22, 07-29

$period = CarbonPeriod::create('2010-05-06', '2010-05-25', CarbonPeriod::EXCLUDE_START_DATE);

$exclude = $period->getOptions() & CarbonPeriod::EXCLUDE_START_DATE;

echo $period->getStartDate();            // 2010-05-06 00:00:00
echo "\n";
echo $period->getEndDate();              // 2010-05-25 00:00:00
// Note than ->getEndDate() will return null when the end is not fixed.
// For example CarbonPeriod::since('2018-04-21')->times(3) use repetition, so we don't know the end before iteration.
// Then you can use ->calculateEnd() instead that will use getEndDate() if available and else will execute a complete
// iteration to calculate the end date.
echo "\n";
echo $period->getDateInterval();         // 1 day
echo "\n";
echo $exclude ? 'exclude' : 'include';   // exclude
echo "\n";

var_dump($period->isStartIncluded());    // bool(false)
echo "\n";
var_dump($period->isEndIncluded());      // bool(true)
echo "\n";
var_dump($period->isStartExcluded());    // bool(true)
echo "\n";
var_dump($period->isEndExcluded());      // bool(false)
echo "\n";

echo $period->getIncludedStartDate();    // 2010-05-07 00:00:00
// If start is included getIncludedStartDate() = getStartDate()
// If start is excluded getIncludedStartDate() = getStartDate() + 1 interval
echo "\n";
echo $period->getIncludedEndDate();      // 2010-05-25 00:00:00
// If end is included getIncludedEndDate() = getEndDate()
// If end is excluded getIncludedEndDate() = getEndDate() - 1 interval
// If end is null getIncludedEndDate() = calculateEnd(), it means the period is actually iterated to get the last date
echo "\n";

echo $period->toString();                // Every 1 day from 2010-05-06 to 2010-05-25
echo "\n";
echo $period; //implicit toString/      // Every 1 day from 2010-05-06 to 2010-05-25

$period = CarbonPeriod::create('2010-05-11', '2010-05-13');

echo $period->count();                   // 3, equivalent to count($period)
echo "\n";
echo implode(', ', $period->toArray());  // 2010-05-11 00:00:00, 2010-05-12 00:00:00, 2010-05-13 00:00:00
echo "\n";
echo $period->first();                   // 2010-05-11 00:00:00
echo "\n";
echo $period->last();                    // 2010-05-13 00:00:00

$period = CarbonPeriod::create('2010-05-01', '2010-05-14', CarbonPeriod::EXCLUDE_END_DATE);

$period->setStartDate('2010-05-11');
echo implode(', ', $period->toArray());  // 2010-05-11 00:00:00, 2010-05-12 00:00:00, 2010-05-13 00:00:00
echo "\n";

// Second argument can be optionally used to exclude the date from the results.
$period->setStartDate('2010-05-11', false);
$period->setEndDate('2010-05-14', true);
echo implode(', ', $period->toArray());  // 2010-05-12 00:00:00, 2010-05-13 00:00:00, 2010-05-14 00:00:00
echo "\n";

$period->setRecurrences(2);
echo implode(', ', $period->toArray());  // 2010-05-12 00:00:00, 2010-05-13 00:00:00
echo "\n";

$period->setDateInterval('PT12H');
echo implode(', ', $period->toArray());  // 2010-05-11 12:00:00, 2010-05-12 00:00:00

// This can also be set to 12 hours in all the following ways:
$period->setDateInterval('12h');
$period->setDateInterval('12 hours');
$period->setDateInterval(12, 'hours');
$period->setDateInterval(12, \Carbon\Unit::Hour);

// And reset to no explicit interval (will then use 1 day if iterated)
$period->resetDateInterval();

$period = CarbonPeriod::create('2010-05-06', '2010-05-25');

var_dump($period->isStartExcluded());    // bool(false)
var_dump($period->isEndExcluded());      // bool(false)

$period->toggleOptions(CarbonPeriod::EXCLUDE_START_DATE, true); // true, false or nothing to invert the option
var_dump($period->isStartExcluded());    // bool(true)
var_dump($period->isEndExcluded());      // bool(false) (unchanged)

$period->excludeEndDate();               // specify false to include, true or omit to exclude
var_dump($period->isStartExcluded());    // bool(true) (unchanged)
var_dump($period->isEndExcluded());      // bool(true)

$period->excludeStartDate(false);        // specify false to include, true or omit to exclude
var_dump($period->isStartExcluded());    // bool(false)
var_dump($period->isEndExcluded());      // bool(true)

$period = CarbonPeriod::create('2010-05-06', '2010-05-25');
$period2 = CarbonPeriod::create('2010-05-22', '2010-05-24');

var_dump($period->overlaps('2010-05-22', '2010-06-03'));   // bool(true)
var_dump($period->overlaps($period2));                     // bool(true)

$period = CarbonPeriod::create('2010-05-06 12:00', '2010-05-25');
$start = Carbon::create('2010-05-06 05:00');
$end = Carbon::create('2010-05-06 11:59');
var_dump($period->overlaps($start, $end));                 // bool(false)

$period = CarbonPeriod::createFromIso('R4/2012-07-01T00:00:00Z/P7D');
$days = [];
foreach ($period as $date) {
    $days[] = $date->format('d');
}

echo $period->getRecurrences();          // 4
echo implode(', ', $days);               // 01, 08, 15, 22

$days = [];
$period->setRecurrences(3)->excludeStartDate();
foreach ($period as $date) {
    $days[] = $date->format('d');
}

echo $period->getRecurrences();          // 3
echo implode(', ', $days);               // 08, 15, 22

$days = [];
$period = CarbonPeriod::recurrences(3)->sinceNow();
foreach ($period as $date) {
    $days[] = $date->format('Y-m-d');
}

echo implode(', ', $days);               // 2024-04-04, 2024-04-05, 2024-04-06

$period = CarbonPeriod::between('2000-01-01', '2000-01-15');
$weekendFilter = function ($date) {
    return $date->isWeekend();
};
$period->filter($weekendFilter);

$days = [];
foreach ($period as $date) {
    $days[] = $date->format('m-d');
}
echo implode(', ', $days);                         // 01-01, 01-02, 01-08, 01-09, 01-15

$period = CarbonPeriod::between('2000-01-01', '2000-01-10');
$days = [];
foreach ($period as $date) {
    $day = $date->format('m-d');
    $days[] = $day;
    if ($day === '01-04') {
        $period->skip(3);
    }
}
echo implode(', ', $days);                         // 01-01, 01-02, 01-03, 01-04, 01-08, 01-09, 01-10

$period = CarbonPeriod::end('2000-01-01')->recurrences(3);
var_export($period->getFilters());

$period = CarbonPeriod::between('2000-01-01', '2000-01-15');
$weekendFilter = function ($date) {
    return $date->isWeekend();
};

var_dump($period->hasFilter($weekendFilter));      // bool(false)
$period->addFilter($weekendFilter);
var_dump($period->hasFilter($weekendFilter));      // bool(true)
$period->removeFilter($weekendFilter);
var_dump($period->hasFilter($weekendFilter));      // bool(false)

// To avoid storing filters as variables you can name your filters:
$period->prependFilter(function ($date) {
    return $date->isWeekend();
}, 'weekend');

var_dump($period->hasFilter('weekend'));           // bool(true)
$period->removeFilter('weekend');
var_dump($period->hasFilter('weekend'));           // bool(false)

// Note that you can pass a name of any Carbon method starting with "is", including macros
$period = CarbonPeriod::between('2018-05-03', '2018-05-25')->filter('isWeekday');

$attempts = 0;
$attemptsFilter = function () use (&$attempts) {
    return ++$attempts <= 5 ? true : CarbonPeriod::END_ITERATION;
};

$period->prependFilter($attemptsFilter, 'attempts');
$days = [];
foreach ($period as $date) {
    $days[] = $date->format('m-d');
}
echo implode(', ', $days);                         // 05-03, 05-04, 05-07

$attempts = 0;

$period->removeFilter($attemptsFilter)->addFilter($attemptsFilter, 'attempts');
$days = [];
foreach ($period as $date) {
    $days[] = $date->format('m-d');
}
echo implode(', ', $days);                         // 05-03, 05-04, 05-07, 05-08, 05-09

// "start", "since", "sinceNow":
CarbonPeriod::start('2017-03-10') == CarbonPeriod::create()->setStartDate('2017-03-10');
// Same with optional boolean argument $inclusive to change the option about include/exclude start date:
CarbonPeriod::start('2017-03-10', true) == CarbonPeriod::create()->setStartDate('2017-03-10', true);
// "end", "until", "untilNow":
CarbonPeriod::end('2017-03-20') == CarbonPeriod::create()->setEndDate('2017-03-20');
// Same with optional boolean argument $inclusive to change the option about include/exclude end date:
CarbonPeriod::end('2017-03-20', true) == CarbonPeriod::create()->setEndDate('2017-03-20', true);
// "dates", "between":
//CarbonPeriod::dates(..., ...) == CarbonPeriod::create()->setDates(..., ...);
// "recurrences", "times":
CarbonPeriod::recurrences(5) == CarbonPeriod::create()->setRecurrences(5);
// "options":
CarbonPeriod::options(...) == CarbonPeriod::create()->setOptions(...);
// "toggle":
//CarbonPeriod::toggle(..., true) == CarbonPeriod::create()->toggleOptions(..., true);
// "filter", "push":
CarbonPeriod::filter(...) == CarbonPeriod::create()->addFilter(...);
// "prepend":
CarbonPeriod::prepend(...) == CarbonPeriod::create()->prependFilter(...);
// "filters":
CarbonPeriod::filters(...) == CarbonPeriod::create()->setFilters(...);
// "interval", "each", "every", "step", "stepBy":
CarbonPeriod::interval(...) == CarbonPeriod::create()->setDateInterval(...);
// "invert":
CarbonPeriod::invert() == CarbonPeriod::create()->invertDateInterval();
// "year", "months", "month", "weeks", "week", "days", "dayz", "day",
// "hours", "hour", "minutes", "minute", "seconds", "second":
CarbonPeriod::hours(5) == CarbonPeriod::create()->setDateInterval(CarbonInterval::hours(5));

$period = CarbonPeriod::create('2000-01-01 12:00', '3 days 12 hours', '2000-01-15 12:00');
echo $period->toString();            // Every 3 days and 12 hours from 2000-01-01 12:00:00 to 2000-01-15 12:00:00
echo "\n";
echo $period->toIso8601String();     // 2000-01-01T12:00:00+00:00/P3DT12H/2000-01-15T12:00:00+00:00

$period = new CarbonPeriod;
$period->setDateClass(CarbonImmutable::class);
$period->every('3 days 12 hours')->since('2000-01-01 12:00')->until('2000-01-15 12:00');

echo $period->getDateClass();              // Carbon\CarbonImmutable
echo "\n";
echo $period->getStartDate();              // 2000-01-01 12:00:00
echo "\n";
echo get_class($period->getStartDate());   // Carbon\CarbonImmutable

$period = CarbonPeriod::create('2018-04-21', '3 days', '2018-04-27');
$dates = $period->map(function (Carbon $date) {
    return $date->format('m-d');
});
// Or with PHP 7.4:
// $dates = $period->map(fn(Carbon $date) => $date->format('m-d'));
$array = iterator_to_array($dates); // $dates is a iterable \Generator
var_dump($array);
echo implode(', ', $array);

echo "\n";

// Here is what happens under the hood:
$period->forEach(function (Carbon $date) {
    echo $date->format('m-d')."\n";
});

$period = CarbonPeriod::create('2000-01-01 12:00', '3 days 12 hours', '2000-01-15 12:00');

// It would also works if your class extends DatePeriod
class MyPeriod extends CarbonPeriod {}

echo get_class($period->cast(MyPeriod::class)); // MyPeriod

// Shortcut to export as raw DatePeriod:
echo get_class($period->toDatePeriod());   // DatePeriod


$period = CarbonPeriod::create('2000-01-01 12:00', '3 days 12 hours', '2000-01-15 12:00');

// It would also works if your class extends DatePeriod
class MyPeriod extends CarbonPeriod {}

echo get_class($period->cast(MyPeriod::class)); // MyPeriod

// Shortcut to export as raw DatePeriod:
echo get_class($period->toDatePeriod());   // DatePeriod

$a = CarbonPeriod::create('2019-01-15', '2019-01-31');
$b = CarbonPeriod::create('2019-02-01', '2019-02-16');

var_dump($b->follows($a));               // bool(true)
var_dump($a->isFollowedBy($b));          // bool(true)
// ->isConsecutiveWith($period) is true if it either ->follows($period) or ->isFollowedBy($period)
var_dump($b->isConsecutiveWith($a));     // bool(true)
var_dump($a->isConsecutiveWith($b));     // bool(true)

$period = CarbonPeriod::create('2019-01-15', '2019-01-31');

var_dump($period->contains('2019-01-22'));         // bool(true)

$period = CarbonPeriod::create('2019-01-15', '2019-01-31', CarbonPeriod::EXCLUDE_END_DATE);

var_dump($period->contains('2019-01-31 00:00:00')); // bool(false)
var_dump($period->contains('2019-01-30 23:59:59')); // bool(true)

*/

//Carbon Date Time Zone

$tz = new CarbonTimeZone('Europe/Zurich'); // instance way
$tz = CarbonTimeZone::create('Europe/Zurich'); // static way

// Get the original name of the timezone (can be region name or offset string):
echo $tz->getName();                 // Europe/Zurich
echo "\n";
// Casting a CarbonTimeZone to string will automatically call getName:
echo $tz;                            // Europe/Zurich
echo "\n";
echo $tz->getAbbreviatedName();      // cet
echo "\n";
// With DST on:
echo $tz->getAbbreviatedName(true);  // cest
echo "\n";
// Alias of getAbbreviatedName:
echo $tz->getAbbr();                 // cet
echo "\n";
echo $tz->getAbbr(true);             // cest
echo "\n";
// toRegionName returns the first matching region or false, if timezone was created with a region name,
// it will simply return this initial value.
echo $tz->toRegionName();            // Europe/Zurich
echo "\n";
// toOffsetName will give the current offset string for this timezone:
echo $tz->toOffsetName();            // +02:00
echo "\n";
// As with DST, this offset can change depending on the date, you may pass a date argument to specify it:
$winter = Carbon::parse('2018-01-01');
echo $tz->toOffsetName($winter);     // +01:00
echo "\n";
$summer = Carbon::parse('2018-07-01');
echo $tz->toOffsetName($summer);     // +02:00

$tz = CarbonTimeZone::create('+03:00'); // full string
$tz = CarbonTimeZone::create(3); // or hour integer short way

$tz = CarbonTimeZone::createFromHourOffset(3); // explicit method rather type-based detection is even better
$tz = CarbonTimeZone::createFromMinuteOffset(180); // the equivalent in minute unit

// Both above rely on the static minute-to-string offset converter also available as:
$tzString = CarbonTimeZone::getOffsetNameFromMinuteOffset(180);
$tz = CarbonTimeZone::create($tzString);

echo $tz->getName();                 // +03:00
echo "\n";
echo $tz;                            // +03:00
echo "\n";
// toRegionName will try to guess what region it could be:
echo $tz->toRegionName();            // Europe/Helsinki
echo "\n";
// to guess with DST off:
echo $tz->toRegionName(null, 0);     // Europe/Moscow
echo "\n";
// toOffsetName will give the initial offset no matter the date:
echo $tz->toOffsetName();            // +03:00
echo "\n";
echo $tz->toOffsetName($winter);     // +03:00
echo "\n";
echo $tz->toOffsetName($summer);     // +03:00

$tz = new CarbonTimeZone(7);

echo $tz;                            // +07:00
echo "\n";
$tz = $tz->toRegionTimeZone();
echo $tz;                            // Asia/Novosibirsk
echo "\n";
$tz = $tz->toOffsetTimeZone();
echo $tz;                            // +07:00

$tz = CarbonTimeZone::instance(new DateTimeZone('Europe/Paris'));

echo $tz;                            // Europe/Paris
echo "\n";

// Bad timezone will throw an exception
try {
    CarbonTimeZone::instance('Europe/Chicago');
} catch (InvalidArgumentException $exception) {
    $error = $exception->getMessage();
}
echo $error;                         // Unknown or bad timezone (Europe/Chicago)

// as some value cannot be dump as string in an error message or
// have unclear dump, you may pass a second argument to display
// instead in the errors
try {
    $continent = 'Europe';
    $city = 'Chicago';
    $mixedValue = ['continent' => $continent, 'city' => $city];
    CarbonTimeZone::instance("$continent/$city", json_encode($mixedValue));
} catch (InvalidArgumentException $exception) {
    $error = $exception->getMessage();
}
echo $error;                         // Unknown or bad timezone ({"continent":"Europe","city":"Chicago"})