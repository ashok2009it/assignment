@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Stock Management</div>

                <div class="card-body">
                   

                    @if(session()->has('error'))
                        <div class="alert alert-success">
                            {{ session()->get('error') }}
                        </div>
                    @endif


                    <div class="container">
                        <h2 style="float: left; width:69%; ">Stock List</h2>
                        
                        <a href="{{ route('billing') }}">
                            <button type="button" class="btn btn-success">Billing Form</button>
                        </a>

                        <a href="{{ route('stock.create') }}">
                            <button type="button" class="btn btn-success">Add New</button>
                        </a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>PayMode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->item_name }}</td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>{{ $stock->price }}</td>
                                    <td>{{ $stock->payment_mode }}</td>
                                    <th>
                                       
                                    <form id="frm_del_{{$stock->id}}" action="{{route('stock.destroy',[$stock->id])}}" method="POST">
                                        <a class="del" data-id="{{$stock->id}}" href='#'>
                                            <i class="fas fa-trash"></i>
                                        </a>  
                                        @method('DELETE')
                                        @csrf        
                                    </form>

                                      

                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                        {{ $stocks->links() }}


                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_code')

<script>
$(document).ready(function(){

  $(".del").click(function(){
    if (!confirm("Are you sure to delete?")){
      return false;
    } else {
        var id = $(this).data('id');
        $("#frm_del_"+ id).submit();
    }
  });
});

</script>

@endsection
