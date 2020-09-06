@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billing Form</div>


                @if(session()->has('error'))
                    <div class="alert alert-warning">
                        {{ session()->get('error') }}
                    </div>
                @endif


                <div class="card-body">
                        <form method="POST" action="{{ route('billingStore') }}">
                            @csrf
                            @if (isset($stock))
                                {{method_field('PUT')}}
                            @else
                                {{method_field('POST')}}
                            @endif

                            <div class="form-group">
                                <label for="stock">Select Stock</label>
                                <select name="stock" id="stock" class="form-control">
                                    @foreach($stocks as $stockKey=>$stockVal)
                                        <option value="{{ $stockKey }}">{{ $stockVal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Selling Price</label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="price">DateOfSale</label>
                                <input type="date" name="sale_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Billed To Name</label>
                                <input type="text" name="cust_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Billed To Email</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                           
                        


                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>Send Invoice    
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
