<x-main-layout>

    @livewire('show-all-templates')

    <div id="preview" style="display: none">
        <h3>Получатели из шаблона:</h3>
        <table id="user-table">
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Способ отправки</th>
                        <th>Получатель</th>
                    </tr>
                </thead>
            <tbody></tbody>
        </table>
    </div>

    <script>
        const deleteRoute = '{{ route('home.delete') }}';
    </script>
    <script src="{{ asset('js/main.js') }}"></script>

    @livewireScripts
</x-main-layout>