<x-base-layout>
    <div class="card">
        <div class="card-body pt-6">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ URL::to('autos/registration') }}"><i class="fas fa-car" style="font-size:36px;color:gold"></i></a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a class="btn btn-small btn-light-primary btn-active-primary" href="{{ URL::to('autos/registration/create') }}" style="margin-bottom: 5px;">Додати авто</a>
                </ul>
            </nav>

            <h1>Викрадені авто</h1>
            @isset($message)
            @if($message)
            <div class="alert alert-warning">{{ $message }}</div>
            @endif
            @endisset
            <div class="table-responsive mt-4">
                <table class="table table-hover datatable dt-responsive nowrap">
                    <thead>
                        <tr class="sorting text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <td>ID
                            </td>
                            <td>Ім'я
                            </td>
                            <td>Державний номер
                            </td>
                            <td>Колір</td>
                            <td>VIN код</td>
                            <td>Марка</td>
                            <td>
                                <center>Дії</center>
                            <td>Модель</td>
                            <td>Рік випуску</td>
                            </td>
                        </tr>
                    </thead>
                   
                    <tbody>
                        @foreach($autos as $key => $value)
                        <tr style="text-align: center; vertical-align: middle;">
                            <td class="p-2">{{ $value->id }}</td>
                            <td>{{ $value->owner_name }}</td>
                            <td>{{ $value->state_number }}</td>
                            <td>{{ $value->color }}</td>
                            <td>{{ $value->vin_code }}</td>
                            <td>{{ $value->brand }}</td>
                            <td>
                                <a class="btn btn-small btn-light-warning btn-active-warning" href="{{ URL::to('autos/registration/' . $value->id . '/edit') }}" style="margin-bottom: 5px;">Редагувати</a>
                                {{ Form::open(array('url' => 'autos/registration/' . $value->id, 'class' => 'pull-right')) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Видалити', array('class' => 'btn btn-small btn-light-danger btn-active-warning', 'style' => 'margin-bottom: 5px;')) }}
                                {{ Form::close() }}

                            </td>
                            <td>{{ $value->model }}</td>
                            <td>{{ $value->year }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>

</x-base-layout>
<style>
    .grid-flow {
        display: grid;
        grid-auto-flow: row;
        grid-template-columns: repeat(2, 1fr);
    }
</style>