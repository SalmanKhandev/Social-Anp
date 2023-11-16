<?php

namespace App\Repositories;

use App\Models\Platform;

class SettingsRepository
{
    public function platforms()
    {
        return Platform::all();
    }
}
