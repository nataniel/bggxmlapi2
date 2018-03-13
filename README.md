# bggxmlapi2
PHP Client Library for BoardGameGeek.com [XML API2](https://boardgamegeek.com/wiki/page/BGG_XML_API2)

## Installation
```
composer require nataniel/bggxmlapi2
```

## Usage
```php
// initialize client
$client = new \Nataniel\BoardGameGeek\Client();

// download information about "Dixit"
// https://boardgamegeek.com/boardgame/39856/dixit
$thing = $client->getThing(39856, true);

var_dump($thing->getName());
var_dump($thing->getYearPublished());
var_dump($thing->getBoardgameCategories());
var_dump($thing->getRatingAverage());
// ...

// download information about user
// https://boardgamegeek.com/user/Nataniel
$user = $client->getUser('nataniel');

var_dump($user->getAvatar());
var_dump($user->getCountry());

// search for a game
$results = $client->search('Domek');
echo count($results);

$things = [];
foreach ($result as $item) {
    var_dump($item->getName());
    $things[] = $client->getThing($item->getId());
}
```
