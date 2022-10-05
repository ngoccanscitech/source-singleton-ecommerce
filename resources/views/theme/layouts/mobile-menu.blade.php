<!--Mobile Menu-->
<div class="mobile-nav-wrapper" role="navigation">
    <div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Close Menu</div>
    <ul id="MobileNav" class="mobile-nav">
        @foreach ($headerMenu as $item)
            @if (count($item['child']))
            <li class="lvl1 parent megamenu">
                <a href="{{ url($item['link']) }}">{{ $item['label'] }} <i class="anm anm-plus-l"></i></a>
                <ul>
                    @foreach ($item['child'] as $child)
                        @if (count($child['child']))
                        <li>
                            <a href="{{ url($child['link']) }}" class="site-nav">{{ $child['label'] }} <i class="anm anm-plus-l"></i></a>
                            <ul>
                                @foreach ($child['child'] as $grandchild)
                                <li><a href="{{ $grandchild['link'] }}" class="site-nav">{{ $grandchild['label'] }}</a></li>
                                @endforeach
                            </ul>
                        @else
                        <li>
                            <a href="{{ url($child['link']) }}" class="site-nav">{{ $child['label'] }}</a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @else
            <li class="lvl1">
                <a href="{{ url($item['link']) }}" class="site-nav">{{ $item['label'] }}</a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
<!--End Mobile Menu-->
