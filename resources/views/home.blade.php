@extends('layouts.app')

@section('content')
<div class='container'>

<div class='row mt-2'>
    <div class='col-md-6 text-center'>
        <span id='serverDNS'></span>
    </div>

    <div class='col-md-6 text-center'>
        <span id='clientDNS'></span>
    </div>
</div>
<div class='row'>

    <div class='col-md-6 mt-2'>
        <div class="card" style="width: 100%; height:400px; overflow-y:auto;">
            <div class="card-header">
                <a href="{{route('serverStart')}}" class='btn btn-primary' id='startServer'>Start Server</a>
                <a href="{{route('serverStop')}}" onclick='clearServerIp()' class='btn btn-danger' id='stopServer'>Stop Server</a>
                <span>Server IP: <b style='color:red;' id='serverIp'></b></span>
                <span style='color:green; float:right;' class="badge badge-secondary" id='serverState'></span>
            </div>
            <table class='table table-striped' id='servertable'>
            <thead>
                <th>ID</th>
                <th>Tweet ID</th>
                <th>Tweets</th>
            </thead>
            <tbody>
                
            </table>
        </div>
    </div>
    
    
    <div class='col-md-6 mt-2'>
        <div class="card" style="width: 100%; height:400px; overflow-y:auto;">
            <div class="card-header">
                <a href="{{route('clientStart')}}" class='btn btn-primary' id='startClient'>Start Client</a>
                <a href="{{route('clientStop')}}" class='btn btn-danger' id='stopClient'>Stop Client</a>
                <span>Client IP: <b style='color:red;' id='clientIp'></b> </span>
                <span style='color:green; float:right;' class="badge badge-secondary" id='clientState'></span>
            </div>
            <table class='table table-striped' id='clienttable'>
                <thead>
                    <th>ID</th>
                    <th>Tweet ID</th>
                    <th>Tweets</th>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$( document ).ready(function() {

    $('#startClient').hide();
    $('#stopClient').hide();

    $('#startServer').hide();
    $('#stopServer').hide();

    serverStatu();
    clientStatu();

 
  
});

var intervalId = window.setInterval(function(){
  
    // serverStatu();
    // clientStatu();

}, 5000);


  
function getTweetFromServer(ip) {
    var url = 'http://'+ ip +'/api/getTweetsFromServer';
    $.ajax({
      type:"get",
      url:url,
      success:function(msg){
        $('.serverTableRow').remove();
        $.each(msg, function(k, v) {
            $('#servertable').append("<tr class='border serverTableRow'><td>"+ (k+1) +"</td><td><a href='https://twitter.com/Sametahayata/status/"+ v['tweetId'] +"' target='blank'>"+ v['tweetId'] +"</a></td><td>"+ v['text'] +"</td></tr>");   
        });
      }
    });
}



function getTweetFromClient(ip) {
    var url = 'http://'+ ip +'/api/getTweetsFromClient';
    $.ajax({
      type:"get",
      url:url,
      success:function(msg){
        console.log(msg);
        $('.clientTableRow').remove();
        $.each(msg, function(k, v) {
            $('#clienttable').append("<tr class='border clientTableRow'><td>"+ (k+1) +"</td><td><a href='https://twitter.com/Sametahayata/status/"+ v['tweetId'] +"' target='blank'>"+ v['tweetId'] +"</a></td><td>"+ v['text'] +"</td></tr>");   
        });
      }
    });
}
  
  
  
  
  function clearServerIp() {
    var url = 'http://btubulutbilisim.herokuapp.com/api/getServerIpFromServer/noIp';
    $.ajax({
      type:"get",
      url:url,
      success:function(msg){

      }, error: function(e){
        alert(e);
      }
    });
  }
  
  
  
function serverStatu() {
    $.ajax({
        type:"get",
        url:"{{route('serverStatu')}}",
        success:function(answer){
            $('#serverState').text(answer);

            if (answer == 'stopped') {
                $('#startServer').show();
                $('#stopServer').hide();
            } else if(answer == 'running') {
                $('#startServer').hide();
                $('#stopServer').show();


                $.ajax({
                    type:"get",
                    url:"{{route('serverIp')}}",
                    success:function(answer){
                        var ip = answer.ip;
                        var dns = answer.dns;

                        $('#serverIp').text(ip);
                        $('#serverDNS').text(dns);
						
                      	getTweetFromServer(ip);
                      
                    }, error: function(e){
                        alert(e);
                    }
                });



            }else{
                $('#startServer').hide();
                $('#stopServer').hide();
            }
            
        }, error: function(e){
            alert(e);
        }
    });
}

function clientStatu() {
    $.ajax({
        type:"get",
        url:"{{route('clientStatu')}}",
        success:function(answer){
            $('#clientState').text(answer);
            
            if (answer == 'stopped') {
                $('#startClient').show();
                $('#stopClient').hide();
            } else if(answer == 'running') {
                $('#startClient').hide();
                $('#stopClient').show();


                $.ajax({
                    type:"get",
                    url:"{{route('clientIp')}}",
                    success:function(answer){
                        var ip = answer.ip;
                        var dns = answer.dns;

                        $('#clientIp').text(ip);
                        $('#clientDNS').text(dns);
                      
						getTweetFromClient(ip);
                      
                    }, error: function(e){
                        alert(e);
                    }
                });



            }else{
                $('#startClient').hide();
                $('#stopClient').hide();
            }
            
        }, error: function(e){
            alert(e);
        }
    });
}
</script>
@endsection
