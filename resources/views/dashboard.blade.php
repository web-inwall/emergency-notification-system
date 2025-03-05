<x-main-layout>

    <h2 class="title_hidden">Результат отправки нотификации:</h2>
        <table id="user-table">
                
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Способ отправки</th>
                        <th>Получатель</th>
                        <th>Статус отправки</th>
                    </tr>
                </thead>

                <tbody class="td-text-center">

                    @if (!empty($resultProcessing['success']))
                        
                        @foreach($resultProcessing['success'] as $user)
                            <tr>
                                <td>{{ $user['bio'] }}</td>
                                <td>{{ $user['link'] }}</td>
                                <td>{{ $user['address'] }}</td>
                                <td class="td-green"> &#x2714; </td>
                            </tr>
                        @endforeach
                        
                    @endif
                    
                    
                    @if (!empty($resultProcessing['fail']))
                        
                        @foreach($resultProcessing['fail'] as $user)
                            <tr>
                                <td>{{ $user['bio'] }}</td>
                                <td>{{ $user['link'] }}</td>
                                <td>{{ $user['address'] }}</td>
                                <td class="td-red"> &#x2716;</td>
                            </tr>
                        @endforeach
                        
                    @endif
                                
            </tbody>
        </table>

</x-main-layout>