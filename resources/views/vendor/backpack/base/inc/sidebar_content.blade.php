<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>

@php
    $page_shown = $page_shown ?? 'all';
    $active_client = $active_client ?? null;
    $library_id = $library_id ?? '8d9142bb-4740-4753-b0f9-ca79f1ab0da5';
@endphp

@foreach(\App\Models\Utility\SidebarOptions::getSidebarOptions($page_shown) as $nav_option)
    @if((is_null($nav_option->permitted_abilities)) || (backpack_user()->can($nav_option->permitted_abilities)))
        @if($nav_option->is_submenu)
            <li class="nav-item nav-dropdown">
                <button class="btn-transparent nav-link nav-dropdown-toggle text-left" style="width:100%">
                    @if(!is_null($nav_option->icon))<i class="{!! $nav_option->icon !!}"></i>@endif{!!  $nav_option->name !!}
                </button>
                @switch(($nav_option->name))
                    @case('Libraries')
                    @include(backpack_view('inc.sidebar_suboptions.libraries'))
                    @break

                    @case('Projects')
                    @include(backpack_view('inc.sidebar_suboptions.projects'))
                    @break

                    @case('Topics')
                    @include(backpack_view('inc.sidebar_suboptions.topics'))
                    @break

                    @default
                    @include(backpack_view('inc.sidebar_suboptions.default'))
                @endswitch
            </li>
        @elseif($nav_option->is_standalone)
            <li>
                @if($nav_option->is_modal)
                    <launch-a-modal-button
                            div-class="nav-item"
                            button-icon="{!! $nav_option->icon !!}"
                            button-text="{!! $nav_option->name !!}"
                            button-class="btn btn-link"
                            modal-src="{!! $nav_option->action_url !!}"
                    ></launch-a-modal-button>
                @elseif($nav_option->is_post_action)
                    <post-request-button
                            div-class="nav-item"
                            link-id="{!! $nav_option->id !!}"
                            button-icon="{!! $nav_option->icon !!}"
                            button-text="{!! $nav_option->name !!}"
                            button-class="btn btn-link"
                            action-url="{!! $nav_option->action_url !!}"
                            user-id="{!! backpack_user()->id !!}"
                            csrf="{!! csrf_token() !!}"
                    ></post-request-button>
                @else
                    <a class="nav-link" @if(!is_null($nav_option->route))href="{!! url($nav_option->route) !!}"@endif>
                        @if(!is_null($nav_option->icon))<i class="{!! $nav_option->icon !!}"></i>@endif{!!  $nav_option->name !!}
                        @if(strtotime($nav_option->created_at) > strtotime('now -3DAY'))<span class="badge badge-primary"> NEW! </span>@endif
                    </a>
                @endif
            </li>
        @endif
    @endif
@endforeach
