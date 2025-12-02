<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Pharmacy Management System" />
    <meta name="keywords" content="pharmacy, management, system" />
    <meta name="author" content="Pharmacy Management" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Pharmacy Store And Selling Management System</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/file.svg" />
    <link rel="stylesheet" href="assets/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3">
            <div class="text-center mb-4">
              <img src="assets/img/pct.jpg" alt="Logo" class="img-fluid" style="max-height: 60px;">
            </div>
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <i class="fas fa-tachometer-alt mr-2"></i>Cashiere Dashboard
                </a>
              </li>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('orders.index')}}">
                  <i class="fas fa-clipboard-list mr-2"></i> Orders
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('reports.index')}}">
                  <i class="fas fa-chart-bar mr-2"></i> Reports
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <!-- Header -->
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"> Pharmacy Store And Selling Management System</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
              </div>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle"></i> {{Auth::user()->name}}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Profile</a>
                  @if(Route::has('login'))
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Charts and Tables -->
          <div class="row">
            <div class="col-lg-7 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Monthly Sales</h6>
                </div>
                <div class="card-body">
                  <div class="chart-container" style="position: relative; height:400px;">
                    <canvas id="monthlySalesChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Recently Added Products</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Product Actions:</div>
                      <a class="dropdown-item" href="{{route('products.index')}}">Product List</a>
                      <a class="dropdown-item" href="{{route('products.create')}}">Add Product</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Products</th>
                          <th>Price (Tsh)</th>
                          <th>Stock</th>
                          <th>Added Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($recentProducts as $index => $product)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="mr-2">
                                @if($product->image)
                                  <img src="{{ asset('storage/' . $product->image) }}" 
                                       alt="{{ $product->product_name }}"
                                       class="rounded-circle"
                                       width="40" height="40">
                                @else
                                  <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                       style="width: 40px; height: 40px;">
                                    <i class="fas fa-capsules"></i>
                                  </div>
                                @endif
                              </div>
                              <div>
                                <div class="font-weight-bold">{{ $product->product_name }}</div>
                                <small class="text-muted">{{ $product->brand }}</small>
                              </div>
                            </div>
                          </td>
                          <td class="text-right">Tsh {{ number_format($product->price, 2) }}</td>
                          <td>
                            @if($product->quantity <= $product->alert_stock)
                              <span class="badge badge-danger">Low Stock ({{ $product->quantity }})</span>
                            @elseif($product->quantity <= 100)
                              <span class="badge badge-warning">Medium ({{ $product->quantity }})</span>
                            @else
                              <span class="badge badge-success">In Stock ({{ $product->quantity }})</span>
                            @endif
                          </td>
                          <td>
                            <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                          </td>
                        </tr>
                        @empty
                          <tr>
                            <td colspan="5" class="text-center py-4">
                              <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No recent products found</h6>
                              </div>
                            </td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>

    <script>
      $(document).ready(function() {
        // Initialize DataTables
        $('.table').DataTable({
          "pageLength": 5,
          "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
        });
        
        // Chart.js
        const labels = @json($months);
        const data = {
          labels: labels,
          datasets: [{
            label: 'Monthly Sales',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            data: @json($sales),
          }]
        };
        
        const config = {
          type: 'line',
          data,
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top',
              },
              tooltip: {
                mode: 'index',
                intersect: false
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        };
      
        var ctx = document.getElementById('monthlySalesChart').getContext('2d');
        var monthlySalesChart = new Chart(ctx, config);
      });
    </script>
  </body>
</html>
