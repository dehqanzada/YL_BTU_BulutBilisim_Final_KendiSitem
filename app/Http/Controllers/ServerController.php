<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Ec2\Ec2Client;
use File;

class ServerController extends Controller
{
    public $region = "us-east-1";
    public $version = "2016-11-15";
  	public $keyy = "***********";
    public $secret = "***********";
    public $instance = array('***********');

    public function serverStart()
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


    public function serverStop()
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




    public function serverStatu()
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
            if($i == 1){
                foreach ($reservation['Instances'] as $instance) {
                	$durum = $instance['State']['Name'];
                }
            }
            $i++;
        }
      
      
      
      
      
      
      
      

        return $durum;
    }

    public function serverIp()
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
            if($i == 1){
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
  
  
  
  	public function getServerIpFromServer($ip)
    {
        $file = 'server_ip.json';
        $destinationPath = public_path()."/server_ip/";
        
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }

        File::put($destinationPath.$file, $ip);
        
        return response()->json([
            'statu' => 'success'
        ]);    
    }
}
