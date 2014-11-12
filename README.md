## AmsBus Client [![Build Status](https://travis-ci.org/thomaswiener/client-amsbus.svg?branch=master)](https://travis-ci.org/thomaswiener/client-amsbus)

### General

#### About

This package is a php client implementation for the AmsBus (RO) Webservice (SOAP).
It is based on the webservice description found here: INSERT DOC HERE

Below you will find example calls for the different endpoints.

#### Installation

Install via composer.

Add **"thomaswiener/client-amsbus": "dev-master"** to your composer.json and update vendors.

#### Source

Provider  | Url
----------| -----------------------------------------------------------
Packagist | https://packagist.org/packages/thomaswiener/client-amsbus
Github    | https://github.com/thomaswiener/client-amsbus


### Setup

```php
$loader = require_once __DIR__ . "/./vendor/autoload.php";

$config = array(
    'url'                   => 'https://eshopcv.amsbus.cz:8443/',
    'id'                    => 'xxxxxxxxxxxxx',
    'version'               => 'v1',
    'sslVerifcationEnabled' => false
);

$client            = new \AmsBusClient\Client($config);
$stationService    = new \AmsBusClient\Endpoint\Station($client);
$connectionService = new \AmsBusClient\Endpoint\Connection($client);
$seatService       = new \AmsBusClient\Endpoint\Seat($client);
$ticketService     = new \AmsBusClient\Endpoint\Ticket($client);

originCode       = 'Praha [*CZ]';
$destinationCode = 'Brno [*CZ]';
$pax             = ['John Doe', 'Jane Doe'];
$tripDate        = (new \DateTime())->setDate(2014, 12, 2);
```

### Station

#### Search by String

```php
$searchString = "Ber";
$response = $stationService->search($searchString);
```

### Connection

#### Search

```php
$connectionData = new \AmsBusClient\Data\Connection();
$connectionData
    ->setFrom($originCode)
    ->setTo($destinationCode)
    ->setTripDate($tripDate);

$response = $connectionService->search($connectionData);
$handle = $response->getData()->handle;
```

#### Get Info

```php
foreach ($response->getData()->connections as $index => $connection) {
    break;
}
$urlParams = [$handleId, $indexId];

$response = $connectionService->getInfo($urlParams);
```

### Seat

#### Block

```php
$response = $seatService->block(array(), $urlParams);

```

#### Unblock

```php
$response = $seatService->unblock(array(), $urlParams);
```

### Ticket

#### Create

```php
$urlParams = [$ticketHandle]; #from response

$additionalInfo = new \AmsBusClient\Data\AdditionalInfo();
foreach ($tickets as $index => $ticket) {
    $passenger = new \AmsBusClient\Data\Passenger();
    $passenger->setName('John Doe');
    $passenger->setTicketIdx($index);   //the ticket index in the array (probably)
    $additionalInfo->addPassenger($passenger);
}

$response = $ticketService->create($additionalInfo, $urlParams);
$ticket = $response->getData();
```

#### Get

```php
$response = $ticketService->get($ticketHandle);
```

#### Cancel

```php
$response = $ticketService->cancel($ticketHandle);
```

#### Refund

```php
foreach ($tickets as $ticket) {
    $transCode = $ticket->transCode;
    $operation = \AmsBusClient\Endpoint\Interfaces\TicketInterface::OPERATION_THERE;
    $response = $ticketService->refund($transCode, $operation);
    $refundHandles[] = $response->getData()->refundHandle;
}
```

#### RefundCancel

```php
foreach ($refundHandles as $refundHandle) {
    $response = $ticketService->refundCancel($refundHandle);
}
```
#### RefundConfirm
```php
foreach ($refundHandles as $refundHandle) {
    $response = $ticketService->refundConfirm($refundHandle);
}
```