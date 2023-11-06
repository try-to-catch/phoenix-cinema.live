<?php

namespace App\Actions\Session;

class SaveFlashMessageAction
{
    public function handle($key = 'message'): void
    {
        if ($value = session($key)) {
            session()->flash($key, $value);
        }
    }
}
