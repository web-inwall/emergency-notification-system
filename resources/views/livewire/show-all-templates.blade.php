<div>
    @if(!empty($templates))
    <select wire:model="selectedTemplateName">
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


@push('scripts')
<script>
    document.getElementById('templateSelect').addEventListener('change', function(e) {
        Livewire.emit('selectTemplate', e.target.value);
    });
</script>
@endpush
