<?php

declare(strict_types=1);

namespace CdekSDK2;

use CdekSDK2\Actions\Barcodes;
use CdekSDK2\Actions\CalculatorTariff;
use CdekSDK2\Actions\CalculatorTariffList;
use CdekSDK2\Actions\Deliveries;
use CdekSDK2\Actions\Intakes;
use CdekSDK2\Actions\Invoices;
use CdekSDK2\Actions\LocationCities;
use CdekSDK2\Actions\LocationRegions;
use CdekSDK2\Actions\Offices;
use CdekSDK2\Actions\Orders;
use CdekSDK2\Actions\Webhooks;
use CdekSDK2\Dto\CityList;
use CdekSDK2\Dto\RegionList;
use CdekSDK2\Dto\TariffCodes;
use CdekSDK2\Dto\WebHookList;
use CdekSDK2\Dto\PickupPointList;
use CdekSDK2\Dto\Response;
use CdekSDK2\Exceptions\AuthException;
use CdekSDK2\Exceptions\ParsingException;
use CdekSDK2\Http\Api;
use CdekSDK2\Http\ApiResponse;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Client\ClientInterface;

/**
 * Class Client
 * @package CdekSDK2
 */
class Client
{
    /**
     * Объект для взаимодействия с API СДЭК
     * @var Api
     */
    private $http_client;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var Deliveries
     */
    private $deliveries;

    /**
     * @var Intakes
     */
    private $intakes;

    /**
     * @var Webhooks
     */
    private $webhooks;

    /**
     * @var Offices
     */
    private $offices;

    /**
     * @var Barcodes
     */
    private $barcodes;

    /**
     * @var Invoices
     */
    private $invoices;

    /**
     * @var LocationRegions
     */
    private $regions;

    /**
     * @var LocationCities
     */
    private $cities;

    /**
     * @var CalculatorTariffList
     */
    private $calculatorTariffList;

    /**
     * @var CalculatorTariff
     */
    private $calculatorTariff;

    /**
     * Client constructor.
     * @param ClientInterface $http
     * @param string|null $account
     * @param string|null $secure
     * @psalm-suppress PropertyTypeCoercion
     */
    public function __construct(ClientInterface $http, string $account = null, string $secure = null)
    {
        $this->http_client = new Api($http, $account, $secure);
        $this->serializer = SerializerBuilder::create()->setPropertyNamingStrategy(
            new SerializedNameAnnotationStrategy(
                new IdenticalPropertyNamingStrategy()
            )
        )->build();
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->http_client->getAccount();
    }

    /**
     * @param string $account
     * @return self
     */
    public function setAccount(string $account): self
    {
        $this->http_client->setAccount($account);
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->http_client->getToken();
    }

    /**
     * @param string $token
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->http_client->setToken($token);
        return $this;
    }

    /**
     * @return string
     */
    public function getSecure(): string
    {
        return $this->http_client->getSecure();
    }

    /**
     * @param string $secure
     * @return self
     */
    public function setSecure(string $secure): self
    {
        $this->http_client->setSecure($secure);
        return $this;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->http_client->isTest();
    }

    /**
     * @param bool $test
     * @return self
     */
    public function setTest(bool $test): self
    {
        $this->http_client->setTest($test);
        return $this;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->http_client->isExpired();
    }

    /**
     * @return int
     */
    public function getExpire(): int
    {
        return $this->http_client->getExpire();
    }

    /**
     * @param int $timestamp
     * @return self
     */
    public function setExpire(int $timestamp): self
    {
        $this->http_client->setExpire($timestamp);
        return $this;
    }

    /**
     * Авторизация клиента в сервисе Интеграции
     * @return bool
     * @throws AuthException
     * @throws Exceptions\RequestException
     */
    public function authorize(): bool
    {
        return $this->http_client->authorize();
    }

    /**
     * @return Intakes
     */
    public function intakes(): Intakes
    {
        if ($this->intakes === null) {
            $this->intakes = new Intakes($this->http_client, $this->serializer);
        }
        return $this->intakes;
    }

