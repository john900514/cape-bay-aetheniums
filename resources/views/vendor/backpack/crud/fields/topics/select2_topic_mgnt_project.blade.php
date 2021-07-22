<!-- modified from "select2 from array" -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<project-select-topic-context
        name="{{ $field['name'] }}"
        preloaded-value="{!! $field['value'] ?? '' !!}"
></project-select-topic-context>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2/dist/js/select2.full.min.js"></script>
        @if (app()->getLocale() !== 'en')
            <script src="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js') }}"></script>
        @endif
        <script>
            function bpFieldInitSelect2FromArrayElement(element) {
                if (!element.hasClass("select2-hidden-accessible"))
                {
                    element.select2({
                        theme: "bootstrap"
                    });
                }
            }
        </script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
