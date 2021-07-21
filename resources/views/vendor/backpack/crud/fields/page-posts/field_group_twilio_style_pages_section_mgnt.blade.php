<!-- text input -->
@include('crud::fields.inc.wrapper_start')

<twilio-style-content-creator name="{!! $field['name'] !!}"
                              :preloaded-value="{{ $field['value'] ?? json_encode('') }}"
></twilio-style-content-creator>

@include('crud::fields.inc.wrapper_end')

@push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- include easymde css -->
    <link rel="stylesheet" href="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/easymde/dist/easymde.min.css') }}">
@endpush

@push('crud_fields_scripts')
    <script src="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('https://amchorcms-assets.s3.amazonaws.com/backpack_packages/easymde/dist/easymde.min.js') }}"></script>
@endpush


