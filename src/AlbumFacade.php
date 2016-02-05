<?php

namespace samjoyce777\album;

use Illuminate\Support\Facades\Facade;

class AlbumFacade extends Facade {

protected static function getFacadeAccessor() { return 'Album'; }

}