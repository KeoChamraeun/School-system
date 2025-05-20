<div class="language-switcher">
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            {{ strtoupper($currentLocale) }}
        </button>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
            @foreach($availableLocales as $locale => $language)
                @if($locale !== $currentLocale)
                    <a class="dropdown-item" href="#" wire:click.prevent="switchLanguage('{{ $locale }}')">
                        <button class="btn btn-link">
                            {{ strtoupper($locale) }} - {{ $language }}
                        </button>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('styles')
    <style>
        .language-switcher .dropdown-toggle {
            background: transparent;
            border: 1px solid #dee2e6;
            color: inherit;
        }

        .language-switcher .dropdown-toggle:after {
            vertical-align: middle;
        }

        .language-switcher .dropdown-item {
            display: flex;
            align-items: center;
        }

        .language-switcher .dropdown-item button {
            color: inherit;
            background: transparent;
            border: none;
            padding: 0;
        }

        .language-switcher .dropdown-item button:hover {
            text-decoration: underline;
        }
    </style>
@endpush
