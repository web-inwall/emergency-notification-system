<div>
    @if(!empty($templates))
        <select id="templateSelect">
            <option value="">Выберите шаблон</option>
            @foreach($templates as $template)
                <option value="{{ $template['template_name'] }}" data-message="{{ $template['message'] }}" data-users="{{ json_encode($template['users']) }}">{{ $template['template_name'] }}</option>
            @endforeach
        </select>
        <div id="templateDetails">
            <p id="templateName"></p>
            <p id="templateMessage"></p>
            <ul id="userDetails"></ul>
        </div>
    @else
        <p>Сохраненных шаблонов нет.</p>
    @endif
</div>
