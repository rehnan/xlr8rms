"# xlr8rms"

```
use XLR8RMS\App\Enums\OrderBy;
use XLR8RMS\App\Repository\HotelAPIRepository;
use XLR8RMS\App\Service\HotelSearchService;

$sources = [
'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_1.json',
'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_2.json'
];

$repository = new HotelAPIRepository($sources);

$service = new HotelSearchService($repository);

$latitude = -0.13395249999996395;
$longitude = 67.25;

$nearbyHotels = $service->getNearbyHotels($latitude, $longitude, OrderBy::PRICE_PER_NIGHT);

```