<div>

    
    <h2 class="title_upload">Загрузите CSV файл или выберите сохраненный шаблон</h2>

    <div class="buttons">
        <button id="showTemplatesBtn" onclick="showAllTemplates()">Сохранённые шаблоны</button>

        <button onclick="deleteUsers()">Удалить все шаблоны</button>
    </div>    

    <div id="allTemplates" style="display: none">
        <h3 class="h3_all">Все шаблоны:</h3>
        @if(!empty($templates))
            <select wire:change="selectTemplate($event.target.value)">
                <option value="">Сохранённые шаблоны</option>
                @foreach($templates as $template)
                    <option value="{{ $template['template_name'] }}">{{ $template['template_name'] }}</option>
                @endforeach
            </select>

        @else
            <p>Сохраненных шаблонов нет.</p>
        @endif
    </div>


    


    <form id="uploadForm" action="{{ route('main.manageUserNotificationWorkflow') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(empty($selectedTemplateName))
            <input type="file" name="file" id="file" required>
        @endif
            <input type="text" name="template_name" placeholder="*Имя шаблона отправки" wire:model="selectedTemplateName" required @if(!empty($selectedTemplateName)) readonly @endif>
            <textarea name="message" placeholder="*Введите сообщение" wire:model="selectedTemplateMessage" required></textarea>
        <input type="hidden" name="userMessage">


            <button type="submit">Отправить</button>
    </form>

    @if(!empty($selectedTemplateName))
        <div>
            <h3 class="title_hidden">Загруженные пользователи:</h3>
            <table id="userTable">
                
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Способ отправки</th>
                        <th>Получатель</th>
                    </tr>
                </thead>

                <tbody>
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
                    

                    
                </tbody>
            </table>
        </div>
    @endif

</div>

