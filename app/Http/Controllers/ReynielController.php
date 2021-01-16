<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Response;
use Api\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
class ReynielController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    //

    public function page(){
        return view('login');
    }
    public function crud(){

             $data = DB::table('bus')
                    ->join('driver', 'driver.driver_id', '=', 'bus.driver_id')
                    ->join('bus_owner', 'bus_owner.bus_owner_id', '=', 'bus.bus_owner_id')
                    ->join('route', 'route.route_id', '=', 'bus.destination_id')
                    ->join('bus_owner_details', 'bus_owner_details.bus_owner_details_id', '=', 'bus_owner.bus_owner_details_id')
                    ->join('conductor', 'conductor.conductor_id', '=', 'bus.conductor_id')
                    ->select('bus.bus_id', 'bus_owner_details.bus_name', 'driver.name', 'bus_owner.plate_no', 
                        'route.destination', 'bus.phone', 'conductor.conductor_name', 'bus.time_in', 'bus.date_in')
                    ->get();


            $owner = app('db')->select('SELECT * FROM bus_owner');
            $driver = app('db')->select("SELECT * from driver");
            $route = app('db')->select("SELECT * from route");
            $conductor = app('db')->select("SELECT * from conductor");



            return view('dashboard', compact(['data', 'owner', 'driver', 'route','conductor']));
    }
        public function registerBus(){

            $owner = DB::table('bus_owner')
                    ->join('bus_owner_details', 'bus_owner_details.bus_owner_details_id', '=', 'bus_owner.bus_owner_details_id')
                    ->select('bus_owner_details.bus_name', 'bus_owner_details.owner_name','bus_owner.bus_owner_id', 'bus_owner.plate_no', 'bus_owner.phone', 'bus_owner.bus_registered')
                    ->get();
            $bus = app('db')->select("SELECT * from bus_owner_details");
           


            return view('regbus', compact(['owner','bus']));
    } 

           public function busRoute(){

            $bus_route = DB::table('mini_routes')
                    ->join('route', 'route.route_id', '=', 'mini_routes.route_id')
                    ->select('route.route_id', 'route.destination', 'route.kilometers','mini_routes.mini_routes_id','mini_routes.route_id','mini_routes.destination_from','mini_routes.destination_to','mini_routes.fee')
                    ->get();

            $bus_main = app('db')->select('SELECT * from route');

           


            return view('route', compact(['bus_route', 'bus_main']));
    }

           public function driver_conductor(){



            $driver = app('db')->select('SELECT * from driver');
            $conductor = app('db')->select('SELECT * from conductor');

            return view('driver_conductor', compact(['driver', 'conductor']));
    }

    public function addDriver(){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
      


        app('db')->table('driver')->insert(['name' => $name, 'address' => $address, 'phone' => $phone]);
        return redirect()->route('driver_conductor');

    }


        public function addConductor(){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
      


        app('db')->table('conductor')->insert(['conductor_name' => $name, 'conductor_address' => $address, 'conductor_contact' => $phone]);
        return redirect()->route('driver_conductor');

    }
        public function deleteDriver(){
        $id = $_POST['delete-Id'];

         app('db')->table('driver')->where('driver_id', $id)->delete();
            return redirect()->route('driver_conductor');


    }       public function deleteConductor(){
        $id = $_POST['delete-Id'];

         app('db')->table('conductor')->where('conductor_id', $id)->delete();
            return redirect()->route('driver_conductor');


    }


    public function editDriver(){
        $id = $_POST['driver_id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
      


        app('db')->table('driver')->where('driver_id', $id)->update(['name' => $name,'address' => $address,'phone' => $phone]);

        return redirect()->route('driver_conductor');

    }

    public function editConductor(){
        $id = $_POST['conductor_id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
      


        app('db')->table('conductor')->where('conductor_id', $id)->update(['conductor_name' => $name,'conductor_address' => $address,'conductor_contact' => $phone]);

        return redirect()->route('driver_conductor');

    
    }

    public function addRoute(){
        $route = $_POST['route_id'];
        $from = $_POST['from_route'];
        $to = $_POST['to_route'];
        $fare = $_POST['fare_route'];


        app('db')->table('mini_routes')->insert(['route_id' => $route, 'destination_from' => $from, 'destination_to' => $to, 'fee' => $fare]);
        return redirect()->route('busRoute');

    }

    public function editRoute(){
        $route = $_POST['route_id'];
        $main = $_POST['main_route_id'];
        $from = $_POST['from_des'];
        $to = $_POST['to_des'];
        $fare = $_POST['fare_des'];


        app('db')->table('mini_routes')->where('mini_routes_id', $route)->update(['route_id' => $main,'destination_from' => $from,'destination_to' => $to, 'fee' => $fare]);

        return redirect()->route('busRoute');

    }
    public function deleteRoute(){
        $id = $_POST['delete-Id'];

         app('db')->table('mini_routes')->where('mini_routes_id', $id)->delete();
            return redirect()->route('busRoute');


    }

    public function verify(){

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = app('db')->select("SELECT * FROM login WHERE username='$username'");
            $pass = app('db')->select("SELECT * FROM login WHERE password='$password'");

            if(empty($user)){
                return "<script>alert('Wrong Username') </script> ". redirect()->route('login');
            }
            elseif(empty($pass)){
                return "<script>alert('Wrong Password') </script> ". redirect()->route('login');
            }else{
                 return "<script>alert('Welcome $username') </script> ". redirect()->route('dashboard');
            }

    }

    public function addBus(){
       
        $owner = $_POST['owner'];
        $driver = $_POST['driver'];
        $conductor = $_POST['conductor'];
        $route = $_POST['route'];
        $phone = $_POST['phone_add'];
        $bus_status = 'Active';
        $time = date('H:i');
        $date = date('y-m-d');


        app('db')->table('bus')->insert(['bus_owner_id' => $owner,'conductor_id' =>  $conductor, 'driver_id' => $driver,'destination_id' => $route,'bus_status' => $bus_status,'phone' => $phone,'phone' => $phone, 'date_in' => $date, 'time_in' => $time]);
        return redirect()->route('dashboard');

    }    public function addRegBus(){
       
        $bus_name_id = $_POST['bus_name_id'];
        $add_plate_no = $_POST['add_plate_no'];
        $add_phone = $_POST['add_phone'];
        $registered = date('y-m-d h:i:s');
       


        app('db')->table('bus_owner')->insert(['bus_owner_details_id' => $bus_name_id, 'plate_no' => $add_plate_no,'phone' => $add_phone,'bus_registered' => $registered]);
        return redirect()->route('registerBus');
    }
    public function addBusOwner(){
        $bus_name = $_POST['bus_name'];
        $owner_name = $_POST['owner_name'];
        $owner_address = $_POST['owner_address'];
        $phone = $_POST['phone'];
        $registered = date('y-m-d h:i:s');

        app('db')->table('bus_owner_details')->insert(['bus_name' => $bus_name, 'owner_name' => $owner_name, 'address' => $owner_address, 'phone' => $phone, 'registered_date' => $registered]);
        return redirect()->route('registerBus');
    } 

    public function editBusReg(){
        $id_bus = $_POST['bus_edit_id'];
        $bus_name_id = $_POST['bus_name_id'];
        $plate_no = $_POST['plate_no'];
        $date_registered = $_POST['date_registered'];
       
        
       app('db')->table('bus_owner')->where('bus_owner_id', $id_bus)->update(['bus_owner_details_id' => $bus_name_id,'plate_no' => $plate_no,'bus_registered' => $date_registered]);
       return redirect()->route('registerBus');
    }

    public function deleteUser(){
            $id = $_POST['delete-Id'];

            app('db')->table('bus')->where('bus_id', $id)->delete();
            return redirect()->route('dashboard');

    }    public function deleteRegBus(){
            $id = $_POST['delete-Id'];

            app('db')->table('bus_owner')->where('bus_owner_id', $id)->delete();
            return redirect()->route('registerBus');
    }
}
