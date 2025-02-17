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
          
        
        @livewire('show-all-templates')
    
        <div id="preview" style="display: none">
            <h3>Получатели из шаблона:</h3>
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

    <script>
        function deleteUsers() {
            fetch('{{ route('home.delete') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                // Обработка успешного удаления
                console.log('Пользователи успешно удалены');
            }).catch(error => {
                // Обработка ошибки удаления
                console.error('Произошла ошибка при удалении пользователей');
            });
        }
    </script>

    
        @livewireScripts
    </body>
</html>

