@foreach ($menu as $key => $item)
    @if($item['type'] == 'menu')
        <li class="kt-menu__section "><h4 class="kt-menu__section-text">{{$key}}</h4></li>
        @include('widgets.side_menu', ['menu' => $item['menu']])
    @else
        <li class="kt-menu__item " aria-haspopup="true">
            <a href="{{is_callable($item['link']) ? $item['link']() : ($item['link'] ?? '')}}" class="kt-menu__link">
                <span class="kt-menu__link-icon">{!! $item['icon'] !!}</span>
                <span class="kt-menu__link-text">{{$key}}</span>
            </a>
        </li>
    @endif
@endforeach
