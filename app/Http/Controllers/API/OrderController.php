<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Http\Requests;
use App\Events\OrderClaimed;
use App\Events\NewPurchase;
use Illuminate\Support\Facades\Gate;

use App\Events\RequestBoosterChange;
use App\Events\RequestOrderDrop;
use App\Events\RequestOrderDone;

use Illuminate\Support\Facades\Mail;
use App\Mail\ClientClaimOrderMail;
use App\Mail\ClientCompletedOrderMail;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\Order as OrderResource;
class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if( \Gate::allows('isAdmin')){

        $orders = Order::paginate(99999);
        return OrderResource::collection($orders);
        //return Order::latest()->paginate(4);
      }else{
        return 'fail';
      }
    }
    public function index2()
    {
      if( \Gate::allows('isAdmin') || \Gate::allows('isBooster') || \Gate::allows('isCoach')){

        $orders = DB::table('orders')->get();
        $result = array();
        foreach($orders as $order){
          if($order->order_status == "unclaimed"){
          $tempOrder = $order;
          $decoder = json_decode($tempOrder->order_message);
          $decoder->email = '';
          $decoder->username = '';
          $decoder->password = '';
          $decoder->discord = '';
          $decoder->summoner_name = '';
          $tempOrder->order_message = json_encode($decoder);
          array_push($result, $tempOrder);
          }
        }
        return json_encode($result);
        //return Order::latest()->paginate(4);
      }else{
        return 'fail';
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->order_type = $request->input('order_type');
        $order->order_price = $request->input('order_price');
        $order->order_message = $request->input('order_message');
        $order->order_status = $request->input('order_status');
        $order->payout_status = $request->input('payout_status');
        $order->client_id = $request->input('client_id');
        $order->booster_id = $request->input('booster_id');
        //return ['message'->$order->booster_id];
        if($order->save()){
          return new OrderResource($order);
        }
        //$order->update($request->all());

    }
    public function getAuth(Request $request)
    {
      return env("PAYPAL_ACCESS");
    }
    public function create(Request $request)
    {
      /*$this->validate($request,[
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:users',
        'type' => 'required',
        'password' => 'required|string|min:6'

      ]);*/

      broadcast(new NewPurchase())->toOthers();

      return Order::create([
        'order_type' => $request['order_type'],
        'order_price' => $request['order_price'],
        'order_message' => $request['order_message'],
        'order_id' => $request['order_id'],
        'client_id' => $request['client_id'],
      ]);
    }
    public function createRe(Request $request)
    {
      /*$this->validate($request,[
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:users',
        'type' => 'required',
        'password' => 'required|string|min:6'

      ]);*/
      $newReq = $request;

      $p2 = $newReq[1];
      $p1 = $newReq[0];
      echo json_encode($p1)."\n";
      echo json_encode($p2)."\n";
      echo gettype($p1)."\n";
      echo gettype($p2)."\n";
      echo $p1['client_id']."\n";
      //p1 is the client ongoing_orders_arr obj


        //this is a reassign request by period signifier
        $user = User::findOrFail($p1['client_id']);
        if($user){
          $prevArr = $user->ongoing_orders_arr;
          array_push($prevArr, $p1);
          $user->update([
            'ongoing_orders_arr' => $prevArr,
          ]);
        }

        $curl2 = curl_init();
        $hookObject2 = json_encode([
          "type" => "rich",
          "content" => "@everyone New website order (ID: ".$p2['order_id']."), visit https://app.bmsboosting.com/orders",
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        curl_setopt_array($curl2, [
          CURLOPT_URL => 'https://discordapp.com/api/webhooks/732687617371406467/GRvVMheBRBlLs_ijEzvWiKP-53wljLlzzv3CSOCOgPleboikAZfDpYuaLQ6YJ0nLrzAk',
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => $hookObject2,
          CURLOPT_HTTPHEADER => [
              "Content-Type: application/json"
            ]
        ]);
        curl_exec($curl2);
        curl_close($curl2);

      return Order::create([
        'order_type' => $p2['order_type'],
        'order_price' => $p2['order_price'],
        'order_message' => $p2['order_message'],
        'order_id' => $p2['order_id'],
        'client_id' => $p2['client_id'],
      ]);
    }
    public function claim(Request $request, $id){
      //assumes user order limit already checked



      $order = Order::findOrFail($id);




      if($order->order_status != 'claimed'){
          $order->booster_id = $request->input('booster_id');

          $order->order_status = 'claimed';
          $booster = User::findOrFail($order->booster_id);
          $ongoingOrderArr = $booster->ongoing_orders_arr;
          array_push($ongoingOrderArr, $order);
          $booster->update([
            'ongoing_orders' => $booster->ongoing_orders + 1,
            'ongoing_orders_arr' => $ongoingOrderArr,

          ]);

          $curl2 = curl_init();
          $hookObject = json_encode([
            "type" => "rich",
            "content" => "Order #".$id." claimed by ".$booster->name.".",
          ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
          curl_setopt_array($curl2, [
            CURLOPT_URL => 'https://discordapp.com/api/webhooks/734896157163257886/VaUUN2eseqcXMa0o2XG5RhvocdkqNNoG_XjAYisKUy_ERgAd37tW-VYJpWo5Jf7hKWB3',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hookObject,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
              ]
          ]);
          curl_exec($curl2);
          curl_close($curl2);

          $client = User::find($order->client_id);
          if($client){
          //if($request->input('order_status') == "claimed"){
            Mail::to($client->email)->send(new ClientClaimOrderMail($order));
          }
          //}else if($request->input('order_status') == "completed"){
          broadcast(new OrderClaimed($order->order_id))->toOthers();
        //}
        if($order->save()){
          return new OrderResource($order);
        }
      }
      else{
        return 'false';
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        $orderReturn = $order;

        return new OrderResource($orderReturn);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if( \Gate::allows('isAdmin')){

        if($request->order_status == 'reassigned'){

          $order = Order::findOrFail($id);
          $client = User::findOrFail($order->client_id);
          $booster = User::findOrFail($order->booster_id);

          $boosterOrderNum = $booster->ongoing_orders;
          $boosterCompNum = $booster->completed_orders;
          $boosterOrderNum = $boosterOrderNum - 1;
          $boosterCompNum = $boosterCompNum + 1;
          $boosterOrderArr1 = $booster->ongoing_orders_arr;
          $boosterOrderArr2 = $booster->current_orders_arr;
          $orderItem1 = '';
          $index1 = 0;
          $properIndex1 = -1;
          foreach($boosterOrderArr1 as $item){

            if($item['order_id']  ==  $id){
              $orderItem1 = $item;
              $properIndex1 = $index1;
              break;
            }
            $index1 = $index1 + 1;
          }
          echo($properIndex1."\n");
echo(json_encode($boosterOrderArr1)."\n");
          array_splice($boosterOrderArr1, $properIndex1, 1);
          array_push($boosterOrderArr2, $orderItem1);
          echo(json_encode($boosterOrderArr1)."\n");
          $booster->update([
            'ongoing_orders' => $boosterOrderNum,
            'completed_orders' => $boosterCompNum,
            'ongoing_orders_arr' => $boosterOrderArr1,
            'current_orders_arr' => $boosterOrderArr2,
          ]);

          $clientOrderNum = $client->ongoing_orders;
          $clientCompNum = $client->completed_orders;
          $clientOrderNum = $clientOrderNum - 1;
          $clientCompNum = $clientCompNum + 1;
          $clientOrderArr1 = $client->ongoing_orders_arr;
          $clientOrderArr2 = $client->current_orders_arr;
          $orderItem = '';
          $index = 0;
          $properIndex = -1;
          foreach($clientOrderArr1 as $item){
            if($item['order_id']  ==  $id){
              $orderItem = $item;
              $properIndex = $index;
              break;
            }
            $index = $index + 1;
          }
          echo($properIndex."\n");
          array_splice($clientOrderArr1, $properIndex, 1);
          array_push($clientOrderArr2, $orderItem);

          $client->update([
            'ongoing_orders' => $clientOrderNum,
            'completed_orders' => $clientCompNum,
            'ongoing_orders_arr' => $clientOrderArr1,
            'current_orders_arr' => $clientOrderArr2,
          ]);

        }else{


          $order = Order::findOrFail($id);
          $client = User::findOrFail($order->client_id);

          $clientOrderNum = $client->ongoing_orders;
          $clientCompNum = $client->completed_orders;
          $clientOrderNum = $clientOrderNum - 1;
          $clientCompNum = $clientCompNum + 1;

          $client->update([
            'ongoing_orders' => $clientOrderNum,
            'completed_orders' => $clientCompNum
          ]);

          $order->update($request->all());
          if($order->order_status == "completed" && $order->payout_status != 'completed'){
            Mail::to($client->email)->send(new ClientCompletedOrderMail($order));
          }
          return $order;
        }
      }
    }
    public function adminPayouts(Request $request)
    {
      if( \Gate::allows('isAdmin')){
        $orders = DB::table('orders')->get();
        foreach($orders as $order){
          if((substr($order->order_type, -1) != ".") && ($order->payout_status == "in-progress")){
            $tempOrder1 = Order::findOrFail($order->order_id);
            $tempOrder2 = $tempOrder1;
            $tempOrder2->payout_status = "processed";
            $tempOrder1->update([$tempOrder2->payout_status]);
          }
        }
      }
    }
    public function markReassigned(Request $request, $id)
    {
      $order = Order::findOrFail($id);
      $booster = User::findOrFail($order->booster_id);
      $client = User::findOrFail($order->client_id);
      $userOrderArr = $booster->ongoing_orders_arr;
      $userOrderArr2 = $client->ongoing_orders_arr;
      $compArr = $booster->current_orders_arr;
      $compArr2 = $client->current_orders_arr;

      $index = 0;
      $specIndex=0;
      foreach($userOrderArr as $key => $item){
        //echo(json_encode($key)."\n");
        if($item['order_id'] == $id){
          $userOrderArr[$key]['order_status'] = 'reassigned';
          $specIndex = $index;
          break;
        }
        $index = $index + 1;
      }
//      echo($specIndex . "\n");
      $tempObj = $userOrderArr[$specIndex];
      $tempObj['payout_status'] = 'completed';
      array_splice($userOrderArr, $specIndex, 1);
      array_push($compArr, $tempObj);

      $index = 0;
      $specIndex=0;
      foreach($userOrderArr2 as $key => $item){
        //echo(json_encode($key)."\n");
        if($item['order_id'] == $id){
          $userOrderArr2[$key]['order_status'] = 'reassigned';
          $specIndex = $index;
          break;
        }
        $index = $index + 1;
      }
      //echo($specIndex . "\n");
      $tempObj = $userOrderArr2[$specIndex];
      array_splice($userOrderArr2, $specIndex, 1);
      array_push($compArr2, $tempObj);
      $order->update([
        'order_status' => 'reassigned'
      ]);
      //echo(json_encode($userOrderArr2)."\n");
      //echo(json_encode($compArr2)."\n");
      //echo(json_encode($userOrderArr)."\n");
      //echo(json_encode($compArr)."\n");
      $client->update([
        'ongoing_orders' => $client->ongoing_orders - 1,
        'completed_orders' => $client->completed_orders + 1,
        'ongoing_orders_arr' => $userOrderArr2,
        'current_orders_arr' => $compArr2
      ]);
      $booster->update([
        'ongoing_orders' => $booster->ongoing_orders - 1,
        'completed_orders' => $booster->completed_orders + 1,
        'ongoing_orders_arr' => $userOrderArr,
        'current_orders_arr' => $compArr
      ]);
    }
    public function orderInfo(Request $request, $id){
      $order = Order::findOrFail($id);
      $result = array(
        $order->booster_id,
        $order->client_id,
      );
      return $result;
    }
    public function pauseOrder(Request $request, $id){
      $order = Order::findOrFail($id);
      if($order->order_status == 'paused'){
        $order->update([
          'order_status' => 'claimed'
        ]);
      }else{
        $order->update([
          'order_status' => 'paused'
        ]);
      }
      return $order;
    }
    public function dropRequest(Request $request, $id){
      $order = Order::findOrFail($id);
      $booster = User::findOrFail($order->booster_id);
      $boosterOrderArr = $booster->ongoing_orders_arr;
      foreach($boosterOrderArr as $key => $item){
        //echo(json_encode($item)."\n");
        if($item['order_id'] == $id){
          $boosterOrderArr[$key]['order_status'] = 'request_drop';
          //echo("match" . "\n");
          //echo(json_encode($key) ."\n");
          break;
        }
      }
      //echo(json_encode($boosterOrderArr)."\n");
      $booster->update([
        'ongoing_orders_arr' => $boosterOrderArr,

      ]);
      broadcast(new RequestOrderDrop($id))->toOthers();

      return $boosterOrderArr;
    }
    public function reassignOrder(Request $request, $id){
      $tempOrder1 = Order::findOrFail($id);
      $tempOrder2 = $tempOrder1;
      $tempOrder2->order_status = "reassign";
      $tempOrder1->update([$tempOrder2->order_status]);
      broadcast(new RequestBoosterChange($id))->toOthers();

    }
    public function requestAllPayouts(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $userOrderArr = $user->current_orders_arr;
        foreach($userOrderArr as $key => $item){
          //echo(json_encode($key)."\n");
          if($item['payout_status'] != 'completed'){
            $userOrderArr[$key]['payout_status'] = 'requested';

          }
        }
        $user->update([
          'current_orders_arr' => $userOrderArr,
        ]);
    }
    public function userPayouts(Request $request, $id)
    {
      if( \Gate::allows('isAdmin')){
        $orders = DB::table('orders')->get();
        foreach($orders as $order){
          if($order->booster_id == $id){
            if($order->payout_status == 'processed' || $order-> payout_status == 'requested'){
              $tempOrder1 = Order::findOrFail($order->order_id);
              $tempOrder2 = $tempOrder1;
              $tempOrder2->payout_status = 'completed';
              $tempOrder1->update([$tempOrder2->payout_status]);
            }
          }
        }
        $user = User::findOrFail($id);
        $userOrderArr = $user->current_orders_arr;
        foreach($userOrderArr as $key => $item){
          //echo(json_encode($key)."\n");
          if($item['payout_status'] != 'completed'){
            $userOrderArr[$key]['payout_status'] = 'completed';
            //$item['payout_status'] = 'completed';
            //echo("match" . "\n");
            //echo(json_encode($key) ."\n");

            //echo(json_encode($item) ."\n");
            break;
          }
        }
        //echo(json_encode($userOrderArr) . "\n");
        $user->update([
          'payout' => 0,
          'current_orders_arr' => $userOrderArr,
        ]);
      }
    }
    public function requestComplete(Request $request, $id)
    {
      $order = Order::findOrFail($id);
      $booster = User::findOrFail($order->booster_id);
      $boosterOrderArr = $booster->ongoing_orders_arr;
      //$index = 0;
      //$specialIndex = 0;
      foreach($boosterOrderArr as $key => $item){
        //echo(json_encode($item)."\n");
        if($item['order_id'] == $id){
          $item['order_status'] = 'verify';
          //$specialIndex = $index;
          //echo("match" . "\n");
          //echo(json_encode($key) ."\n");
          break;
        }
        //$index = $index + 1;
      }
      $booster->update([
        'ongoing_orders_arr' => $boosterOrderArr,
      ]);
      $order->update([
        'order_status' => 'verify',
      ]);
      broadcast(new RequestOrderDone($order->order_id))->toOthers();
    }
    public function markCompleted(Request $request, $id){
      $order = Order::findOrFail($id);
      $client = User::findOrFail($order->client_id);
      $booster = User::findOrFail($order->booster_id);
      $boosterOrderArr = $booster->ongoing_orders_arr;
      $boosterOrderArr2 = $booster->current_orders_arr;
      $index = 0;
      $specialIndex = 0;
      foreach($boosterOrderArr as $key => $item){
        //echo(json_encode($item)."\n");
        if($item['order_id'] == $id){
          $specialIndex = $index;
          echo("match" . "\n");
          //echo(json_encode($key) ."\n");
          break;
        }
        $index = $index + 1;
      }
      $tempOrderInfo = $boosterOrderArr[$specialIndex];
      $tempOrderInfo['order_status'] = 'completed';
      array_splice($boosterOrderArr, $specialIndex, 1);
      array_push($boosterOrderArr2, $tempOrderInfo);

      $orderPrice = $order->order_price;
      $orderPrice = ($orderPrice * 0.96)-0.3;
      $orderPrice = floor($orderPrice*0.7);
      $booster->update([
        'ongoing_orders_arr' => $boosterOrderArr,
        'current_orders_arr' => $boosterOrderArr2,
        'ongoing_orders' => $booster->ongoing_orders - 1,
        'completed_orders' => $booster->completed_orders + 1,
        'payout' => $booster->payout + $orderPrice

      ]);


      $clientOrderArr = $client->ongoing_orders_arr;
      $clientOrderArr2 = $client->current_orders_arr;
      $index = 0;
      $specialIndex = 0;
      foreach($clientOrderArr as $key => $item){
        //echo(json_encode($item)."\n");
        if($item['order_id'] == $id){
          $specialIndex = $index;
          echo("match" . "\n");
          //echo(json_encode($key) ."\n");
          break;
        }
        $index = $index + 1;
      }
      $tempOrderInfo = $clientOrderArr[$specialIndex];
      $tempOrderInfo['order_status'] = 'completed';

      array_splice($clientOrderArr, $specialIndex, 1);
      array_push($clientOrderArr2, $tempOrderInfo);
      $client->update([
        'ongoing_orders_arr' => $clientOrderArr,
        'current_orders_arr' => $clientOrderArr2,
        'ongoing_orders' => $client->ongoing_orders - 1,
        'completed_orders' => $client->completed_orders + 1

      ]);


      $order->update([
        'order_status' => 'completed',

      ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if( \Gate::allows('isAdmin')){
        $order = Order::findOrFail($id);
        if($order->delete()){
          return new OrderResource($order);
        }
      }
    }
}
