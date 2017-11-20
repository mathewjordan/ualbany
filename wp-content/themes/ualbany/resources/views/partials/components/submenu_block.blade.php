@php
/**
 * @var array $content
**/

$menu = VS\PageBuilder\Modules\ACF\SubmenuNav::get_child_links( $content['menu'], $content['menu_item'] );

@endphp
<div class="component-submenu-block-wrap component-wrap">
    @if($content['title'])
        <h4>{{$content['title']}}</h4>
    @endif
    @if($menu)
        <ul class="ul-link">
        @foreach($menu as $item)
            <li>
                <a href="{{$item->url}}">{{$item->title}}</a>
            </li>
        @endforeach
        </ul>
    @endif
</div>