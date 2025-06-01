<?php

namespace App\Enums;

enum StoreCategory: string
{
    case PIZZA = 'Pizza';
    case GRILL = 'Grill';
    case FRIED_CHICKEN = 'Fried Chicken';
    case BURGERS = 'Burgers';
    case EASTERN_FOOD = 'Eastern Food';
    case CAFE = 'Cafe';
    case HEALTHY = 'Healthy';

    public function getDescription(): string
    {
        return match($this) {
            self::PIZZA => 'Authentic Italian and American style pizzas',
            self::GRILL => 'Grilled meats and BBQ specialties',
            self::FRIED_CHICKEN => 'Crispy fried chicken and sides',
            self::BURGERS => 'Gourmet burgers and sandwiches',
            self::EASTERN_FOOD => 'Traditional Middle Eastern cuisine',
            self::CAFE => 'Coffee, pastries, and light meals',
            self::HEALTHY => 'Nutritious and balanced meals',
        };
    }

    public function getExamples(): array
    {
        return match($this) {
            self::PIZZA => ['Pizza Hut', 'Domino\'s', 'Papa John\'s', 'Little Caesars'],
            self::GRILL => ['Texas Roadhouse', 'Outback Steakhouse', 'LongHorn Steakhouse', 'Ruth\'s Chris'],
            self::FRIED_CHICKEN => ['KFC', 'Popeyes', 'Chick-fil-A', 'Church\'s Chicken'],
            self::BURGERS => ['McDonald\'s', 'Burger King', 'Wendy\'s', 'Five Guys'],
            self::EASTERN_FOOD => ['Shawarma House', 'Falafel Palace', 'Kebab Corner', 'Hummus House'],
            self::CAFE => ['Starbucks', 'Costa Coffee', 'Dunkin\'', 'Tim Hortons'],
            self::HEALTHY => ['Sweetgreen', 'Freshii', 'Just Salad', 'Chopt'],
        };
    }
} 