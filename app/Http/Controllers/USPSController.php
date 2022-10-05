<?php

namespace app\Http\Controllers;
use app\Http\Requests;
use app\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Usps;
use Cart;
use \Johnpaulmedina\Usps\RatePackage;

class USPSController extends Controller
{
    public function index() {
        $data = request()->all();
        // dd($data);
        return response()->json(
            Usps::validate($data)
        );
    }

    public function trackConfirm() {
        return response()->json(
            Usps::trackConfirm( 
                Request::input('id')
            )
        );
    }

    public function trackConfirmRevision1() {
        return response()->json(
            Usps::trackConfirm( 
                Request::input('id'),
                'Acme, Inc'
            )
        );
    }

    public function shippingCost()
    {
        $data = request()->all();
        // dd($data);
        $data['ounces'] = $data['ounces']>0 ? $data['ounces'] : 1;
        $shipping_cost = $this->USPS($data['pounds'], $data['ounces'], $data['originZip'], $data['destZip']);
        if($shipping_cost){

            $option_session = session()->get('option');
            if($option_session){
                $option = json_decode($option_session[0], true);
                $total = $option['price'] * $option['qty'];
            }
            else
                $total = Cart::total(2);

            $cart_total = $shipping_cost + $total;
            return response()->json([
                'error' => 0,
                'shipping_cost' => $shipping_cost,
                'shipment_amount' => render_price($shipping_cost),
                'cart_total' => render_price($cart_total),
                'view' => '', //view($this->templatePath .'.cart.shipping-list', compact('ships'))->render(),
                'msg'   => 'Success'
            ]);

        }
        // dd($ships);
        /*if(is_array($ships)){
            // dd($ships['SpecialService']);
            $ships = collect($ships['SpecialService'])->whereIn('ServiceID', [120, 105])->sortBy('ServiceID')->all();
            $ship_first = current($ships);
            // dd($ship_first);

            $option_session = session()->get('option');
            if($option_session){
                $option = json_decode($option_session[0], true);
                $total = $option['price'] * $option['qty'];
            }
            else
                $total = Cart::total(2);

            $cart_total = $ship_first['Price'] + $total;
            return response()->json([
                'error' => 0,
                'shipping_cost' => $ship_first['Price'],
                'shipment_amount' => render_price($ship_first['Price']),
                'cart_total' => render_price($cart_total),
                'view' => view($this->templatePath .'.cart.shipping-list', compact('ships'))->render(),
                'msg'   => 'Success'
            ]);
        }*/

        return response()->json([
            'error' => 1,
            'msg'   => $ships
        ]);
        
        // dd($ships);
    }

    function USPS($pounds, $ounces, $originZip, $destZip) 
    {

        // This script was written by Mark Sanborn at http://www.marksanborn.net  
        // If this script benefits you are your business please consider a donation  
        // You can donate at http://www.marksanborn.net/donate.    

        // ========== CHANGE THESE VALUES TO MATCH YOUR OWN ===========
        $username = config('services.usps.username'); 
        // ========== CHANGE THESE VALUES TO MATCH YOUR OWN ===========

        $url = "https://Production.shippingapis.com/shippingapi.dll";

        $data = "API=RateV4&XML=
            <RateV4Request USERID=\"{$username}\">
            <Revision>2</Revision>
            <Package ID=\"1ST\">
            <Service>PRIORITY</Service>
            <ZipOrigination>{$originZip}</ZipOrigination>
            <ZipDestination>{$destZip}</ZipDestination>
            <Pounds>{$pounds}</Pounds>
            <Ounces>{$ounces}</Ounces>
            <Container></Container>
            <Width></Width>
            <Length></Length>
            <Height></Height>
            <Girth></Girth>
            <Machinable>false</Machinable>
            </Package>
            </RateV4Request>
        ";

        /*$data = "API=RateV4&XML=<RateV4Request USERID=\"{$username}\">
           <Revision>2</Revision>
           <Package ID=\"1ST\">
              <Service>ALL</Service>
              <ZipOrigination>{$originZip}</ZipOrigination>
              <ZipDestination>{$destZip}</ZipDestination>
              <Pounds>{$pounds}</Pounds>
              <Ounces>{$ounces}</Ounces>
              <Container />
              <Size>REGULAR</Size>
              <Width></Width>
              <Length></Length>
              <Height></Height>
              <Girth></Girth>
              <Machinable>false</Machinable>
           </Package>
        </RateV4Request>";*/

        //setting the curl parameters.
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if (curl_errno($ch)) 
        {
            // moving to display page to display curl errors
              echo curl_errno($ch) ;
              echo curl_error($ch);
        } 
        else 
        {
            //getting response from server
            $response = curl_exec($ch);
            // dd($response);
            // $xmlDataString = file_get_contents($response);
            $xmlObject = simplexml_load_string($response);

            $json = json_encode($xmlObject);
            $dataArray = json_decode($json, true);
            // dd($dataArray['Package']['Postage']['Rate']);
            curl_close($ch);
            if($dataArray['Package']['Postage'])
                return $dataArray['Package']['Postage']['Rate'];
        }

        /*$ch = curl_init();  

        // set the target url  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_HEADER, 1);  
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);  

        // parameters to post  
        curl_setopt($ch, CURLOPT_POST, 1);  

        // You would want to actually build this xml using dimensions
        // and other attributes but this is a bare minimum request as
        // an example.
        $data = "API=RateV4&XML=<RateV4Request USERID=\"{$username}\">
           <Revision>2</Revision>
           <Package ID=\"1ST\">
              <Service>ALL</Service>
              <ZipOrigination>{$originZip}</ZipOrigination>
              <ZipDestination>{$destZip}</ZipDestination>
              <Pounds>{$pounds}</Pounds>
              <Ounces>{$ounces}</Ounces>
              <Container />
              <Size>REGULAR</Size>
              <Width>2</Width>
              <Length>1</Length>
              <Height>3</Height>
              <Girth>10</Girth>
              <Machinable>false</Machinable>
           </Package>
        </RateV4Request>";

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        $result = curl_exec ($ch); 

        dd($result);

        return $result;*/
    }
}