    /**
     * @return Orders
     */
    public function orders(): Orders
    {
        if ($this->orders === null) {
            $this->orders = new Orders($this->http_client, $this->serializer);
        }
        return $this->orders;
    }

    /**
     * @return Deliveries
     */
    public function deliveries(): Deliveries
    {
        if ($this->deliveries === null) {
            $this->deliveries = new Deliveries($this->http_client, $this->serializer);
        }
        return $this->deliveries;
    }

    /**
     * @return Offices
     */
    public function offices(): Offices
    {
        if ($this->offices === null) {
            $this->offices = new Offices($this->http_client, $this->serializer);
        }
        return $this->offices;
    }

    /**
     * @return LocationRegions
     */
    public function regions(): LocationRegions
    {
        if ($this->regions === null) {
            $this->regions = new LocationRegions($this->http_client, $this->serializer);
        }
        return $this->regions;
    }

    /**
     * @return LocationCities
     */
    public function cities(): LocationCities
    {
        if ($this->cities === null) {
            $this->cities = new LocationCities($this->http_client, $this->serializer);
        }
        return $this->cities;
    }

    /**
     * @return Webhooks
     */
    public function webhooks(): Webhooks
    {
        if ($this->webhooks === null) {
            $this->webhooks = new Webhooks($this->http_client, $this->serializer);
        }
        return $this->webhooks;
    }

    /**
     * @return Invoices
     */
    public function invoice(): Invoices
    {
        if ($this->invoices === null) {
            $this->invoices = new Invoices($this->http_client, $this->serializer);
        }
        return $this->invoices;
    }

    /**
     * @return Barcodes
     */
    public function barcodes(): Barcodes
    {
        if ($this->barcodes === null) {
            $this->barcodes = new Barcodes($this->http_client, $this->serializer);
        }
        return $this->barcodes;
    }

    /**
     * @return CalculatorTariffList
     */
    public function calculatorTariffList(): CalculatorTariffList
    {
        if ($this->calculatorTariffList === null) {
            $this->calculatorTariffList = new CalculatorTariffList($this->http_client, $this->serializer);
        }
        return $this->calculatorTariffList;
    }

    /**
     * @return CalculatorTariff
     */
    public function calculatorTariff(): CalculatorTariff
    {
        if ($this->calculatorTariff === null) {
            $this->calculatorTariff = new CalculatorTariff($this->http_client, $this->serializer);
        }
        return $this->calculatorTariff;
    }

    /**
     * @param ApiResponse $response
     * @param string $className
     * @param string|null $isEntity
     * @return Response
     * @throws ParsingException
     */
    public function formatResponse(ApiResponse $response, string $className, bool $isEntity = true): Response
    {
        if (class_exists($className)) {
            /* @var $result Response */
            $result = $this->serializer->deserialize($response->getBody(), Response::class, 'json');
            $result->entity = null;

            $array_response = json_decode($response->getBody(), true);
            $response = $isEntity ? $array_response['entity'] : $array_response;
            $entity = $this->serializer->deserialize(json_encode($response), $className, 'json');
            $result->entity = $entity;

            return $result;
        }

        throw new ParsingException('Class ' . $className . ' not found');
    }

    /**
     * @param ApiResponse $response
     * @param string $className
     * @param string|null $itemsKey
     * @return CityList|RegionList|PickupPointList|WebHookList|TariffCodes
     * @throws ParsingException
     */
    public function formatResponseList(ApiResponse $response, string $className, ?string $itemsKey = 'items')
    {
        if (class_exists($className)) {
            $body = $response->getBody();
            if (null !== $itemsKey) {
                $body = sprintf('{"%s": %s}', $itemsKey, $body);
            }
            return $this->serializer->deserialize($body, $className, 'json');
        }

        throw new ParsingException('Class ' . $className . ' not found');
    }
}
