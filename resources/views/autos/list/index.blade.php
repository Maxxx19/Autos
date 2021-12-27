<x-base-layout>
    <div class="card">
        <div class="card-body pt-6">
            <h2 class="card-title mb-4">Список викрадених авто</h2>
            <div class="table-responsive mt-4">
                <table class="table table-hover datatable dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Ім'я</th>
                            <th scope="col">Державний номер</th>
                            <th scope="col">Колір</th>
                            <th scope="col">VIN код</th>
                            <th scope="col">Марка</th>
                            <th scope="col">Модель</th>
                            <th scope="col">Рік випуску</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-base-layout>
<link href="{{ URL::asset('/demo1/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL::asset('/demo1/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $('.datatable').DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                text: 'Зберегти у Excel',
                extend: 'excelHtml5',
            }
        ],
        columnDefs: [{
            orderable: false,
            targets: -1
        }],
        processing: true,
        serverSide: true,
        pageLength: 10,
        retrieve: true,
        bLengthChange: true,
        responsive: true,
        ajax: {
            url: "{{route('show.autos')}}",
            method: "POST",
            data: {
                '_token': '{{ csrf_token() }}',
            },
        },
        order: [
            [1, "desc"],
            [0, "desc"]
        ],
        autoWidth: false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/ru.json"
        },
        columns: [{
                data: "id",
                "orderable": true,
                responsivePriority: 2
            },
            {
                data: "owner_name",
                "orderable": true,
                responsivePriority: 2
            },
            {
                data: "state_number",
                "orderable": true,
                responsivePriority: 2
            },
            {
                data: "color",
                "orderable": true,
                responsivePriority: 1
            },
            {
                data: "vin_code",
                "orderable": true,
                responsivePriority: 1
            },
            {
                data: "brand",
                "orderable": true,
                responsivePriority: 3,
                className: 'dt-center'
            },
            {
                data: "model",
                "orderable": true,
                responsivePriority: 1
            },
            {
                data: "year",
                "orderable": true,
                responsivePriority: 1
            },
        ],
    });
</script>