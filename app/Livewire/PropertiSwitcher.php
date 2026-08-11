<?php

namespace App\Livewire;

use App\Services\PropertiContext;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PropertiSwitcher extends Component
{
    public function render()
    {
        $context = app(PropertiContext::class);
        $user = Auth::user();

        $propertiList = $context->availableFor($user);
        $currentId = $context->currentId();

        return view('livewire.properti-switcher', [
            'propertiList' => $propertiList,
            'currentId' => $currentId,
            'currentProperti' => $propertiList->firstWhere('id', $currentId),
        ]);
    }

    public function switchProperti($id)
    {
        app(PropertiContext::class)->set($id);

        return redirect(request()->header('Referer') ?? filament()->getCurrentPanel()?->getUrl() ?? '/');
    }
}
