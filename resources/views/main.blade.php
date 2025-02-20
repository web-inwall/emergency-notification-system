<x-main-layout>

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


</x-main-layout>