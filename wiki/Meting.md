# Meting Music Framework

Search for music on different chinnese music providers

### Contents:

* [Licence](#licence)
* [Requirements](#requirements)
* [Supported services](#supported-services)
* [Getting started](#getting-started)
* [Get song information](#get-song-information)
* [Get album information](#get-album-information)
* [Get playlist data](#get-playlist-data)
* [Search for artist, album, song and playlist](#search-for-artists-albums-songs-and-playlists)
* [Get song lyrics](#get-song-lyrics)
* [Get image URL](#get-image-url)
* [Get audio URL](#get-audio-url)
* [Formatted responses](#formatted-responses)
* [Extra links](#extra-links)


## Licence
---
>  (C) 2017 Freddy González. All rights reserved. You cannot modify, share or use this code for any purpose.

## Requirements
---
This script requires **PHP 5.3+** and **CURL** enabled.

## Supported services
---
Currently supported services:

* NetEase Music ([music.163.com](http://music.163.com))
* Tencent QQ Music ([music.qq.com](http://music.qq.com))
* Baidu Music ([play.baidu.com](http://play.baidu.com))
* Xiami Music ([www.xiami.com](http://www.xiami.com))
* Kugou Music ([www.kugou.com](http://www.kugou.com))
* Kuwo Music ([www.kuwo.cn](http://www.kuwo.cn)) *<-- (maybe is not supported)*


## Getting started
---
[Download](https://gitlab.com/maddenamy/APIs/raw/master/Meting.php) and include the Meting.php file on your project, then call to the class.

Params | Type | Required? | Description
--- | --- | --- | ---
`$service` | `string` | no | Service provider

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	// now you can start using the API
?>
```

## Get song information
---
Get information about a specific song

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | Song ID

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$id = 16432049;
	$data = $API->song($id);
	print_r($data);
?>
```
Sample response:
```json
[
    {
        "id": 16432049,
        "name": "When You're Gone",
        "artist": [
            "Avril Lavigne"
        ],
        "pic_id": 620124558072680,
        "url_id": 16432049,
        "lyric_id": 16432049,
        "source": "netease"
    }
]
```

## Get album information
---
Get information about a specific album

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | Album ID

```php
<?php
    /**
     *  Album info
     *  @description: Get information about a specific album
     *  @params: $id (!numeric, album id)
    */
    $data = $API->album($id);
?>
```
Sample response:
```json
```

## Get playlist data
---
Get data from a playlist

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | Playlist ID

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$id = 16432049;
	$data = $API->playlist($id);
	print_r($data);
?>
```
Sample response:
```json
[
    {
        "id": 19174026,
        "name": "Love",
        "artist": [
            "Seekonk"
        ],
        "pic_id": "2528876744624072",
        "url_id": 19174026,
        "lyric_id": 19174026,
        "source": "netease"
    },
]
```

## Search for artists, albums, songs and playlists
---
Search for artist, albums, songs and playlists *(and users)*

Params | Type | Required? | Description
--- | --- | --- | ---
`$query` | `string` | yes | Search keywords
`$pagination` | `number` | yes | Page number
`$limit` | `number` | yes | Page limit

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$query = 'Avril';
	$pagination = 1;
	$limit = 30;
	$data = $API->search($query, $pagination, $limit);
	print_r($data);
?>
```
Sample response:
```json
[
    {
        "id": 453176145,
        "name": "Listen",
        "artist": [
            "ONE OK ROCK",
            "Avril Lavigne"
        ],
        "pic_id": "18764265441339024",
        "url_id": 453176145,
        "lyric_id": 453176145,
        "source": "netease"
    },
    ...
]
```

## Get song lyrics
---
Get lyrics for a song if available

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | Lyric ID

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$id = 16432049;
	$data = $API->lyric($id);
	print_r($data);
?>
```
Sample response:
```json
{
    "lyric" : "[00:15.820]I always needed time on my own\n[00:20.690]I never thought\n[00:22.030]I'd need you there when I cried\n[00:28.890]And the days feel like years\n[00:31.480]when I'm alone\n[00:33.790]And the bed where you lie\n[00:37.060]Is made up on your side\n[00:45.500]When you walk away\n[00:47.820]I count the steps that you take\n[00:51.640]Do you see how much I need you right now?\n[00:57.030]When you're gone\n[00:59.470]The pieces of my heart\n[01:02.320]are missing you\n[01:03.980]When you're gone\n[01:06.500]The face I came to know\n[01:09.080]is missing too\n[01:10.770]When you're gone\n[01:13.360]The words I need to hear\n[01:15.310]to always get me through the day\n[01:20.150]And make it ok\n[01:24.590]I miss you\n[01:39.200]I never felt this way before\n[01:43.790]Everything that I do\n[01:46.980]reminds me of you\n[01:52.870]And the clothes you left\n[01:54.320]are lyin' on the floor\n[01:57.560]And they smell just like you\n[02:00.830]I love the things that you do\n[02:06.260]When you walk away\n[02:08.900]I count the steps that you take\n[02:12.650]Do you see how much\n[02:14.490]I need you right now?\n[02:19.450]When you're gone\n[02:21.530]The pieces of my heart\n[02:24.240]are missing you\n[02:25.380]When you're gone\n[02:28.000]The face I came to know\n[02:30.580]is missing too\n[02:31.870]When you're gone\n[02:33.740]The words I need to hear\n[02:36.050]to always get me through the day\n[02:41.190]And make it OK\n[02:44.940]I miss you\n[02:47.500]We were meant for each other\n[02:51.680]I keep forever\n[02:55.450]I know we were\n[03:00.880]All I ever wanted was for you to know\n[03:03.840]Everything I do I give my heart and soul\n[03:07.110]I can hardly breathe\n[03:08.020]I need to feel you here with me\n[03:11.750]Yeah\n[03:13.090]When you're gone\n[03:14.720]The pieces of my heart are missing you\n[03:18.890]When you're gone\n[03:21.300]The face I came to know\n[03:23.990]is missing too\n[03:25.610]When you're gone\n[03:27.690]The words I need to hear\n[03:29.950]to always get me through the day\n[03:35.110]And make it OK\n[03:39.230]I miss you\n",
    "tlyric" : "[00:15.820]\u6211\u603b\u662f\u9700\u8981\u81ea\u5df1\u72ec\u5904\u7684\u65f6\u95f4\n[00:20.690]\u6211\u4ece\u672a\u60f3\u8fc7\n[00:22.030]\u5f53\u6211\u54ed\u6ce3\u65f6\u9700\u8981\u4f60\n[00:28.890]\u5f53\u6211\u72ec\u81ea\u4e00\u4eba\u65f6\n[00:31.480]\u5374\u5ea6\u65e5\u5982\u5e74\n[00:33.790]\u5e8a\u4e0a\u4f60\u8eba\u7684\u4f4d\u7f6e\n[00:37.060]\u5df2\u7ecf\u4e3a\u4f60\u51c6\u5907\u597d\n[00:45.500]\u5f53\u4f60\u79bb\u5f00\u65f6\n[00:47.820]\u6211\u8ba1\u7b97\u7740\u4f60\u7684\u811a\u6b65\n[00:51.640]\u4f60\u660e\u767d\u6b64\u523b\u6211\u6709\u591a\u9700\u8981\u4f60\u5417\n[00:57.030]\u5f53\u4f60\u79bb\u53bb\n[00:59.470]\u6211\u788e\u6210\u4e00\u7247\u7684\u5fc3\n[01:02.320]\u60f3\u5ff5\u7740\u4f60\n[01:03.980]\u5f53\u4f60\u79bb\u53bb\n[01:06.500]\u719f\u6089\u7684\u9762\u5bb9\n[01:09.080]\u4e5f\u6d88\u5931\u4e86\n[01:10.770]\u5f53\u4f60\u79bb\u53bb\n[01:13.360]\u6211\u9700\u8981\u542c\u5230\u7684\u8bdd\u8bed\n[01:15.310]\u662f\u8fc7\u53bb\u603b\u662f\u966a\u4f34\u6211\u7684\n[01:20.150]\u5b89\u7136\u5ea6\u8fc7\u6bcf\u5929\u7684\u8bdd\u8bed\n[01:24.590]\u6211\u60f3\u4f60\n[01:39.200]\u4ee5\u524d\u4ece\u672a\u6709\u8fc7\u8fd9\u79cd\u611f\u89c9\n[01:43.790]\u6211\u505a\u7684\u6bcf\u4ef6\u4e8b\u60c5\n[01:46.980]\u90fd\u4f1a\u8054\u60f3\u5230\u4f60\n[01:52.870]\u4f60\u7559\u4e0b\u7684\u8863\u670d \n[01:54.320]\u4ecd\u5728\u5730\u677f\u4e0a \n[01:57.560]\u5b83\u4eec\u8fd8\u6b8b\u7559\u7740\u4f60\u7684\u6c14\u5473\n[02:00.830]\u6211\u7231\u4f60\u8fd9\u4e48\u505a\n[02:06.260]\u5f53\u4f60\u79bb\u5f00\u65f6\n[02:08.900]\u6211\u8ba1\u7b97\u7740\u4f60\u7684\u811a\u6b65\n[02:12.650]\u4f60\u660e\u767d\u6b64\u523b\n[02:14.490]\u6211\u6709\u591a\u9700\u8981\u4f60\u5417\n[02:19.450]\u5f53\u4f60\u79bb\u53bb\n[02:21.530]\u6211\u788e\u6210\u4e00\u7247\u7684\u5fc3\n[02:24.240]\u60f3\u5ff5\u7740\u4f60\n[02:25.380]\u5f53\u4f60\u79bb\u53bb\n[02:28.000]\u719f\u6089\u7684\u9762\u5bb9\n[02:30.580]\u4e5f\u6d88\u5931\u4e86\n[02:31.870]\u5f53\u4f60\u79bb\u53bb\n[02:33.740]\u6211\u9700\u8981\u542c\u5230\u7684\u8bdd\u8bed\n[02:36.050]\u662f\u8fc7\u53bb\u603b\u662f\u966a\u4f34\u6211\u7684\n[02:41.190]\u5b89\u7136\u5ea6\u8fc7\u6bcf\u5929\u7684\u8bdd\u8bed\n[02:44.940]\u6211\u60f3\u4f60\n[02:47.500]\u6211\u4eec\u662f\u5929\u751f\u4e00\u5bf9\n[02:51.680]\u6c38\u8fdc\u5728\u6b64\n[02:55.450]\u6211\u77e5\u9053\u6211\u4eec\u66fe\u7ecf\u662f\n[03:00.880]\u6211\u59cb\u7ec8\u60f3\u8ba9\u4f60\u660e\u767d\n[03:03.840]\u6211\u662f\u7528\u5fc3\u53ca\u7075\u9b42\u53bb\u505a\u6bcf\u4ef6\u4e8b\n[03:07.110]\u6211\u65e0\u6cd5\u547c\u5438\n[03:08.020]\u6211\u9700\u8981\u611f\u89c9\u4f60\u5728\u6b64\u966a\u4f34\u6211\n[03:11.750]Yeah\n[03:13.090]\u5f53\u4f60\u79bb\u53bb\n[03:14.720]\u6211\u788e\u6210\u4e00\u7247\u7684\u5fc3\u60f3\u5ff5\u7740\u4f60\n[03:18.890]\u5f53\u4f60\u79bb\u53bb\n[03:21.300]\u719f\u6089\u7684\u9762\u5bb9\n[03:23.990]\u4e5f\u6d88\u5931\u4e86\n[03:25.610]\u5f53\u4f60\u79bb\u53bb\n[03:27.690]\u6211\u9700\u8981\u542c\u5230\u7684\u8bdd\u8bed\n[03:29.950]\u662f\u8fc7\u53bb\u603b\u662f\u966a\u4f34\u6211\u7684\n[03:35.110]\u5b89\u7136\u5ea6\u8fc7\u6bcf\u5929\u7684\u8bdd\u8bed\n[03:39.230]\u6211\u60f3\u4f60"
}
```

## Get image URL
---
Get an image URL

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | Image ID

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$id = 620124558072680;
	$data = $API->pic($id);
	print_r($data);
?>
```
Sample response:
```json
{
    "url" : "https:\/\/p3.music.126.net\/nYrd7pOnTh7mdUzGYsjrJQ==\/620124558072680.jpg?param=300z300&quality=100"
}
```

## Get audio URL
---
Get audio mp3 URL

Params | Type | Required? | Description
--- | --- | --- | ---
`$id` | `number` | yes | URL ID
`$bitrate` | `number` | yes | Audio bitrate [128, 320]

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$id = 16432049;
	$bitrate = 128;
	$data = $API->url($id, $bitrate);
	print_r($data);
?>
```
Sample response:
```json
{
    "url" : "https:\/\/m8.music.126.net\/20170321084003\/04d8a543d3e6c2c877f0e4e2a6b4cc0e\/ymusic\/926d\/64e5\/4c44\/debb0300fac7cd3b4f13f9c074cd0d6e.mp3",
    "br" : 128
}
```

## Formatted response
---
Optionally give format to the JSON responses, JSON pretty print.

Params | Type | Required? | Description
--- | --- | --- | ---
`$value` | `boolean` | no | Format the JSON response

```php
<?php
	require 'Meting.php';
	
	$service = 'netease';
	$API = new Meting($service);
	
	$data = $API->format($value)->...;
	print_r($data);
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