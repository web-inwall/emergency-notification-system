<div>
    @if(!empty($templates))
    <select wire:model="selectedTemplateName" wire:change="selectTemplate($event.target.value)">
        <option value="">Выберите шаблон</option>
        @foreach($templates as $template)
            <option value="{{ $template['template_name'] }}">{{ $template['template_name'] }}</option>
        @endforeach
    </select>
    
    <p>{{ $selectedTemplateName }}</p>
    <p>{{ $selectedTemplateMessage }}</p>
    <p>{{ $selectedUserBio }}</p>
    <p>{{ $selectedUserLink }}</p>
    <p>{{ $selectedUserAddress }}</p>

    @else
    <p>Сохраненных шаблонов нет.</p>
    @endif
</div>
