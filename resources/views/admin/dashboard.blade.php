@extends('layouts.admin')

@section('content')
    <h1>Admin Dashboard</h1>

    <div class="row">
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0">{{ $usersCount }}</h3>
                    <p class="text-success ml-2 mb-0 font-weight-medium">{{ number_format($growthPercentage, 2) }}%</p>
                    <h6 class="text-muted font-weight-normal">User Growth</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-success ml-2 mb-0 font-weight-medium">{{ number_format($salesGrowthPercentage, 2) }}%</p>
                    <h6 class="text-muted font-weight-normal">Total Revenue</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0">{{ $productsCount }}</h3>
                    <p class="text-success ml-2 mb-0 font-weight-medium">{{ number_format($productGrowthPercentage, 2) }}%</p> <!-- Thêm tỷ lệ phần trăm tăng trưởng sản phẩm -->
                    <h6 class="text-muted font-weight-normal">Total Products</h6>
                </div>
            </div>
        </div>
    </div>

    <div id="user-growth-chart" style="width:100%; height:400px;"></div>
    <div id="sales-chart" style="width:100%; height:400px;"></div>
    <div id="product-stock-chart" style="width:100%; height:400px;"></div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        // Biểu đồ cho người dùng mới
        var userData = <?php echo json_encode($userData); ?>;
        Highcharts.chart('user-growth-chart', {
            title: {
                text: 'New User Growth'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Number of New Users'
                }
            },
            series: [{
                name: 'New Users',
                data: userData
            }]
        });

        // Biểu đồ cho doanh thu
        var salesData = <?php echo json_encode($salesData); ?>;
        Highcharts.chart('sales-chart', {
            title: {
                text: 'Monthly Sales'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Sales (in currency units)'
                }
            },
            series: [{
                name: 'Sales',
                data: salesData
            }]
        });

        // Biểu đồ cho tồn kho sản phẩm
        var productNames = <?php echo json_encode($productNames); ?>;
        var productStocks = <?php echo json_encode($productStocks); ?>;
        Highcharts.chart('product-stock-chart', {
            title: {
                text: 'Product Stock Levels'
            },
            xAxis: {
                categories: productNames
            },
            yAxis: {
                title: {
                    text: 'Stock Quantity'
                }
            },
            series: [{
                name: 'Stock Levels',
                data: productStocks
            }]
        });
    </script>
@endsection
