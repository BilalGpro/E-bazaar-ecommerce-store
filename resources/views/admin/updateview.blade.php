

<!DOCTYPE html>
<html lang="en">
  <head>

    <base href="/public">

    @include('admin.css')

    <style>
    label{
        display:inline-block;
        width:200px;
    }
   </style>
  </head>
  <body>
    
     
        @include('admin.sidebar')

        @include('admin.navbar')
      
        <div class="container-fluid page-body-wrapper">
        <div class="container" align='center'>
        <h1 style="padding-top:25px; font-size:25px; color:white;">
            Update Products
        </h1>

        @if(session()->has('message'))
        <div class=' alert alert-success'>
        <button type="button" class='close' data-dismiss='alert'></button>

        {{session()->get('message')}}
        </div>
        @endif

        <form action="{{url('updateproduct',$data->id)}}" method="post" enctype='multipart/form-data'>

            @csrf

            <div style=padding:15px;>
                <label>Product title</label>
                <input style="color:black;" type="text" name='title' value="{{$data->title}}"Required=''>
            </div>

            <div style=padding:15px;>
                <label>Product price</label>
                <input style="color:black;"type="number" name='price'value="{{$data->price}}"Required=''>
            </div>

            <div style=padding:15px;>
                <label>Product description</label>
                <input style="color:black;"type="text" name='des' value="{{$data->description}} "Required=''>
            </div>

            <div style=padding:15px;>
                <label>Product quantity</label>
                <input style="color:black;"type="text" name='quantity' value="{{$data->quantity}} "Required=''>
            </div>

            <div style=padding:15px;>
                <label>Old image</label>
                <img height=100 width=100 src="/productimage/{{$data->image}}" alt="">
            </div>

            <div style=padding:15px;>
            <label>Change Image</label>
                <input type="file" name='file' >
            </div>
            
            <div style=padding:15px;>
               
                <input class='btn btn-success' type="submit">
            </div>
            </form>
        </div>
    </div>
        
        @include('admin.script')
        
  </body>
</html>