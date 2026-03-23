{{-- JavaScript Translation Helper --}}
@php
    try {
        $jsTranslations = [
            'navigation' => __('navigation'),
            'auth' => __('auth'),
            'common' => __('common'),
            'javascript' => __('javascript'),
        ];
    } catch (Exception $e) {
        $jsTranslations = ['navigation' => [], 'auth' => [], 'common' => [], 'javascript' => []];
    }
@endphp

<script>
    // Global translations object for JavaScript
    window.trans = function(key, defaults = '') {
        let translations = @json($jsTranslations);
        let keys = key.split('.');
        let value = translations;

        for (let k of keys) {
            if (value && typeof value === 'object' && k in value) {
                value = value[k];
            } else {
                return defaults || key;
            }
        }

        return value || defaults || key;
    };

    // Helper to get current language
    window.getCurrentLocale = function() {
        return '@php echo app()->getLocale(); @endphp';
    };

    // Log translation helper available
    console.debug('Translation helper loaded. Current locale: ' + window.getCurrentLocale());
</script>
