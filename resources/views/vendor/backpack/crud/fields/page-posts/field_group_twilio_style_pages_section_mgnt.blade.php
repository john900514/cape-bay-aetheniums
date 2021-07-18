<!-- text input -->
@include('crud::fields.inc.wrapper_start')

<twilio-style-content-creator name="{!! $field['name'] !!}"
                              :preloaded-value="{{ $field['value'] ?? '' }}"
></twilio-style-content-creator>

@include('crud::fields.inc.wrapper_end')

@push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- include easymde css -->
    <link rel="stylesheet" href="{{ asset('packages/easymde/dist/easymde.min.css') }}">
@endpush

@push('crud_fields_scripts')
    <script src="{{ asset('packages/easymde/dist/easymde.min.js') }}"></script>
@endpush


