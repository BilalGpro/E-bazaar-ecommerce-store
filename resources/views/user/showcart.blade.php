<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <title>ADD CART</title>

   
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">







    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/owl.css">

  </head>

  <body>

   
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    

    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="{{url('/')}}"><h2>E <em>BAZAAR</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul align="center" class="navbar-nav ml-auto">
              <li class="nav-item">
              
                <a class="nav-link" href="{{url('/')}}">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li> 
              <li class="nav-item">
                <a class="nav-link" href="{{url('aboutus')}}">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
              </li>
              <li class="nav-item">
              @if (Route::has('login'))
        
                    @auth 
                    <li class="nav-item active">
                <a class="nav-link" href="{{url('showcart')}}"><i class="fas fa-shopping-cart"></i>
                 Cart [ {{$count}} ]</a>
              </li>
                    <x-app-layout>
 
                        </x-app-layout>
                    @else
                        <li><a class="nav-link" href="{{ route('login') }}" >Log in</a></li>

                        @if (Route::has('register'))
                            <li><a  class="nav-link" href="{{ route('register') }}" >Register</a></li>
                        @endif
                    @endauth
    
            @endif
              </li>
    
            
            </ul>
          </div>
        </div>
      </nav>

      @if(session()->has('message'))
        <div class=' alert alert-success'>
        <button type="button" class='close' data-dismiss='alert'>x</button>

        {{session()->get('message')}}
        </div>
        @endif

    </header>
    <div style="padding:100px;"align="center">
    <table>
        <tr style="background-color:black; color:white;">
            <td style="padding:10px; font-size: 20px;">Product Name</td>
            <td style="padding:10px; font-size: 20px;">Quantity</td>
            <td style="padding:10px; font-size: 20px;">Price</td>
            <td style="padding:10px; font-size: 20px;">Action</td>
        </tr>

    <form action="{{url('order')}}" method="POST">
      @csrf
      <?php $totalprice=0; ?>
    @foreach($cart as $carts)
        <tr style="background-color:black; color:white;">
            <td style="padding:10px;"> <input type="text" name="productname[]" value="{{$carts->product_title}}" hidden="">
            {{$carts->product_title}}</td>
            <td style="padding:10px;"> <input type="text" name="quantity[]" value="{{$carts->quantity}}" hidden="">
            {{$carts->quantity}}</td>
            <td style="padding:10px;"> <input type="text" name="price[]" value="{{$carts->price}}" hidden="">
            {{$carts->price * $carts->quantity}}</td>
            <td style="padding:10px;"><a class="btn btn-danger" href="{{url('delete',$carts->id)}}"> Delete </a></td>
        </tr>

        <?php $totalprice=$totalprice + $carts->price * $carts->quantity; ?>
    @endforeach

    </table>
      <div>
        <h1 style="padding:20px; font: size 30px;">Total Price:  {{$totalprice}}PKR</h1>
      </div>
      <button style="margin:10px;"class="btn btn-success">Cash on delivery</button>
      
    </form>
    <a href="{{url('stripe',$totalprice)}}" class="btn btn-success">Pay using card</a>
    </div>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>


    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0;
      function clearField(t){                   
      if(! cleared[t.id]){                      
          cleared[t.id] = 1;  
          t.value='';         
          t.style.color='#fff';
          }
      }
    </script>


  </body>

</html>
