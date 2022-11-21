<?php

namespace XLR8RMS\App\Repository;

use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use Throwable;
use XLR8RMS\App\Entity\Hotel;
use XLR8RMS\App\Interfaces\Repository;

class HotelAPIRepository implements Repository
{
    const NAME_INFO = '0';
    const LONGITUDE_INFO = '1';
    const LATITUDE_INFO = '2';
    const PRICE_PER_NIGHT_INFO = '3';
    
    /**
     * Client rest instance
     *
     * @var Client $client
     */
    private Client $client;
    
    /**
     * Item collection items
     *
     * @var Collection
     */
    private Collection $items;
    
    /**
     * HotelAPIRepository constructor
     */
    public function __construct(array $sources = [], ?Client $client = null)
    {
        $this->setClient($client ?? new Client);
        $this->loadSourcingData($sources);
    }
    
    /**
     * Set rest client instance
     *
     * @param Client $client
     *
     * @return void
     */
    private function setClient(Client $client): void
    {
        $this->client = $client;
    }
    
    /**
     * Load each source endpoint data
     *
     * @param array $sources
     *
     * @return void
     */
    private function loadSourcingData(array $sources = []): void
    {
        if (empty($this->items)) {
            $this->initializeItems();
            
            foreach ($sources as $source) {
                $this->fetchSourceEndpoint($source);
            }
        }
    }
    
    /**
     * Initialize items
     *
     * @return void
     */
    private function initializeItems(): void
    {
        $this->items = new Collection;
    }
    
    /**
     * Fetch source endpoint
     *
     * @param string $source
     *
     * @return void
     */
    private function fetchSourceEndpoint(string $source): void
    {
        try {
            $response = $this->client->get($source);
            if ($response->getStatusCode() === 200) {
                $this->setItems(json_decode($response->getBody()->getContents(), true));
            }
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Set items
     *
     * @param array|null $items
     *
     * @return void
     */
    private function setItems(?array $items = []): void
    {
        
        foreach (data_get($items, 'message', []) as $item) {
            if ($this->validateItem($item)) {
                $this->items->add(new Hotel(
                    data_get($item, self::NAME_INFO),
                    data_get($item, self::LONGITUDE_INFO),
                    data_get($item, self::LATITUDE_INFO),
                    data_get($item, self::PRICE_PER_NIGHT_INFO)
                ));
            }
        }
    }
    
    /**
     * Validate item fields
     *
     * @param array $item
     *
     * @return bool
     */
    private function validateItem(array $item): bool
    {
        return !is_null(data_get($item, self::NAME_INFO))
            && !is_null(data_get($item, self::LONGITUDE_INFO))
            && !is_null(data_get($item, self::LATITUDE_INFO))
            && !is_null(data_get($item, self::PRICE_PER_NIGHT_INFO));
    }
    
    /**
     * Get item collection
     *
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
}
