<!-- disabled vueJS powered-text input -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

<library-slug-text
        name="{!! $field['name'] !!}"
        preloaded-value="{!! $field['value'] ?? '' !!}"
></library-slug-text>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')
