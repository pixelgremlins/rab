<?php

class AdminController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */
public function __construct(){
        $this->beforeFilter("admin_auth");
    }



    public function getIndex()
    {
        $orders=array();
        $orders = Order::with('user')->paginate(20);
        $users = DB::table('users')->paginate(20);
        $data = array('orders' => $orders, 'users' =>$users);
        //return var_dump($orders);
        return View::make('admin.index', $data);
        //return View::make('cart.index', array('cart' => $cart));
    }

    public function getBuyers(){

        $data = array(
                           'supplies' => Supply::all(),
                           'orders' => SupplyOrder::all()
                           );

        return View::make('admin.buyers', $data);
     }

     public function getEditBuyer($id){
        $buyer = User::find($id);

     }

     public function postAddSupply(){
        $supply = Supply::create(array('name' => Input::get('name'), 'description' => Input::get('description')));
        return Redirect::to('admin/buyers')->with('message', 'Item added!');
     }

    public function getCustomers(){
        $filter = Input::get('f');
        if(isset($filter) && $filter == all){
            $orders = Order::with('user')->paginate(40);
        }
        $orders = Order::with('user')->paginate(40);
        return View::make('admin.customers', array('orders' => $orders));
    }

    public function getUsers(){
        $users = User::with('orders')->paginate(40);
        $groups = Group::all();
        //$users = Sentry::getUserProvider()->findAll()->with('orders');
        //php

        // $users->load('orders');
        return View::make('admin.users', array('users' => $users, 'groups' => $groups));
    }

    public function getGroups(){
        $groups = Sentry::findAllGroups();
        return View::make('admin.groups', array('groups' => $groups));
    }
    public function postAddGroup(){
        $grp = Input::get('group_name');
        try{
            $group = Sentry::createGroup(array(
                           'name' => $grp
                           ));
            return Redirect::back()->with('message', 'Groups successfully updated.');

        } catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
        {

            return Redirect::back()->with('message', 'Group name is required');
        }
        catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            return Redirect::back()->with('message', 'Group already exists');
        }
        return Redirect::back()->with('message', 'Something Else went wrong');

    }
    public function postUpdateOrders(){

      $orders = Input::get('orders');
        // process/update each order.

        foreach($orders as $order){

            // grab Order object.
            $o = Order::where('id', '=', $order['id'])->first();

            // grab User object.
            $u = User::where('id', '=', $o->user_id)->first();
           // return var_dump(date('Y-m-d', strtotime($order['received_date'])));

            // Received Date
            // check of Received date is set, and not empty. If empty/notset do nothing else update.
            if (isset($order['received_date']) && $order['received_date']!=null){

                // convert received date to date object;
                $received_date = date('Y-m-d', strtotime($order['received_date']));

                // check if old_received_date exists
                if (isset($order['old_received_date'])){
                    //if old_received_date exists convert to date object.
                    $old_received_date = date('Y-m-d', strtotime($order['old_received_date']));

                    // if received date does not match old received date...ie the record is updated, not the same.
                    if ($received_date != $old_received_date){
                        // update value
                        $o->received_date = $received_date;
                    }
                } else {
                    // there is no old_Received_date value, so it's the first time the record is updated, and we will send an email to user.
                    $o->received_date = $received_date;
                    $data['userId'] = $o->user_id;
                    $data['email'] = $u->email;

                    // Email the user on first update of this data field.
                    Mail::send('emails.shipment_received', $data, function($m) use($data)
                    {
                        $m->from('patrick@recycleabook.com', 'RecycleABook')->to($data['email'])->subject('Shipment Received @ TopBookPrices.com');
                    });
                }
            }


            // Paid Date
            if (isset($order['paid_date']) && !empty($order['paid_date'])){

                // convert paid date to date object;
                $paid_date = date('Y-m-d', strtotime($order['paid_date']));

                // check if old_paid_date exists
                if (isset($order['old_paid_date'])){
                    //if old_paid_date exists convert to date object.
                    $old_paid_date = date('Y-m-d', strtotime($order['old_paid_date']));

                    // if paid date does not match old paid date...ie the record is updated, not the same.
                    if ($paid_date != $old_paid_date){
                        // update value
                        $o->paid_date = $paid_date;
                    }
                } else {
                    // there is no old_paid_date value, so it's the first time the record is updated, and we will send an email to user.
                    $o->paid_date = $paid_date;
                    $data['userId'] = $o->user_id;
                    $data['email'] = $u->email;

                    // Email the user on first update of this data field.
                    Mail::send('emails.payment_sent', $data, function($m) use($data)
                    {
                        $m->from('patrick@recycleabook.com', 'RecycleABook')->to($data['email'])->subject('Payment Received from TopBookPrices.com');
                    });
                }
            }
             /*
            if ($paid_date != $order['old_paid_date']){
              $o->paid_date = $paid_date;

            }
            */
            $o->comments = $order['comments'];
            $o->save();


        }
        return Redirect::back()->with('message', 'Update successful');
    }



    /**
    *   Update method for users table.
    *
    **/
    public function postUpdateUsers(){
      $users = Input::get('users');
      //return var_dump($users);
        // process/update each order.
        foreach($users as $user){

          // grab User object.
          $u = User::where('id', '=', $user['id'])->first();
          $u->first_name = $user['first_name'];
          $u->last_name = $user['last_name'];
          $u->email = $user['email'];
          $u->phone = $user['phone'];
          $u->address = $user['address'];
          $u->city = $user['city'];
          $u->state = $user['state'];
          $u->zip = $user['zip'];
          $u->payment_method = $user['payment_method'];
          $u->paypal_email = $user['paypal_email'];
          $u->name_on_cheque = $user['name_on_cheque'];
          $u->save();

        }
        return Redirect::back()->with('message', 'Update successful');


    }

    public function postAddUser(){
        $inputs = array('first_name' => Input::get('first_name'),
                        'last_name' => Input::get('last_name'),
                        'email' => Input::get('email'),
                        'password' => Input::get('password'),
                        'password_confirmation' => Input::get('password_confirmation')
                        );
        $groups = Input::get('groups');
        // foreach($groups as $index => $g){
        //             $group = Sentry::findGroupByName($index);
        //            // $user->addGroup($group);
        //             return var_dump($group);
        //         }
        $rules = array(
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|confirmed',


                       );
        $v = Validator::make(
                             $inputs,
                             $rules
                             );
        if($v->fails()){
            $messages = $v->messages();
            return Redirect::to('admin/users')->withErrors($v);
        } else{
            try{
                $user = Sentry::register(
                                           array(
                                                 'first_name' => $inputs['first_name'],
                                                 'last_name' => $inputs['last_name'],
                                                 'email' => $inputs['email'],
                                                 'password' => $inputs['password'],
                                                 ), true
                                           );
                foreach($groups as $index => $g){
                    $group = Sentry::findGroupByName($index);
                    $user->addGroup($group);
                }
            }
            catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
            {
                echo 'Login field is required.';
            }
            catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
            {
                echo 'Password field is required.';
            }
            catch (Cartalyst\Sentry\Users\UserExistsException $e)
            {
                echo 'User with this login already exists.';
            }
            catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
            {
                echo 'Group was not found.';
            }
            return Redirect::back()->with('message', 'added user');
        }
    }




}