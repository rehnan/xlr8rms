<?php

namespace XLR8RMS\App\Interfaces;

use Illuminate\Support\Collection;

interface Repository
{
    public function getItems(): Collection;
}
