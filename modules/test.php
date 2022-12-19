<?php

require_once '/vendor/autoload.php';

// configure the Google Client
$client = new Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$path = './creds.json';
$client->setAuthConfig($path);

// configure the Sheets Service
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1rDpBY_jAUSLy2h3cit6jGxGrU_Ntg9rGv-fgV2Dr23k';
$spreadsheet = $service->spreadsheets->get($spreadsheetId);
//var_dump($spreadsheet);

// $range = 'test!A1'; // here we use the name of the Sheet to get all the rows
// $response = $service->spreadsheets_values->get($spreadsheetId, $range);
// $values = $response->getValues();
// var_dump($values);

// $updateRow = [
//     '456740',
//     'Hellboy Updated Row',
//     'https://image.tmdb.org/t/p/w500/bk8LyaMqUtaQ9hUShuvFznQYQKR.jpg',
//     "Hellboy comes to England, where he must defeat Nimue, Merlin's consort and the Blood Queen. But their battle will bring about the end of the world, a fate he desperately tries to turn away.",
//     '1554944400',
//     'Fantasy, Action'
// ];
// $rows = [$updateRow];
// $valueRange = new \Google_Service_Sheets_ValueRange();
// $valueRange->setValues($rows);
// $range = 'test!A2'; // where the replacement will start, here, first column and second line
// $options = ['valueInputOption' => 'USER_ENTERED'];
// $service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $options);