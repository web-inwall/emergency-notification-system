document.getElementById('file').addEventListener('change', function (event) {
    let file = event.target.files[0];
    let previewDiv = document.getElementById('preview');
    let userTableBody = document.querySelector("#userTable tbody");
    userTableBody.innerHTML = ""; // Очищаем таблицу перед новой загрузкой

    if (file) {
        let reader = new FileReader();

        reader.onload = function (e) {
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

function showAllTemplates() {
    document.getElementById('allTemplates').style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');
    var selectedTemplateMessage = document.querySelector('textarea[name="message"]');
    var hiddenUserMessage = document.querySelector('input[name="userMessage"]');

    form.addEventListener('submit', function () {
        hiddenUserMessage.value = selectedTemplateMessage.value;
    });
});

let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function deleteUsers() {
    fetch(deleteRoute, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(response => {
        // Обработка успешного удаления
        console.log('Пользователи успешно удалены');
    }).catch(error => {
        // Обработка ошибки удаления
        console.error('Произошла ошибка при удалении пользователей');
    });
}