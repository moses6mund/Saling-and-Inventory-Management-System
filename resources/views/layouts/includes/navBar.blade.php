@auth
<a href=""  data-toggle="modal" data-target="#staticBackdrop" class="btn btn-outline rounded-pill"><i class="fa fa-list"></i></a>
<a href="{{route('users.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-user"></i>Users</a>
<a href="{{route('products.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-box"></i>Products</a>
<a href="{{route('orders.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-laptop"></i>Cashire</a>
<a href="{{route('reports.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-file"></i>Reports</a>
<a href="" class="btn btn-outline rounded-pill"><i class="fa fa-money-bill"></i>Transactions</a>
<a href="{{route('suppliers.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-chart"></i>Suppliers</a>
<a href="{{route('sellings.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-user-group"></i>Selling</a>
<a href="" class="btn btn-outline rounded-pill"><i class="fa fa-truck"></i>Incomings</a>

@endauth
<style>
    .btn-outline{
        border-color: #008B8B;
        color: #008B8B;
    }

    .btn-outline:hover{
        background: #008B8B;
        color: #fff;
    }
</style>