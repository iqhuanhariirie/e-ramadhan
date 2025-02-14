@foreach (['en', 'ms'] as $langKey)
{!! FormField::formButton(
    [
        'method' => 'patch',
        'route' => 'lang.switch',
        'title' => __('app.switch_'.$langKey.'_lang')
    ],
    $langKey,
    [
        'class' => 'btn btn-sm '.(config('app.locale') == $langKey ? 'btn-info' : 'btn-secondary'),
        'ms' => 'lang_'.$langKey
    ] + (config('app.locale') == $langKey ? ['disabled' => 'disabled'] : []),
    ['lang' => $langKey]
) !!}
@endforeach
