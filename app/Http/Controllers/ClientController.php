<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Ec2\Ec2Client;


class ClientController extends Controller
{
    public $region = "us-east-1";
    public $version = "2016-11-15";
	public $keyy = "***********";
    public $secret = "***********";
    public $instance = array('***********');

    public function clientStart()
    {
        $ec2Client = new Ec2Client([
            'region' => $this->region,
            'version' => $this->version,
            'credentials' => [
                'key' => $this->keyy,
                'secret' => $this->secret,
          ]]);

        $instanceIds = array('***********');

        $result = $ec2Client->startInstances(array(
            'InstanceIds' => $instanceIds,
        ));

        if($result){
            return back();
        }
    }


    public function clientStop()
    {
        $ec2Client = new Ec2Client([
            'region' => $this->region,
            'version' => $this->version,
            'credentials' => [
                'key' => $this->keyy,
                'secret' => $this->secret,
          ]]);
          
        $instanceIds = array('***********');
    
        $result = $ec2Client->stopInstances(array(
            'InstanceIds' => $instanceIds,
        ));
        
        if($result){
            return back();
        }
    }

    public function clientStatu()
    {
        $ec2Client = new Ec2Client([
            'region' => $this->region,
            'version' => $this->version,
            'credentials' => [
                'key' => $this->keyy,
                'secret' => $this->secret,
          ]]);
          
        $result = $ec2Client->describeInstances();

        // foreach ($result['Reservations'] as $reservation) {
        //     foreach ($reservation['Instances'] as $instance) {
        //         $durum = $instance['State']['Name'];
        //     }
        // }
      
      
      $i = 0;
      foreach ($result['Reservations'] as $reservation) {
            if($i == 0){
                foreach ($reservation['Instances'] as $instance) {
                	$durum = $instance['State']['Name'];
                }
            }
            $i++;
        }

     
      
      

        return $durum;
    }


    public function clientIp()
    {
        $ec2Client = new Ec2Client([
            'region' => $this->region,
            'version' => $this->version,
            'credentials' => [
                'key' => $this->keyy,
                'secret' => $this->secret,
          ]]);
      

        $result = $ec2Client->describeInstances();

        // foreach ($result['Reservations'] as $reservation) {
        //     foreach ($reservation['Instances'] as $instance) {
        //         if ($instance['State']['Name'] == 'running') {
        //             $dns = $instance['PublicDnsName'];
        //             $ip = $instance['PublicIpAddress'];
        //         }else {
        //             return response()->json([
        //                 "data" => "Instance is Stoped"
        //             ]);
        //         }
        //     }
        // }
      
      $i = 0;
        foreach ($result['Reservations'] as $reservation) {
            if($i == 0){
                foreach ($reservation['Instances'] as $instance) {
                    if ($instance['State']['Name'] == 'running') {
                        $dns = $instance['PublicDnsName'];
                        $ip = $instance['PublicIpAddress'];
                    }else {
                        return response()->json([
                            "data" => "Instance is Stoped"
                        ]);
                    }
                }
            }
            $i++;
        }

        return response()->json([
            "ip" => $ip,
            "dns" => $dns
        ]);
    }
  
  
  
  	public function getServerIpFromHerOku()
    {
        $url = public_path().'/server_ip/server_ip.json';
        $ip = file_get_contents($url);

        if (empty($ip)) {
            return response()->json([
                'ip' => 'Sanal Makine Kapali veya IP adrese erisilmiyor'
            ]);
        }else{
            return response()->json([
                'ip' => $ip
            ]);
        }
        
    }
}
