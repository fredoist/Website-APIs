# JKAnime API

*Last modified: March 20, 2017*

It uses their mobile API, some animes and/or episodes may not be available.

*Due to some unknown problems fetching their video stream link, it uses jkanime.io (sources from cdn.jkanime.us) to stream videos and search for animes.*

### Contents:

* [Licence](#licence)
* [Requirements](#requirements)
* [Getting started](#getting-started)
* [Get recent episodes](#get-recent-episodes)
* [Search for animes](#search-for-animes)
* [Get anime information](#get-anime-information)
* [Get episodes](#get-episodes)
* [Get episode source](#get-episode-source)
* [Formatted response](#formatted-response)
* [Extra links](#extra-links)

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
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    // now you can start using the api
?>
```

## Recent Episodes
---
Get recent episodes from JKAnime

```php
<?php
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    
    $recent = $API->recent();
    print_r($recent);
?>
```
    
Sample response:
    
```json
[
    {
        "episode": {
            "id": "34385",
            "title": "Trickster: Edogawa Ranpo \"Shounen Tanteidan\" yori - 23",
            "number": "23",
            "preview": "http://cdn.jkanime.net/assets/images/animes/video/image/jkvideo_5f36d9c889d244c93195686aad38397e.jpg",
            "thumbnail": "http://cdn.jkanime.net/assets/images/animes/thumbnail/trickster-edogawa-ranpo-shounen-tanteidan-yori.jpg",
            "date": "2017-03-20 16:16:13"
        },
        "anime": {
            "id": "1923",
            "type": "TV",
            "slug": "trickster-edogawa-ranpo-shounen-tanteidan-yori"
        }
    },
    ...
]
```

## Search for animes
---
Search for animes

Params | Type | Required? | Description
--- | --- | --- | ---
`$query` | `string` | yes | Keywords to search for

```php
<?php
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    
    $query = 'masamune';
    $search = $API->search($query);
    print_r($search);
?>
```
    
Sample response:

```json
[
    {
        "id": "1979",
        "title": "Masamune-kun no Revenge",
        "slug": "masamune-kun-no-revenge",
        "synopsis": "Como un niño obeso, Makabe Masamune sufrió del implacable acoso y la burla de una chica en particular, Aki Adagaki. Decidido a vengarse algún día de ella, comienza con un riguroso régimen de superación y transformación personal. Años más tarde, resurge como un hombre nuevo: atractivo, popular, con notas perfectas y bueno en los deportes. Masamune se matricula en el mismo instituto de Aki, dispuesto a hacerle pagar por todas las humillaciones que sufrió años atrás. Pero ¿será la venganza tan dulce como él pensaba?",
        "image": "http://cdn.jkanime.net/assets/images/animes/image/masamune-kun-no-revenge.jpg",
        "type": "TV",
        "status": "En emisión",
        "thumbnail": "http://cdn.jkanime.net/assets/images/animes/thumbnail/masamune-kun-no-revenge.jpg"
    },
    ...
]
```

## Get anime information
---
Get information from an anime

Params | Type | Required? | Description
--- | --- | --- | ---
`$slug` | `string` | yes | Anime slug

```php
<?php
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    
    $slug = 'masamune-kun-no-revenge';
    $info = $API->info($slug);
    print_r($info);
?>
```
    
Sample response:

```json
{
    "id": "1979",
    "title": "Masamune-kun no Revenge",
    "slug": "masamune-kun-no-revenge",
    "synopsis": "Como un niño obeso, Makabe Masamune sufrió del implacable acoso y la burla de una chica en particular, Aki Adagaki. Decidido a vengarse algún día de ella, comienza con un riguroso régimen de superación y transformación personal. Años más tarde, resurge como un hombre nuevo: atractivo, popular, con notas perfectas y bueno en los deportes. Masamune se matricula en el mismo instituto de Aki, dispuesto a hacerle pagar por todas las humillaciones que sufrió años atrás. Pero ¿será la venganza tan dulce como él pensaba?",
    "image": "http://cdn.jkanime.net/assets/images/animes/image/masamune-kun-no-revenge.jpg",
    "type": "TV",
    "status": "En emisión",
    "thumbnail": "http://cdn.jkanime.net/assets/images/animes/thumbnail/masamune-kun-no-revenge.jpg"
}
```

## Get episodes
---
Get episodes from an anime

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | Anime id

```php
<?php
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    
    $id = '1979';
    $episodes = $API->episodes($id);
    print_r($episodes);
?>
```
    
Sample response:

```json   
[
    {
        "id": "33784",
        "title": "Masamune-kun no Revenge - 1",
        "number": "1"
    },
    ...
]
```

## Get episode source
---
Get episode source (thumbnail, stream link, language)

Params | Type | Required? | Description
--- | --- | --- | ---
`$slug` | `string` | yes | Anime slug
`$number` | `number` | yes | Episode number

```php
<?php
    require 'JKAnimeNetApi.php';
    
    $API = new JKAnimeNetApi();
    
    $source = $API->source('masamune-kun-no-revenge', '1');
    print_r($source);
?>
```

Sample reponse:

```json
{
    "image": "http://cdn.jkanime.net/assets/images/animes/video/image/jkvideo_aac9d6ff4ed84a115986d514e4e18b08.jpg",
    "info": {
        "previous": null,
        "next": 2,
        "current": "1"
    },
    "label": "JK",
    "language": "Jap Sub.",
    "stream": "http://cdn.jkanime.us/media/masamune-kun-no-revenge/masamune-kun-no-revenge-1.mp4",
    "mslug": false,
    "programing": "Jueves 23 Marzo"
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