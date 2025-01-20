<div>
    <div id="allTemplates" style="display: none">
        <h3>Все шаблоны:</h3>
        @if(!empty($templates))
            <select wire:change="selectTemplate($event.target.value)">
                <option value="">Выберите шаблон</option>
                @foreach($templates as $template)
                    <option value="{{ $template['template_name'] }}">{{ $template['template_name'] }}</option>
                @endforeach
            </select>

        @else
            <p>Сохраненных шаблонов нет.</p>
        @endif
    </div>

    <h3>Внесите получателей и введите сообщение</h3>
    <form id="uploadForm" action="{{ route('main.manageUserNotificationWorkflow') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(empty($selectedTemplateName))
            <input type="file" name="file" id="file" required>
        @endif
            <input type="text" name="template_name" placeholder="Имя шаблона отправки" wire:model="selectedTemplateName" required @if(!empty($selectedTemplateName)) readonly @endif>
            <textarea name="message" placeholder="Введите сообщение" wire:model="selectedTemplateMessage" required></textarea>
<input type="hidden" name="userMessage">


            <button type="submit">Отправить</button>
    </form>

    @if(!empty($selectedTemplateName))
        <div>
            <h3>Загруженные пользователи:</h3>
            <table id="userTable">
                {{-- <thead>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user['bio'] }}</td>
                            <td>{{ $user['link'] }}</td>
                            <td>{{ $user['address'] }}</td>
                        </tr>
                    @endforeach
                </thead> --}}

                <thead>
                    @foreach($users as $index => $user)
                    @if($index < 15)
                        <tr>
                            <td>{{ $user['bio'] }}</td>
                            <td>{{ $user['link'] }}</td>
                            <td>{{ $user['address'] }}</td>
                        </tr>
                    @else
                        @if($index == 15)
                            <tr>
                                <td colspan="3">...</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                    
                </thead>
                    
                <tbody></tbody>
            </table>
        </div>
    @endif

</div>

