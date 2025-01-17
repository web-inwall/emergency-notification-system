<!DOCTYPE html>

<html>
<head>
    <title>Главная</title>
</head>
<body>

    {{-- <h1>Список пользователей</h1>
    
    <select>
        <option value="">Список всех пользователей</option> 
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->bio }}</option>
        @endforeach
    </select> --}}

    {{-- <h2>Загрузка CSV</h2>
    <form method="POST" action="{{ route('uploadFile') }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="custom_file_name" placeholder="Введите имя файла" required>
        <input type="file" name="file" id="file" required>
        <button type="submit">Загрузить</button>
    </form> --}}
    

    {{-- <h2>Выбор шаблона</h2>
    <form action="{{ route('selectTemplate') }}" method="GET">
        @csrf
        <select name="template">
            <option value="template1">Шаблон 1</option>
            <option value="template2">Шаблон 2</option>
        </select>
        <button type="submit">Выбрать</button>
    </form> --}}

    <h2>Внесите получателей и введите сообщение</h2>
    <form action="{{ route('uploadFile') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="custom_file_name" placeholder="Введите имя файла" required>
        <input type="file" name="file" id="file" required>

        <textarea name="message"></textarea>
        <button type="submit">Отправить</button>
    </form>

</body>
</html>