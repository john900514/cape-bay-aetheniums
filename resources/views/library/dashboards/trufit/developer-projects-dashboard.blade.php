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
            'heading'     => $project['name'],
            'content'     => 'A Project in the TruFit Developer Library',
        ];
@endphp

@section('content')
@endsection

@section('after_scripts')
    <script>
        $(document).ready(function () {
            $('.navbar-brand').empty();
            $('.navbar-brand').append('<img src="https://websales.webfdm.com/content/themes/trufit/images/logo-black.png" class="bg-logo" width="75%"/>');
        })
    </script>
@endsection


