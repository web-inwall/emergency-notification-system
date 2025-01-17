<!DOCTYPE html>

<html>
<head>
    <title>Главная</title>
    {{-- <link rel="stylesheet" href="../css/app.css"> --}}
</head>
<body>

    <h2>Внесите получателей и введите сообщение</h2>
    <form id="uploadForm" action="{{ route('importUsersAndNotify') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <input type="file" name="file" id="file" required>
        <input type="text" name="template_name" placeholder="Имя шаблона отправки" required>
        
        <textarea name="message" placeholder="Введите сообщение" required></textarea>
        <button type="submit">Отправить</button>
    </form>


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

    <script>
        document.getElementById('file').addEventListener('change', function(event) {
            let file = event.target.files[0];
            let previewDiv = document.getElementById('preview');
            let userTableBody = document.querySelector("#userTable tbody");
            userTableBody.innerHTML = ""; // Очищаем таблицу перед новой загрузкой
        
            if (file) {
                let reader = new FileReader();
        
                reader.onload = function(e) {
                    let content = e.target.result;
                    displayCSVContent(content);
                    previewDiv.style.display = 'block'; // Показываем блок предварительного просмотра
                };
        
                reader.readAsText(file);
            } else {
                previewDiv.style.display = 'none'; // Скрываем блок предварительного просмотра, если файл не выбран
            }
        });
        
        function displayCSVContent(content) {
            let rows = content.split("\n");
            let tableBody = document.querySelector("#userTable tbody");
            tableBody.innerHTML = ""; // Очищаем таблицу перед новой загрузкой
        
            rows.forEach((row, index) => {
                if (row.trim() !== "") { // Пропускаем заголовок и пустые строки
                    let columns = row.split(",");
                    let tableRow = document.createElement("tr");
        
                    let bioCell = document.createElement("td");
                    bioCell.textContent = columns[0]; // Первое значение — имя
                    tableRow.appendChild(bioCell);
        
                    let linkCell = document.createElement("td");
                    linkCell.textContent = columns[1]; // Второе значение — email
                    tableRow.appendChild(linkCell);
        
                    let adressCell = document.createElement("td");
                    adressCell.textContent = columns[2]; // Второе значение — email
                    tableRow.appendChild(adressCell);
        
                    tableBody.appendChild(tableRow);
                }
            });
        }
        </script>
        </body>
</html>