<?php

namespace Core;

/**
 * Fetches current weather data from the Open-Meteo API (free, no key required).
 *
 * @see https://open-meteo.com/en/docs
 */
class WeatherService
{
    /**
     * Map WMO weather codes to human-readable descriptions.
     *
     * @see https://open-meteo.com/en/docs#weathervariables
     */
    private const WEATHER_CODES = [
        0  => "Clear",
        1  => "Partly cloudy",
        2  => "Partly cloudy",
        3  => "Partly cloudy",
        45 => "Fog",
        48 => "Fog",
        51 => "Drizzle",
        53 => "Drizzle",
        55 => "Drizzle",
        61 => "Rain",
        63 => "Rain",
        65 => "Rain",
        71 => "Snow",
        73 => "Snow",
        75 => "Snow",
        80 => "Showers",
        81 => "Showers",
        82 => "Showers",
        95 => "Thunderstorm",
        96 => "Thunderstorm",
        99 => "Thunderstorm",
    ];

    /**
     * Get current weather for a given latitude/longitude.
     *
     * @param  float $lat  Latitude.
     * @param  float $lon  Longitude.
     * @return array|null  ['temperature' => X, 'humidity' => Y, 'description' => Z] or null on error.
     */
    public static function getWeather(float $lat, float $lon): array|null
    {
        try {
            $url = sprintf(
                "https://api.open-meteo.com/v1/forecast?latitude=%s&longitude=%s"
                . "&current=temperature_2m,relative_humidity_2m,weather_code&timezone=auto",
                $lat,
                $lon,
            );

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 15,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response === false || $httpCode !== 200) {
                return null;
            }

            $data = json_decode($response, true);

            if (!$data || empty($data["current"])) {
                return null;
            }

            $current = $data["current"];
            $weatherCode = (int) ($current["weather_code"] ?? -1);

            return [
                "temperature" => $current["temperature_2m"] ?? null,
                "humidity"    => $current["relative_humidity_2m"] ?? null,
                "description" => self::WEATHER_CODES[$weatherCode] ?? "Unknown",
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }
}
