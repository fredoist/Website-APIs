# datmusicApi

Fetch data from api.datmusic.xyz without log in on vk.com

### Contents:

*  [Licence](#licence)
*  [Requirements](#requirements)
*  [Getting started](#getting-started)
*  [Get feed](#get-feed)
*  [Search for music](#search-for-music)
*  [Formatted reponse](#formatted-response)
*  [Extra links](#extra-links)

## Licence
---
> (C) 2017 Freddy González. All rights reserved. You cannot modify, copy, share or use this code for any purpose.

## Requirements
---
This script requires **PHP** with **CURL** enabled.

## Getting started
---
To start using this script first include the class file on your project, then call to the class.

```php
<?php
    require 'datmusicApi.php';
    
    $API = new datmusicApi();
    // now you can start using the api
?>
```
## Get feed
---
Get recent uploaded songs

Params | Type | Required? | Description
--- | --- | --- | ---
`$page` | `number` | no | Results page number

```php
<?php
	require 'datmusicApi.php';
	
	$API = new datmusicApi();
	
	$page = 2;
	$feed = $API->feed($page);
	print_r($feed);

?>
```
Sample response:
```json
{
    "status": "ok",
    "data": [
        {
            "artist": "Ed Sheeran",
            "title": "Small Bump",
            "duration": 259,
            "download": "https://datmusic.xyz/dl/9f406b4b/6f2c408b",
            "stream": "https://datmusic.xyz/stream/9f406b4b/6f2c408b"
        },
        ...
    ]
}
```
## Search for music
---
Search by artist and song name

Params | Type | Required? | Description
--- | --- | --- | ---
`$query` | `string` | yes | Search keywords
`$page` | `number` | no | Results page number

```php
<?php
	require 'datmusicApi.php';
	
	$API = new datmusicApi();
	
	$query = 'Avril';
	$page = 1;
	$search = $API->search($query, $page);
	print_r($search);

?>
```
Sample response:
```json
{
    "status": "ok",
    "data": [
        {
            "artist": "Avril Lavigne",
            "title": "Give You What You Like (Official Audio)",
            "duration": 216,
            "download": "https://datmusic.xyz/dl/0d76541e/fdd9c702",
            "stream": "https://datmusic.xyz/stream/0d76541e/fdd9c702"
        },
        ...
    ]
}
```
## Formatted response
---
Optionally you can format the JSON response. It returns all JSON pretty printed

Params | Type | Required? | Description
--- | --- | --- | ---
`$value` | `boolean` | no | Format the JSON response

```php
<?php
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    
    $formatted = $API->format($value)->...;
    print_r($formatted);
?>
```
## Extra links
---
Contact the developer

* [Twitter](https://twitter.com/maddenamy_)
* [GitHub](https://github.com/maddenamy)
* [GitLab](https://gitlab.com/maddenamy)
* [e-Mail me](mailto:maddenamy@email.com)

Enjoy!