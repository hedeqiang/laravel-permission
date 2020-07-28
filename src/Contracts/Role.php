<?php

namespace Hedeqiang\Permission\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Role
{
    public function menus(): BelongsToMany;
}
