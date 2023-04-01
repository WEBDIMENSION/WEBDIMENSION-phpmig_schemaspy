<?php

require_once 'vendor/autoload.php';
$faker = Faker\Factory::create('ja_JP');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include/define.php');

echo $faker->dateTimeBetween(USERS_CREATED_FROM, USERS_CREATED_TO)->format('Y-m-d');

//echo $faker->image('/app/src/images') ;

//echo $faker->imageUrl($width = '400', $height = '200', 'cats', true, 'Faker');
echo $created_at = $faker->dateTimeBetween('-5 years', '-4years')->format('Y-m-d H:i:s');
echo PHP_EOL;
echo $updated_at = date('Y-m-d H:i:s', strtotime($created_at) + (60 * 24 * 60 * 60) + (5 * 24 * 60 * 60) + (10 * 60 * 60) + (3 * 60) + 15);

//for ($i = 0; $i<100; $i++) {
//    $user_ids[] = $i;
//}
//foreach( array_rand( $user_ids, 10 ) as $key ) {
//    $response[] = $user_ids[$key] ;
//}
//
//echo (boolval(in_array(3,$response)) ? 'true' : 'false');
////var_dump($response);

//echo $faker->isbn13();
//echo PHP_EOL;
//echo $faker->ean13();

//echo $faker->realText($maxNbChars = 20, $indexSize = 1);
//echo PHP_EOL;
//echo $faker->domainName;
//echo PHP_EOL;
//echo $faker->localIpv4;
//echo PHP_EOL;
//echo $faker->tld;
//echo PHP_EOL;
//echo $faker->freeEmail;
//echo PHP_EOL;
//echo $faker->safeEmail;
//echo PHP_EOL;

//echo $faker->safeEmailDomain;
//echo PHP_EOL;
//echo $faker->freeEmailDomain;
//echo PHP_EOL;
//echo $faker->companyEmail;
//echo PHP_EOL;
//echo $faker->time($format = 'H:i:s', $max = 'now');
//echo PHP_EOL;
//echo  $faker->amPm;
//echo PHP_EOL;
//echo $faker->dayOfWeek($max = 'now');
//echo PHP_EOL;
//echo $faker->dayOfMonth($max = 'now');
//echo PHP_EOL;
//echo $faker->timezone;
//echo PHP_EOL;
//echo $faker->jobTitle;
//echo PHP_EOL;
//echo $faker->company;
//echo PHP_EOL;

//echo $faker->country;
//echo PHP_EOL;

//echo $faker->firstNameFemale;
//echo PHP_EOL;

//echo $faker->firstNameMale;
//echo PHP_EOL;
//echo $faker->name;
//echo PHP_EOL;

//echo  $faker->realText(100);
//echo PHP_EOL;

//echo $faker->text($maxNbChars = 100);
//echo PHP_EOL;

//echo $faker->paragraph($nbSentences = 3, $variableNbSentences = true);
//echo PHP_EOL;

//echo $faker->sentence($nbWords = 6, $variableNbWords = true);
//echo PHP_EOL;

//echo $faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}');
//echo PHP_EOL;

//echo $faker->lexify('Hello ???');
//echo PHP_EOL;
//
//echo $faker->numerify('Hello ###');
//echo PHP_EOL;

//echo $faker->randomElement($array = ['red','blue','white']);
//echo PHP_EOL;
//echo $faker->randomElements($array = ['red','blue','white'], $count = 2);
//var_dump($faker->randomElements($array = ['red','blue','white'], $count = 2));
//echo PHP_EOL;

//
//echo $faker->numberBetween($min = 1000, $max = 9000);
//echo PHP_EOL;

//echo $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100);
//echo PHP_EOL;
//
//echo $faker->randomNumber($nbDigits = 4, $strict = false);
//echo PHP_EOL;
//
//echo $faker->randomDigit;
//echo PHP_EOL;
//
//
////  FirstName
//echo $faker->firstName;
//echo PHP_EOL;
//// LastName
//echo $faker->lastName;
//echo PHP_EOL;
////  FirstKanaName
//echo $faker->firstKanaName;
//echo PHP_EOL;
//// LastKanaName
//echo $faker->lastKanaName;
//echo PHP_EOL;
//
//// Email
//echo $faker->email;
//echo PHP_EOL;
//
////Postcode
//
//echo $faker->postcode;
//echo PHP_EOL;
//
//// Address
////echo $faker->address;
//echo $faker->prefecture;
//echo PHP_EOL;
//
////市区町村
//echo $faker->ward . $faker->city;
//echo PHP_EOL;
////echo $faker->city;
//echo $faker->streetAddress . $faker->secondaryAddress;
//echo PHP_EOL;
//
//echo $faker->phoneNumber;
//echo PHP_EOL;
//
//echo $faker->dateTimeBetween('-80 years', '-20years')->format('Y-m-d');
//echo PHP_EOL;
//
//echo $faker->numberBetween(1, 5);
//echo PHP_EOL;
//
//echo $faker->realText(30);
//echo PHP_EOL;
////echo $faker->secondaryAddress;
////echo PHP_EOL;
//echo                     "
//               insert into users
//               (
//                   firstname,
//                   lastname,
//                   firstname_kana,
//                   lastname_kana,
//                   email,
//                   phone_number,
//                   password,
//                   postcode,
//                   prefecture,
//                   address1,
//                   address2,
//                   rank,
//                   memo
//               ) values (
//                '" . $faker->firstName . "',
//                '" . $faker->lastName . "',
//                '" . $faker->firstKanaName . "',
//                '" . $faker->lastKanaName . "',
//                '" . $faker->email . "',
//                '" . $faker->phoneNumber . "',
//                '" . " " . "',
//                '" . $faker->postcode . "',
//                '" . $faker->prefecture . "',
//                '" . $faker->ward . $faker->city . "',
//                '" . $faker->streetAddress . $faker->secondaryAddress . "',
//                '" . $faker->numberBetween(1, 5) . "',
//                '" . $faker->realText(30) . "'
//                )"
//    ;
//
//
