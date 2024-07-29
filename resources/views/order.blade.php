<?
    use Illuminate\Support\Facades\Auth ;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orders</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-white shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret">
        <div class="container">
            <a class="navbar-brand" href="#">
               <strong>Orders</strong>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hello, {{Auth::user()->name}}</a>
                        <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                            <li>
                                <a class="dropdown-item" href="{{route('account.logout')}}">Logout</a>
                            </li>
                            <li>
                                <a href="{{route('account.orders')}}" class="dropdown-item">Orders</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="card border-0 shadow my-5">
            @if (Session::has('success'))
                <div class="col-md-10">
                    {{Session::get('success')}}
                </div>
            @endif
            <div class="card-header bg-light">
                <h3 class="h3 pt-2">Orders</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>ID</td>
                        <td>Product Name</td>
                        <td>Price</td>
                        <td>Item quantity</td>
                        <td>Total price</td>
                    </tr>
                    @if($orders->count())
                        @foreach ($orders as $order)

                            @if($order->username_id == Auth::id())
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->product_name}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->item_count}}</td>
                                <td>{{$order->total_price}}</td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal-{{$order->id}}">
                                        Cancel Order
                                    </button>
                                    <div class="modal fade" id="cancelModal-{{$order->id}}" tabindex="-1" aria-labelledby="cancelModalLabel-{{$order->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cancelModalLabel-{{$order->id}}">Order Cancel</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('account.cancel', $order->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="cancel" class="form-label">Are you sure?</label>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-danger">Yes</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endif

                        @endforeach
                    @endif
                </table>
            </div>
-        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
