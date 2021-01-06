<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelMake extends ModelMakeCommand
{
    public function getDefaultNamespace($rootNamespace){
        return $rootNamespace . '\\Models';
    }
}
