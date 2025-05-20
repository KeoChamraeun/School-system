<?php

namespace App\Livewire\Component;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SwitchLanguage extends Component
{

    public function render()
    {
        return view('livewire.component.switch-language');
    }

    public $currentLocale;
    public $availableLocales = [
        'en' => 'English',
        'kh' => 'ភាសាខ្មែរ'
    ];

    public function mount()
    {
        $this->currentLocale = App::getLocale();
    }

    public function switchLanguage($locale)
    {
        if (!array_key_exists($locale, $this->availableLocales)) {
            return;
        }

        Session::put('locale', $locale);
        App::setLocale($locale);
        $this->currentLocale = $locale;

        // Optional: Dispatch event if other components need to react
        $this->dispatch('languageChanged', $locale);

        // Refresh the page to apply language changes
        $this->redirect(request()->header('Referer'));
    }
}
