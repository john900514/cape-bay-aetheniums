@extends($view)

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'Templates' => false,
      'Mailchimp Style Article' => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $title !!}</span>
            <small>{!! $subheading !!}.</small>

            <small><a href="{!! $go_back_url !!}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> Back to <span>"{!! $go_back_text !!}" Topics</span></a></small>
        </h2>
        <div class="biscuit col-md-9"></div>
    </section>
@endsection

@section('content')
    <div class="content-start row col-md-12">
        <div class="col-md-12">
            @if(array_key_exists('banner_img', $content))
            <div class="banner-img col-md-10">
                <img class="banner-img-img" src="{!! $content['banner_img']['src'] !!}">
            </div>
            @endif

            @foreach($content['sections'] as $section_idx => $section_data)
                    <section>
                        <h2>{!! $section_data['title'] !!}</h2>

                        @foreach($section_data['subsections'] as $subsection_idx => $subsection_data)
                            @switch($subsection_data['type'])
                                @case('textbody')
                                <div class="text-body-elem col-md-10">
                                    {!! $subsection_data['content'] !!}
                                </div>
                                @break

                                @case('ul')
                                @if(count($subsection_data['content']) > 0)
                                <div class="unordered-list-elem col-md-10">
                                    <ul>
                                        @foreach($subsection_data['content'] as $li)
                                            <li>{!! $li !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @break

                                @case('ol')
                                @if(count($subsection_data['content']) > 0)
                                    <div class="ordered-list-elem col-md-10">
                                        <ol>
                                            @foreach($subsection_data['content'] as $li)
                                                <li>{!! $li !!}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endif
                                @break

                                @case('content-tip')
                                <div class="col-sm-6 col-md-10">
                                    <div class="card {!! $subsection_data['tip-border-color'] ?? 'border-black' !!}">
                                        <div class="card-body row col-md-12">
                                            <div class="icon col-md-2">
                                                <div class="icon-left row justify-content-center align-items-center">
                                                    <i class="{!! $subsection_data['icon'] ?? 'la la-lightbulb' !!} {!! $subsection_data['icon-color'] ?? 'text-black' !!}"></i>
                                                </div>

                                            </div>
                                            <div class="body-right {!! $subsection_data['content-text-color'] ?? 'text-black' !!} row col-md-10">
                                                <div class="justify-content-center align-items-center">
                                                    <blockquote class="card-bodyquote">
                                                        {!! $subsection_data['content'] !!}
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break;

                                @case('code-highlight')
                                    @include('library.widgets.code-highlights.vue-code-highlighter', ['lang' => $subsection_data['language'], 'code' => $subsection_data['code'], 'theme' => $subsection_data['theme'] ?? 'prism-dark'])
                                @break;
                            @endswitch
                        @endforeach
                    </section>
            @endforeach
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        @media screen {
            .content-start {
                margin-top: 5%;
            }

            .banner-img {
                padding-bottom: 2.5%;
            }

            section {
                padding-top: 5%;
            }

            .text-body-elem, figure {
                padding: 4% 0;
            }

            .icon-left {
                height: 100%;
            }
            .icon-left i {
                font-size: 3em;
            }

        }

        @media screen and (max-width: 999px) {}

        @media screen and (min-width: 1000px) {
            .banner-img img {
                height: 187px;
                width: 100%;
            }

        }
    </style>
@endsection
