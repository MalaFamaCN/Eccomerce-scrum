@extends('adminlte::page')

@section('title', 'Inicio Ecore Admin')

@section('plugins.Chartjs', true)



@section('content')
    {{-- Stock --}}

<hr style="margin-top: -1px">

    <div class="card">
        <div class="container-fluid pt-2">
            <div class="row">

                <!-- BAR CHART -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Stock de Productos por Categoria</strong>
                                <form action="{{ route('exportar-graficos-pdf') }}" method="POST" target="_blank">
                                    @csrf
                                    @method('POST')

                                    <input id="config_barchart" name="config_grafics" type="text" hidden>

                                    <button id="button_form_barchart" type="submit" class="btn btn-danger"
                                        title="Imprimir BarChart PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- PIE CHART -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Stock de Productos por Categoria</strong>
                                <form action="{{ route('exportar-graficos-pdf') }}" method="POST" target="_blank">
                                    @csrf
                                    @method('POST')

                                    <input id="config_piechart" name="config_grafics" type="text" hidden>

                                    <button id="button_form_piechart" type="submit"
                                        class="btn btn-danger border border-white" title="Imprimir PieChart PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body h-50">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
    {{-- Pedidos Pagadas/Canceladas --}}
    <div class="card">

        <div class="container-fluid pt-2">
            <div class="row">
                <!-- Doughnut CHART -->
                <div class="col-lg-12">
                    <div class="card ">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Pedidos Pagados/Cancelados/Esperando Pago</strong>
                                <form action="{{ route('exportar-graficos-pdf') }}" method="POST" target="_blank">
                                    @csrf
                                    @method('POST')

                                    <input id="config_doughnutchart" name="config_grafics" type="text" hidden>

                                    <button id="button_form_doughnutchart" type="submit" class="btn btn-danger"
                                        title="Imprimir DoughnutChart PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
    {{-- Pedidos  Enviados/En Preparacion --}}
    <div class="card">
        <div class="container-fluid pt-2">
            <div class="row">
                <!-- Doughnut CHART -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Pedidos Enviados/En Preparacion/Pendientes</strong>
                                <form action="{{ route('exportar-graficos-pdf') }}" method="POST" target="_blank">
                                    @csrf
                                    @method('POST')

                                    <input id="config_doughnutchartalmacen" name="config_grafics" type="text" hidden>

                                    <button id="button_form_doughnutchartalmacen" type="submit" class="btn btn-danger"
                                        title="Imprimir DoughnutChartAlmacen PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="doughnutChartAlmacen"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--  --}}


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            const barChart = document.getElementById('barChart').getContext('2d');
            const pieChart = document.getElementById('pieChart').getContext('2d');

            const configDataBarChart = $('#config_barchart');
            const configDataPieChart = $('#config_piechart')

            // Peticion AJAX para extraer datos de la BD y graficar
            $.get("{{ route('graficos-productos') }}", function(response) {
                    response = JSON.parse(response);

                    // Si hay éxito en la petición
                    if (response.success) {
                        let labels = response.data[0];
                        let count = response.data[1];
                        // Para Graficar el Diagrama de Barras (BarChart)
                        graficar(barChart, 'horizontalBar', labels, count,
                            'Cantidad de Productos por Categoria',
                            configDataBarChart);

                        // Para Graficar el Diagrama de Torta (PieChart)
                        graficar(pieChart, 'pie', labels, count, 'Cantidad de Productos por Categoria',
                            configDataPieChart);

                    } else {
                        console.log(response.message);
                    }
                })
                .fail(function(error) {
                    console.log(error.statusText, error.status);
                });

            // Grafica cualquier gráfico estadístico de ChartJs
            function graficar(context, typeGraphic, label, count, title, inputData) {
                // Configuración de ChartJs
                let configChart = `{
                    "type": "${typeGraphic}",
                    "data": {
                        "labels": ${JSON.stringify(label)},
                        "datasets": [{
                            "label": "${title}",
                            "data": ${JSON.stringify(count)},
                            "backgroundColor": [
                                "rgba(255, 0, 255, 0.2)",
                                "rgba(0, 128, 255, 0.2)",
                                "rgba(0, 255, 0, 0.2)",
                                "rgba(255, 165, 0, 0.2)",
                                "rgba(255, 255, 0, 0.2)",
                                "rgba(128, 0, 128, 0.2)",
                                "rgba(0, 255, 255, 0.2)",
                                "rgba(255, 69, 0, 0.2)",
                                "rgba(128, 128, 128, 0.2)"
                            ],
                            "borderColor": [
                                "rgba(255, 0, 255, 1)",
                                "rgba(0, 128, 255, 1)",
                                "rgba(0, 255, 0, 1)",
                                "rgba(255, 165, 0, 1)",
                                "rgba(255, 255, 0, 1)",
                                "rgba(128, 0, 128, 1)",
                                "rgba(0, 255, 255, 1)",
                                "rgba(255, 69, 0, 1)",
                                "rgba(128, 128, 128, 1)"
                            ],
                            "borderWidth": 1
                        }]
                    }`;

                // Si es alguno de estos graficos, iniciarán en el punto 0
                if (typeGraphic === 'bar' || typeGraphic === 'horizontalBar') {
                    configChart += `
                    ,"options": {
                        "scales": {
                            "xAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }],
                            "yAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }]
                        }
                    }
                    `;
                }
                configChart += '}'; // Cierre del JSON

                inputData.val(configChart);

                // Crear el gráfico
                let myChart = new Chart(context, JSON.parse(configChart));
            }
        });
    </script>

    {{--  --}}
    {{--  --}}
    {{--  --}}

    <script>
        $(document).ready(function() {
            const doughnutChart = document.getElementById('doughnutChart').getContext('2d');


            const configDataDoughnutChart = $('#config_doughnutchart')

            // Peticion AJAX para extraer datos de la BD y graficar
            $.get("{{ route('graficos-productos') }}", function(response) {
                    response = JSON.parse(response);

                    // Si hay éxito en la petición
                    if (response.success) {

                        let estados = response.data[2];
                        let totalPedidos = response.data[3];


                        // Para Graficar el Diagrama de Torta (DoughnutChart)
                        graficar(doughnutChart, 'doughnut', totalPedidos, estados,
                            'Cantidad de Pedidos Pagados/Cancelados/Esperando Pago',
                            configDataDoughnutChart);


                    } else {
                        console.log(response.message);
                    }
                })
                .fail(function(error) {
                    console.log(error.statusText, error.status);
                });

            // Grafica cualquier gráfico estadístico de ChartJs
            function graficar(context, typeGraphic, estado, totalPedido, title, inputData) {
                // Configuración de ChartJs
                let configChart = `{
                    "type": "${typeGraphic}",
                    "data": {
                        "labels": ${JSON.stringify(estado)},
                        "datasets": [{
                            "label": "${title}",
                            "data": ${JSON.stringify(totalPedido)},
                            "backgroundColor": [
                                "rgba(0, 255, 0, 0.2)",
                                "rgba(255, 0, 0, 0.2)",
                                "rgba(0, 0, 255, 0.2)"
                            
                            ],
                            "borderColor": [
                                "rgba(0, 255, 0, 1)",
                                "rgba(255, 0, 0, 1)",
                                "rgba(0, 0, 255, 1)"

                            ],
                            "borderWidth": 1
                        }]
                    }`;

                // Si es alguno de estos graficos, iniciarán en el punto 0
                if (typeGraphic === 'bar' || typeGraphic === 'horizontalBar') {
                                    configChart += `
                    ,"options": {
                        "scales": {
                            "xAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }],
                            "yAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }]
                        }
                    }
                    `;
                }
                configChart += '}'; // Cierre del JSON

                inputData.val(configChart);

                // Crear el gráfico
                let myChart = new Chart(context, JSON.parse(configChart));
            }
        });
    </script>

    
    {{--  --}}
    {{--  --}}
    {{--  --}}

    <script>
        $(document).ready(function() {
            const doughnutChartAlmacen = document.getElementById('doughnutChartAlmacen').getContext('2d');


            const configDataDoughnutChartAlmacen = $('#config_doughnutchartalmacen')

            // Peticion AJAX para extraer datos de la BD y graficar
            $.get("{{ route('graficos-productos') }}", function(response) {
                    response = JSON.parse(response);

                    // Si hay éxito en la petición
                    if (response.success) {

                        let estadosAlmacen = response.data[4];
                        let totalPedidosAlmacen = response.data[5];


                        // Para Graficar el Diagrama de Torta (DoughnutChart)
                        graficar(doughnutChartAlmacen, 'doughnut', totalPedidosAlmacen, estadosAlmacen,
                            'Cantidad de Pedidos Pedidos Enviados/En Preparacion',
                            configDataDoughnutChartAlmacen);


                    } else {
                        console.log(response.message);
                    }
                })
                .fail(function(error) {
                    console.log(error.statusText, error.status);
                });

            // Grafica cualquier gráfico estadístico de ChartJs
            function graficar(context, typeGraphic,totalPedidoAlmacen ,estadoAlmacen , title, inputData) {
                // Configuración de ChartJs
                let configChart = `{
                    "type": "${typeGraphic}",
                    "data": {
                        "labels": ${JSON.stringify(estadoAlmacen)},
                        "datasets": [{
                            "label": "${title}",
                            "data": ${JSON.stringify(totalPedidoAlmacen)},
                            "backgroundColor": [
                                "rgba(0, 255, 0, 0.2)",
                                "rgba(255, 0, 0, 0.2)",
                                "rgba(0, 0, 255, 0.2)"
                            
                            ],
                            "borderColor": [
                                "rgba(0, 255, 0, 1)",
                                "rgba(255, 0, 0, 1)",
                                "rgba(0, 0, 255, 1)"

                                
                            ],
                            "borderWidth": 1
                        }]
                    }`;

                // Si es alguno de estos graficos, iniciarán en el punto 0
                if (typeGraphic === 'bar' || typeGraphic === 'horizontalBar') {
                                    configChart += `
                    ,"options": {
                        "scales": {
                            "xAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }],
                            "yAxes": [{
                                "ticks": {
                                    "beginAtZero": true
                                }
                            }]
                        }
                    }
                    `;
                }
                configChart += '}'; // Cierre del JSON

                inputData.val(configChart);

                // Crear el gráfico
                let myChart = new Chart(context, JSON.parse(configChart));
            }
        });
    </script>


@stop
