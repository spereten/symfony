<?php
declare(strict_types=1);

array_map(function($file) {
  file_put_contents($file,
        str_replace('$this->addSql(\'CREATE SCHEMA public\');', '',file_get_contents($file)));
},array_filter(glob('./migrations/*')));
