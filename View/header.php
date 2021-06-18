<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <title>Project</title>
    <style>
    .main{
        margin: auto;
        width : 100%;
        background: rgb(185, 182, 182);
        border-radius: 5px;
    }

    .nav{
        padding : 5px;
    }
    .nav-item{
        margin-left: 10px;
    }
    .dropdown-item{
        background-color: rgb(185, 182, 182);
    }
    
    </style>
</head>

<body>
    <div class="main mt-5">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active btn btn-success" aria-current="page" href="index.php">Manu</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle btn-primary" data-bs-toggle="dropdown" href="" role="button"
                    aria-expanded="false">Modules</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?c=category&a=grid">Category</a></li>
                    <li><a class="dropdown-item" href="?c=customer&a=grid">Customer</a></li>
                    <li><a class="dropdown-item" href="?c=Product&a=grid">Product</a></li>
                    <li><a class="dropdown-item" href="?c=payment&a=grid">Payment</a></li>
                    <li><a class="dropdown-item" href="?c=shipping&a=grid">Shipping</a></li>
                </ul>
            </li>
        </ul>
    </div>
</body>

</html>