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
        <div class="col-md-9">
            <div class="preface col-md-12">
                <p>{!! $content['preface'] !!}</p>
            </div>
            <div class="biscuit col-md-12"></div>

            @foreach($content['sections'] as $section_idx => $section_data)
                <section>
                    @if(!empty($section_data['title']))
                        <h2>{!! $section_data['title'] !!}</h2>
                    @endif

                    @foreach($section_data['subsections'] as $subsection_idx => $subsection_data)
                        @switch($subsection_data['type'])
                            @case('textbody')
                            <div class="text-body-elem col-md-12">
                                {!! $subsection_data['content'] !!}
                                <div class="biscuit col-md-12"></div>
                            </div>
                            @break

                            @case('figure-image')
                            <figure class="figure-richtext-image figure-full-width">
                                <div class="lightbox-img-wrapper">
                                    <a class="lightbox-img-anchor">
                                        <img alt="{!! $subsection_data['alt'] !!}" class="richtext-image full-width" height="{!! $subsection_data['height'] !!}" width="{!! $subsection_data['width'] !!}"  src="{!! $subsection_data['src'] !!}" />

                                        <div class="lightbox-img-wrapper-overlay">
                                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </div>
                            </figure>
                            <div class="biscuit col-md-12"></div>
                            @break

                            @case('card')
                                <div class="col-sm-6 col-md-10">
                                    <div class="card {!! $subsection_data['color_text'] ?? 'text-black' !!} {!! $subsection_data['card_bg'] ?? 'bg-primary' !!} {!! $subsection_data['text_centered'] ?? '' !!}">
                                        <div class="card-body">
                                            {!! $subsection_data['content'] !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="biscuit col-md-12"></div>
                            @break
                        @endswitch

                    @endforeach
                </section>
            @endforeach
        </div>
        <div class="col-md-3">
            <p>This will be the right side-bar</p>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        @media screen {
            .biscuit {
                border-bottom: 1px solid rgba(148,151,155,0.2);
            }

            .content-start {
                margin-top: 5%;
            }

            .preface {
                padding-bottom: 2.5%;
            }

            .preface p {
                font-size: 16px;
                line-height: 1.6;
            }

            section {
                padding-top: 3%;
            }

            .text-body-elem, figure {
                padding: 4% 0;
            }
        }

        @media screen and (max-width: 999px) {}

        @media screen and (min-width: 1000px) {}
    </style>
@endsection
