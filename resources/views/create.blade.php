@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Stock Management</div>


                @if(count($errors))
                    <div class="form-group">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="card-body">
                        <form method="POST" action="{{isset($stock)?route('stock.update', $stock):route('stock.store')}}">
                            @csrf
                            @if (isset($stock))
                                {{method_field('PUT')}}
                            @else
                                {{method_field('POST')}}
                            @endif
                            
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input type="text" name="item_name" value="{{isset($stock)?$stock->item_name:old('item_name')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Item Quantity</label>
                                <input type="number" name="quantity" value="{{isset($stock)?$stock->quantity:old('quantity')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" step="0.01" name="price" value="{{isset($stock)?$stock->price:old('price')}}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="payment_mode">Payment Mode</label>
                                <select name="payment_mode" class="form-control">
                                    <option value="Cash">Cash</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>




                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>{{isset($stock)?'Edit':'Create'}}
                            </button>
                            
                        </form>
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
