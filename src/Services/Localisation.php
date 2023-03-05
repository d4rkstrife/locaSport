<?php

namespace App\Services;

class Localisation
{
    public function getAddress(string $latitude, string $longitude): string
    {
        $query = $latitude . "," . $longitude;
        //dd($query);
        $queryString = http_build_query([
            'access_key' => 'ad81b9c232a0cab345eef95c3036636d',
            'query' => $query,
        ]);

        $ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/reverse', $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        $apiResult = json_decode($json, true);
        if(!$apiResult){
            //TODO : return if no answer from API
            dd('tutu');
        }
        $address = $apiResult['data'][0]['label'];
        return $address;
    }

    public function getCoords(string $address): array
    {
        $queryString = http_build_query([
            'access_key' => 'ad81b9c232a0cab345eef95c3036636d',
            'query' => $address,
        ]);

        $ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/forward', $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        $apiResult = json_decode($json, true);
        dd($apiResult);
        if(!$apiResult){
            //TODO return if no answer from API
            dd('tutu');
        }
        $latitude = $apiResult['data'][0]['latitude'];
        $longitude = $apiResult['data'][0]['longitude'];
        $coords = ['latitude' => $latitude, 'longitude' => $longitude];
        return $coords;
    }

    public function getDistance(array $firstPosition, array $secondePosition): int|float
    {
        $radius = 6371; // Rayon de la Terre en kilomètres
        $lat1 = deg2rad($firstPosition['latitude']);
        $lon1 = deg2rad($firstPosition['longitude']);
        $lat2 = deg2rad($secondePosition['latitude']);
        $lon2 = deg2rad($secondePosition['longitude']);
        $delta_lat = $lat2 - $lat1;
        $delta_lon = $lon2 - $lon1;
        $a = sin($delta_lat/2) * sin($delta_lat/2) +
            cos($lat1) * cos($lat2) *
            sin($delta_lon/2) * sin($delta_lon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $radius * $c;
        return $distance;
    }
}