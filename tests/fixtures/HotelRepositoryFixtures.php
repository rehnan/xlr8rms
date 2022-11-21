<?php

namespace Tests\Fixtures;

use Illuminate\Support\Collection;
use XLR8RMS\App\Entity\Hotel;
use XLR8RMS\App\Repository\HotelAPIRepository;

class HotelRepositoryFixtures {
    
    static public function getPayload(): Collection {
        return (new Collection([
            [
                "Turim Av Liberdade Hotel",
                "38.728368",
                "-9.136718",
                "176.25"
            ],
            [
                "Huasteca Secreta",
                "22.565162051373935",
                "-99.35411725513916",
                "121.05"
            ],
            [
                "Huckleberries",
                "51.5136751",
                "-0.13395249999996395",
                "67.25"
            ],
            [
                "Huckleberries",
                "51.5136751",
                "-0.13395249999996395",
                "94.15"
            ],
            [
                "IGH Eliseos",
                "36.7209997",
                "-4.4104951",
                "107.6"
            ],
            [
                "Ikkuna Hotel",
                "38.70064980735529",
                "-9.415454864501953",
                "13.45"
            ],
            [
                "Inn on the Lake",
                "60.721835067425005",
                "-135.0600698894043",
                "121.05"
            ]
        ]))->map(fn (array $item) => new Hotel(
            data_get($item, HotelAPIRepository::NAME_INFO),
            data_get($item, HotelAPIRepository::LONGITUDE_INFO),
            data_get($item, HotelAPIRepository::LATITUDE_INFO),
            data_get($item, HotelAPIRepository::PRICE_PER_NIGHT_INFO)
        ));
    }
    
    static public function getRawPayloadSource1(): string {
        return '
        {
        "success": true,
        "message": [
            [
                "Turim Av Liberdade Hotel",
                "38.728368",
                "-9.136718",
                "176.25"
            ],
            [
                "Huasteca Secreta",
                "22.565162051373935",
                "-99.35411725513916",
                "121.05"
            ],
            [
                "Huckleberries",
                "51.5136751",
                "-0.13395249999996395",
                "67.25"
            ],
            [
                "Huckleberries",
                "51.5136751",
                "-0.13395249999996395",
                "94.15"
            ],
            [
                "IGH Eliseos",
                "36.7209997",
                "-4.4104951",
                "107.6"
            ],
            [
                "Ikkuna Hotel",
                "38.70064980735529",
                "-9.415454864501953",
                "13.45"
            ]
        }';
    }
    
    static public function getRawPayloadSource2(): string {
        return '
        {
        "success": true,
        "message": [
            [
                "World Trip Hotel UNIV",
                "38.718859651978086",
                "-9.143747010809307",
                "26.9"
            ],
            [
                "Yellow Alvor Garden Hotel",
                "37.13611203125941",
                "-8.583958047438045",
                "80.7"
            ],
            [
                "Yellow Hotels",
                "37.118033714520735",
                "-8.651768947412165",
                "26.9"
            ],
            [
                "Yellow Lagos Meia Praia Hotel",
                "37.11776669037494",
                "-8.65074634552002",
                "26.9"
            ],
            [
                "Yellow Praia de Monte Gordo Hotel",
                "37.17958183092678",
                "-7.445202607124315",
                "40.35"
            ],
            [
                "York House",
                "38.7096083",
                "-9.1539178",
                "53.8"
            ],
            [
                "Yosemite Lodget at The Falls",
                "37.85",
                "-119.55",
                "40.35"
            ],
            [
                "Your Hotel",
                "41.51976015889568",
                "-73.42248916625977",
                "121.05"
            ],
            [
                "Your Hotel and Spa Alcoba?a",
                "39.5499672",
                "-8.9829267",
                "53.8"
            ],
            [
                "Zimbali Holiday Rentals",
                "-29.555465066139902",
                "31.1997127532959",
                "13.45"
            ],
            [
                "ZUZA Bed & Breakfast",
                "38.7134639",
                "-9.141543400000046",
                "53.8"
            ],
            [
                "ZUZA GuestHouse",
                "38.7131057034633",
                "-9.141461849212646",
                "26.9"
            ],
            [
                "ZUZA Main",
                "38.7134372",
                "-9.142177100000026",
                "134.5"
            ]
        ]
        }';
    }
}

