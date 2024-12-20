<?php

if (!function_exists('convertUnitPrice')) {
    function convertUnitPrice(string $currentUnit, float $price, string $selectedUnit): ?float
    {
        // Return null if the price is not valid
        if (is_nan($price)) {
            return null;
        }

        // Unit conversion ratios
        $unitRatios = [
            'foot' => 1,
            'inch' => 12,
            'yard' => 0.3333,
            'meter' => 0.3048,
            'gaz' => 0.9144
        ];

        // Check if the unit is valid
        if (!isset($unitRatios[$currentUnit]) || !isset($unitRatios[$selectedUnit])) {
            return null;
        }

        // Return the original price for specific units
        if (in_array($selectedUnit, ['pcs', 'box', 'coil'])) {
            return $price;
        }

        // Calculate the price based on the unit conversion
        $basePrice = $price / $unitRatios[$currentUnit];
        $newPrice = $basePrice * $unitRatios[$selectedUnit];

        return round($newPrice, 2);
    }
}
