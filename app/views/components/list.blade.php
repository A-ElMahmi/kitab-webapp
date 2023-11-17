<p>List Component</p>

@yield('count')
<ul>
    @for ($i = 0; $i < $count; $i++)
        <li>{{ $i }}</li>
    @endfor
</ul>
