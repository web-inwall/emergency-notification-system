<div>
    @if(!empty($templates))
        @foreach($templates as $template)
            <li>{{ $template['template_name'] }}</li>
        @endforeach
    @else
        <li>Сохраненных шаблонов нет.</li>
    @endif
</div>