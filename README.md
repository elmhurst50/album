# Laravel Image Cache Repository

This package simply uses a directory of your choosing, allows you to set the sizes of images and then resizes and saves them as a cache file in the public directory of your choosing. Mirrors the original folders directory structure and keeps filename but with the addition of the dimensions on the cache filename. Only makes the cache file on request so non-used images / sizes wont be cached.

### Installation

```sh
$ composer install samjoyce777/album --save
```

Add the service provider to the config.php

```sh
$ \samjoyce777\album\AlbumServiceProvider::class,
```

Add the facade as well to make it all pretty

```sh
$ 'Album' => \samjoyce777\album\Facades\Album::class,
```

Move the config file to make your customizations

```sh
$ php artisan vendor:publish --tag=config
```

### Usage

This will return the cache image URL of the size you have requested listed in you config
```sh
Album::getImage('cushion.jpg', 'medium');
```

This will get return the cache image URL of the nearest sized image from your configured sizes, it will always make sure it is the same or larger.
```sh
Album::getNearestImage('cushion.jpg', 200);
```


## This is still in work in progress stage.

