@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- SECTION: STATS -->
    <div class="row mb-5">
        <div class="col-6 col-md-3">
            <div class="card shadow py-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h1 class="ml-4 font-weight-bolder"> {{ $order_count}}</h1>
                        <h6 class="ml-4 font-weight-bold text-secondary"> {{ __('Orders') }} </h6>
                    </div>
                    <div class="col-12 col-md-6">
                        <i class="fas fa-truck text-primary ml-4 mt-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow py-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h1 class="ml-4 font-weight-bolder"> {{ $customer_count }} </h1>
                        <h6 class="ml-4 font-weight-bold text-secondary"> {{ __('Clients') }}</h6>
                    </div>
                    <div class="col-12 col-md-6">
                        <i class="fas fa-users text-success ml-4 mt-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow py-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h1 class="ml-4 font-weight-bolder"> {{ $staff_count }} </h1>
                        <h6 class="ml-4 font-weight-bold text-secondary"> {{ __('Staff') }} </h6>
                    </div>
                    <div class="col-12 col-md-6">
                        <i class="fas fa-users text-success ml-4 mt-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow py-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h1 class="ml-4 font-weight-bolder"> {{ $product_count }} </h1>
                        <h6 class="ml-4 font-weight-bold text-secondary"> {{ __('Products') }} </h6>
                    </div>
                    <div class="col-12 col-md-6">
                        <i class="fas fa-truck-loading text-danger ml-4 mt-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: TABLES & CHARTS -->
    <div class="row mb-5">
        <!-- Pie chart -->
        <div class="col-12 col-md-6">
            <div class="card shadow py-3 px-3 mb-3">
                <div id="donut_chart" class="mb-3"></div>
                <div id="pie_chart"></div>
            </div>
        </div>
        <!-- Tables -->
        <div class="col-12 col-md-6">
            <div class="card shadow py-3 px-3 mb-3">
                <h5 class="card-title font-weight-bolder mb-4"> Top 3 product orders by total cost </h5>
                <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('#') }}</th>
                            <th scope="col">{{ __('Product') }}</th>
                            <th scope="col">{{ __('Cost') }}</th>
                            <th scope="col">{{ __('Product line') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no =1; @endphp
                        @foreach($top_product_orders as $top_product_order)
                        <tr>
                            <td> @php echo($no++) @endphp </td>
                            <td> {{ $top_product_order->product->productName }}</td>
                            <td> {{ $top_product_order->projected_revenue }}</td>
                            <td> {{ $top_product_order->product->productLine }} </td>   
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="card shadow py-3 px-3">
                <h5 class="card-title font-weight-bolder mb-4"> Top 3 paying customers </h5>
                <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('#') }}</th>
                            <th scope="col">{{ __('Customer') }}</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('Sales rep') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no =1; @endphp
                        @foreach($top_paying_clients as $top_paying_client)
                        <tr>
                            <td> @php echo($no++) @endphp </td>
                            <td> {{ $top_paying_client->customer->customerName }}</td>
                            <td> {{ $top_paying_client->amount }}</td>
                            <td> {{ $top_paying_client->customer->employee->lastName." ".$top_paying_client->customer->employee->firstName }} </td>   
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow py-3 px-3">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div id="bar_chart"></div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div id="line_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    var donut_chart = echarts.init(document.getElementById('donut_chart'));
    var pie_chart = echarts.init(document.getElementById('pie_chart'));
    var bar_chart = echarts.init(document.getElementById('bar_chart'));
    var line_chart = echarts.init(document.getElementById('line_chart'));

    //Donut chart configurations
    donut_chart.setOption({
        title: {
            text: 'Percentage orders by status',
            left: 'center',
            textStyle:{
                color: 'rgba(0,0,0,0.88)'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        textStyle: {
            fontFamily: 'Poppins, sans-serif',
        },
        legend: {
            orient: 'vertical',
            left: 'left',
        },
        series: [
            {
                name: 'Order Status',
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: '16',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: [
                    {value: {{$order_status[0]['status_count']}}, name: 'Disputed'},
                    {value: {{$order_status[1]['status_count']}}, name: 'Resolved'},
                    {value: {{$order_status[2]['status_count']}}, name: 'On Hold'},
                    {value: {{$order_status[3]['status_count']}}, name: 'In Process'},
                    {value: {{$order_status[4]['status_count']}}, name: 'Cancelled'},
                    {value: {{$order_status[5]['status_count']}}, name: 'Shipped'}
                ]
            }
        ]
    });

    //Pie chart configurations
    pie_chart.setOption({
        title: {
            text: 'Projected revenue per product line',
            left: 'center',
            textStyle:{
                color: 'rgba(0,0,0,0.88)'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        textStyle: {
            fontFamily: 'Poppins, sans-serif',
        },
        legend: {
            top: '10%',
            left: 'center'
        },
        series: [
            {
                name: 'Projected Revenue',
                type: 'pie',
                radius: '50%',
                top:'13%',
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                },
                data: [
                    {value: {{$productLine_revenue[0]['projected_revenue']}}, name: 'Classic Cars'},
                    {value: {{$productLine_revenue[1]['projected_revenue']}}, name: 'Motorcycles'},
                    {value: {{$productLine_revenue[2]['projected_revenue']}}, name: 'Planes'},
                    {value: {{$productLine_revenue[3]['projected_revenue']}}, name: 'Ships'},
                    {value: {{$productLine_revenue[4]['projected_revenue']}}, name: 'Trains'},
                    {value: {{$productLine_revenue[5]['projected_revenue']}}, name: 'Trucks and Buses'},
                    {value: {{$productLine_revenue[6]['projected_revenue']}}, name: 'Vintage Cars'}
                ]
            }
        ]
    });

    //Bar chart configurations
    bar_chart.setOption({
        title: {
            text: 'Yearly revenues 2003 - 2005',
            left: 'left',
            textStyle:{
                color: 'rgba(0,0,0,0.88)'
            }
        },
        textStyle: {
            fontFamily: 'Poppins, sans-serif',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {            
                type: 'shadow'        
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                name: 'Year',
                nameLocation: 'center',
                nameTextStyle:{
                    lineHeight:'10'
                },
                nameGap: '20',
                data: [{{ $payment_per_year[0]['year'] }}, {{ $payment_per_year[1]['year'] }} , {{ $payment_per_year[2]['year'] }}],
                axisTick: {
                    alignWithLabel: true
                },
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: 'Revenue'
            }
        ],
        series: [
            {
                name: 'Yearly revenue',
                type: 'bar',
                barWidth: '60%',
                data: [{{ $payment_per_year[0]['yearly_payments'] }}, {{ $payment_per_year[1]['yearly_payments'] }}, {{ $payment_per_year[2]['yearly_payments'] }}]
            }
        ]
    });

    //Line chart configurations
    line_chart.setOption({
        title: {
            text: 'Yearly revenue trends 2003 - 2005',
            left: 'left',
            textStyle:{
                color: 'rgba(0,0,0,0.88)'
            }
        },
        textStyle: {
            fontFamily: 'Poppins, sans-serif',
        },
        xAxis: {
            type: 'category',
            name: 'Year',
            nameLocation: 'center',
            nameTextStyle:{
                lineHeight:'30'
            },
            data: [{{ $payment_per_year[0]['year'] }}, {{ $payment_per_year[1]['year'] }} , {{ $payment_per_year[2]['year'] }}]
        },
        yAxis: {
            type: 'value',
            name: 'Revenue',
        },
        series: [{
            data: [{{ $payment_per_year[0]['yearly_payments'] }}, {{ $payment_per_year[1]['yearly_payments'] }}, {{ $payment_per_year[2]['yearly_payments'] }}],
            type: 'line'
        }]
    });
</script>
@endsection
