<ul>
    @foreach($articles as $article)
        <li>
            <a href="{!! $article['listing_route'] !!}/{!! $article['id'] !!}?slug={!! $article['page_post']['slug'] !!}">{!! $article['page_post']['name'] !!}</a>
        </li>
    @endforeach
</ul>
