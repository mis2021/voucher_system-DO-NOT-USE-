<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Voucherconfig\Client;
use Illuminate\Http\Request;

class CreateVoucherAPIController extends Controller
{

    public function createVoucher(Request $request)
    {
        $controlleruser     = 'acemcb'; // the user name for access to the UniFi Controller
        $controllerpassword = 'p@$$word@@c3mc'; // the password for access to the UniFi Controller
        $controllerurl      = 'https://172.16.10.14:8443'; // full url to the UniFi Controller, eg. 'https://22.22.11.11:8443'
        $controllerversion  = '5.14.23'; // the version of the Controller software, eg. '4.6.6' (must be at least 4.0.0)

        /**
         * set to true (without quotes) to enable debug output to the browser and the PHP error log
         */
        $debug = false;

        /**
         * minutes the voucher is valid after activation (expiration time)
         */
        $voucher_expiration = 1380;

        /**
         * the number of vouchers to create
         */
        $voucher_count = 1;
        $quota = 1;
        $note = 'testing';
        $up = 2000;
        $down = 2000;
        $megabytes = null;


        /**
         * The site where you want to create the voucher(s)
         */
        $site_id = 'yt50omph';

        /**
         * initialize the UniFi API connection class and log in to the controller
         */
        $unifi_connection = new Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
        // $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
        $set_debug_mode   = $unifi_connection->set_debug($debug);
        $loginresults     = $unifi_connection->login();

        /**
         * then we create the required number of vouchers with the requested expiration value
         */
        $voucher_result = $unifi_connection->create_voucher($voucher_expiration, $voucher_count, $quota, $note, $up, $down, $megabytes);
        // echo json_encode($voucher_result, JSON_PRETTY_PRINT);
        /**
         * we then fetch the newly created vouchers by the create_time returned
         */
        // echo "hello";
        // echo $voucher_result;
        // if(!is_null($voucher_result[0])){
        $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

        return json_encode($vouchers, JSON_PRETTY_PRINT);
        // echo json_encode($vouchers, JSON_PRETTY_PRINT);
    }
}
