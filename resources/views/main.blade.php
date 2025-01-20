<!DOCTYPE html>

<html>
<head>
    <title>Главная</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
</head>
<body>
    <div class="container">
        <button id="deleteButton">Удалить данные</button>
        
        {{-- <button id="deleteButton" data-delete-route="{{ route('home.delete') }}">Удалить данные</button> --}}

        <button id="showTemplatesBtn" onclick="showAllTemplates()">Показать все шаблоны</button>
        
        @livewire('show-all-templates')
    
        <div id="preview" style="display: none">
            <h3>Загруженные пользователи:</h3>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>bio</th>
                        <th>link</th>
                        <th>address</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    
        @livewireScripts
    </body>
</html>

