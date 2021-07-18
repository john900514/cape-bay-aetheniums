@extends(backpack_view('blank'))

@section('before_styles')
    <style>
        @media screen {
            .no-body .card-body {
                display: none;
            }
        }
    </style>
@endsection

@php
    $role_slug = backpack_user()->getRoles()[0];
    $role = \App\Models\AccessControl\Roles::whereName($role_slug)->first();

    $widgets['before_content'][] = [
            'type'       => 'card',
            'wrapper' => ['class' => 'col-sm-6 col-md-4 no-body'], // optional
            'class'   => 'card bg-purple text-white', // optional
            'content'    => [
                'header' => backpack_user()->name.' <i>( '.$role->title.' )</i>', // optional
                'body'   => '',
            ]
        ];

        $widgets['before_content'][] = [
            'type'        => 'smaller-jumbotron',
            'heading'     => 'Cape & Bay Developer Library Dashboard',
            'content'     => trans('backpack::base.use_sidebar'),

        ];
@endphp

@section('content')
@endsection


@section('after_scripts')
    <script>
        $(document).ready(function () {
            $('.navbar-brand').empty();
            $('.navbar-brand').append('<span class="fl-heading-text">Cape &amp; Bay</span>');
        });
    </script>
@endsection
