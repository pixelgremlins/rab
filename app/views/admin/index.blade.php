@extends('layouts.master')
@section('head')
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
   <script>
  $(function() {
    $( "#datepicker2" ).datepicker();
  });
  </script>
@stop
@section('content')



<h3>Dashboard</h3>
 <div class="row">
 <div style="padding-left:30px;">
   Total Users: {{{ $totalUsers }}} | Online:  {{{ $onlineUsers }}} | Guests:  {{{ $onlineGuests }}}
</div>
  </div>
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#orders" data-toggle="tab">Orders</a></li>
  <li><a href="#users" data-toggle="tab">Users</a></li>

</ul>
<div class="tab-content">
<div class="tab-pane active" id="orders">
<div class="col-md-1"></div>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
      <th>User</th>
      <th>Items</th>
      <th>Tracking Number</th>
      <th>Total</th>
      <th>Date Received / Date Paid</th>

      <th>Comments</th>
      <th>Date Created</th>
    </tr>
  </thead>

  <tbody>
            <?php $count = 0; ?>
            @foreach ($orders as $order)
            <tr>
            <input type="hidden" name ="orders[{{$count}}][id]" value="{{$order->id}}" />
              <td >{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
              <td> <?php $itemCount = Item::where('order_id', '=', $order->id)->count(); echo $itemCount ?></td>
              <td>{{ $order->tracking_number}}</td>
              <td>{{ number_format($order->total_amount, 2) }}</td>
              <td class="col-md-3">
                  <div class="container">
                  <script>
                    $(function() {
                    $( "<?php echo "#orders-{$count}-received_date"; ?>" ).datepicker();
                    });
                  </script>
                  <script>
                    $(function() {
                    $( "<?php echo "#orders-{$count}-paid_date"; ?>" ).datepicker();
                    });
                  </script>
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Date Received:</button>
                    </span>
                    <input type="text" class="form-control" id="orders-{{$count}}-received_date" name="orders[{{$count}}][received_date]" readonly>
                    <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                  </div><br />
                  <div class="input-group ">
                    <div class="input-group-btn" >
                      <button class="btn btn-default" type="button" style="padding-right:50px;">Date Paid:</button>
                    </div>
                    <input type="text" class="form-control col-md-6" id="orders-{{$count}}-paid_date" name="orders[{{$count}}][paid_date]" readonly>
                    <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                  </div>
                  </div>
              </td>

              <td ><textarea name="orders[{{$count}}][comments]" rows="3" cols="60"/>{{ $order->comments }}</textarea></td>
              <td >{{date_format($order->created_at, 'm-d-Y') }}</td>
            </tr>
            <?php $count++; ?>
            @endforeach
            </tbody>
</table>

<div style="clear:left;float:left;"><?php echo $orders->links(); ?></div>
  <div style="float:left;margin-top:20px;margin-left:50px;"><button type="submit" name="update_orders" class="btn btn-primary">Update Orders</button></div>
                {{ Form::close() }}
</div>
<div class="tab-pane" id="users">
    <table class="table-striped  col-md-12 table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Payment Method</th>
                <th>Date Joined</th>
              </tr>
            </thead>
            <tbody>
            <?php $count = 0; ?>
            @foreach ($users as $user)
            <tr>
            <input type="hidden" name ="users[{{$count}}][id]" value="{{$user->id}}" />
            <td class="col-md-3">
                <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="first_name">First</label></div>
                <div style="float:right;margin-right:30px;"><input type="text" value="{{$user->first_name}}" name="users[{{$count}}][first_name]" class="input-medium"/></div>
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="last_name">Last</label></div>
                <div style="float:right;margin-right:30px;"><input type="text" value="{{$user->last_name}}" name="users[{{$count}}][last_name]" class="input-medium"/></div>
            </td>
            <td class="col-md-3"> <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="email">Email</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->email}}" name="users[{{$count}}][email]" class="input-medium"/></div>

                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="phone">Phone</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->phone}}" name="users[{{$count}}][phone]" class="input-medium"/></div>

                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="address">Address</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->address}}" name="users[{{$count}}][address]" class="input-medium"/></div>

                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="city">City</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->city}}" name="users[{{$count}}][city]" class="input-medium"/></div>

                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="state">State</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->state}}" name="users[{{$count}}][state]" class="input-medium"/></div>

                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="zip">Zip</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->zip}}" name="users[{{$count}}][zip]" class="input-medium"/></div>
            </td>
            <td class="col-md-3">
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="payment_method">Method</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->payment_method}}" name="users[{{$count}}][payment_method]" class="input-medium"/></div>
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="paypal_email">Paypal</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->paypal_email}}" name="users[{{$count}}][paypal_email]" class="input-medium"/></div>
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="name_on_cheque">Cheque</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->name_on_cheque}}" name="users[{{$count}}][name_on_cheque]" class="input-medium"/></div>





            </td>
            <td class="col-md-1">{{ date('m/d/Y', strtotime($user->created_at)) }}</td>
            </tr>
            <?php $count++; ?>
            @endforeach
            </tbody>
          </table>
         <div style="clear:left;float:left;"><?php echo $users->links(); ?></div>
        <div style="float:left;margin-top:20px;margin-left:50px;"><button type="submit" name="update_users" class="btn btn-primary">Update Users</button>
        </div>
                {{ form::close() }}
</div>
</div>



    </div>
@stop
@section('footer')
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
<?php
// $count = 0;
//  foreach ($orders as $order){
?><!-- <script>
// $(function(){
//   $("#received_date_<?php echo $count; ?>").datepicker();

// });
// $(function(){
// $("#paid_date_<?php echo $count; ?>").datepicker();
// });
</script> -->
<?php
//  $count++;
// }

?>
 <script>
 //$('#myTab a').click(function (e) {
//   e.preventDefault()
//   $(this).tab('show')
// })

</script>
@stop