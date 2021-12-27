<x-base-layout>
    <div class="card">
        <div class="card-body pt-6">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                    <a class="navbar-brand p-6" href="{{ URL::to('autos/registration') }}"><i class="fas fa-car" style="font-size:36px;color:gold"></i></a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a class="btn btn-small btn-light-primary btn-active-primary" href="{{ URL::to('autos/registration') }}">Всі мої машини</a></li>
                </ul>
            </nav>

            <h1 class="p-6">Редагувати викрадену машину</h1>

            <!-- if there are creation errors, they will show here -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{ Form::model($auto, array('route' => array('registration.update', $auto->id), 'method' => 'PUT', 'id' => 'kt_docs_formvalidation_text')) }}

            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('owner_name', 'Ім\'я', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('owner_name', null, array('class' => 'form-control mb-2 mb-md-0')) }}
                </span>
            </div>
            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('state_number', 'Державний номер', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('state_number', null, array('class' => 'form-control mb-2 mb-md-0')) }}
                </span>
            </div>
            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('color', 'Колір', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('color', null, array('class' => 'form-control mb-2 mb-md-0')) }}
                </span>

            </div>
            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('vin_code', 'VIN код', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('vin_code', null, array('class' => 'form-control mb-2 mb-md-0', 'id' => 'vin_code')) }}
                </span>
            </div>
            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('brand', 'Марка', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('brand', null, array('class' => 'form-control mb-2 mb-md-0', 'id' => 'brand')) }}
                </span>

            </div>
            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('model', 'Модель', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('model', null, array('class' => 'form-control mb-2 mb-md-0', 'id' => 'model')) }}
                </span>
            </div>
            <div class="fv-row mb-12">
                <span>
                    {{ Form::label('year', 'Рік випуску', array('class' => 'required fw-bold fs-6 mb-2')) }}
                    {{ Form::text('year', null, array('class' => 'form-control mb-2 mb-md-0 disabled', 'year')) }}
                </span>
            </div>
            <!--begin::Actions-->
            <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                <span class="indicator-label">
                    Перевірка даних
                </span>
                <span class="indicator-progress">
                    Будь ласка, почекайте...<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            <!--end::Actions-->

            <button id="submit" type="submit" class="btn btn-primary" disabled>Створити
            </button>

            {{ Form::close() }}
        </div>
    </div>
</x-base-layout>
<script>
    // Define form element
    const form = document.getElementById('kt_docs_formvalidation_text');

    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    var validator = FormValidation.formValidation(
        form, {
            fields: {
                'owner_name': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть ім\'я власника авто'
                        },
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: 'Ім\'я повинно мати не менше 3 и не більше ніж 30 знаків'
                        },
                    }
                },
                'state_number': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть державний номер авто'
                        },
                        stringLength: {
                            min: 8,
                            max: 8,
                            message: 'Державний номер авто повинен містити  8 знаків'
                        },
                    }
                },
                'color': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть колір авто'
                        },
                        stringLength: {
                            min: 3,
                            max: 11,
                            message: 'Колір авто повинен містити  від 3 до 11 знаків'
                        },
                    }
                },
                'vin_code': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть VIN код авто'
                        },
                        stringLength: {
                            min: 17,
                            max: 17,
                            message: 'VIN код авто повинен містити 17 знаків'
                        },
                    }
                },
                'brand': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть вірний VIN код авто'
                        },
                    }
                },
                'model': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть вірний VIN код авто'
                        },
                    }
                },
                'year': {
                    validators: {
                        notEmpty: {
                            message: 'Внесіть вірний VIN код авто'
                        },
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );

    // Submit button handler
    const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
    submitButton.addEventListener('click', function(e) {
        // Prevent default button action
        e.preventDefault();

        // Validate form before submit
        if (validator) {
            validator.validate().then(function(status) {
                console.log('validated!');
                if (status == 'Valid') {
                    const CreateButton = document.getElementById('submit');
                    CreateButton.disabled = false;
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    setTimeout(function() {
                        // Remove loading indication
                        submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        submitButton.disabled = false;

                        // Show popup confirmation
                        Swal.fire({
                            text: "Дані занесено вірно!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, теперь можна зберігати авто!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });

                        //form.submit(); // Submit form
                    }, 2000);
                }
            });
        }
    });
    $(document).ready(function() {
        $("#brand").prop('disabled', true);
        $("#model").prop('disabled', true);
        $("#year").prop('disabled', true);
    });
    $("#vin_code").change(function() {
        var vin_code = $("#vin_code").val();
        console.log(vin_code.length);
        if (vin_code.length == 17) {
            $.ajax({
                url: "https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/" + vin_code + "?format=json",
                type: "get",
                dataType: "json",
                success: function(response) {
                    $("#brand").val(response['Results'][6]['Value']);
                    $("#model").val(response['Results'][8]['Value']);
                    $("#year").val(response['Results'][9]['Value']);
                }
            });
        }
        //console.log(vin_code);
    });
    $("#submit").click(function() {
        $("#brand").prop('disabled', false);
        $("#model").prop('disabled', false);
        $("#year").prop('disabled', false);
    });
</script>