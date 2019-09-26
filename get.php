<?php
 /* Shared on httzip.com
  * Visit my blog for more :D 
  */

$token  = "ACCESS-TOKEN"; // Change the access_token

function getVideo($id){
    global $token;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://graph.facebook.com/fql?q=SELECT+vid,title,description,thumbnail_link,embed_html,updated_time,created_time,src,src_hq+FROM+video+WHERE+vid=".$id."&access_token=".$token,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
    ));
    $get = curl_exec($curl);
    curl_close($curl);
    $decode = json_decode($get,JSON_UNESCAPED_UNICODE);
    return showVideo($decode['data'][0]);
}
function showVideo($link)
{

    if(!empty($link['src_hq'])){
        $data = [
        "0"=>[
            "type"=>"video/mp4",
            "label"=>"Standard",
            "file"=>str_replace("video.xx.fbcdn.net","scontent.xx.fbcdn.net",$link['src'])
            ],
        "1"=>[
            "type"=>"video/mp4",
            "label"=>"HD",
            "file"=>str_replace("video.xx.fbcdn.net","scontent.xx.fbcdn.net",$link['src_hq'])
            ]
        ];
        return json_encode($data);
    }else{
        $data = [
        "0"=>[
            "type"=>"video/mp4",
            "label"=>"Standard",
            "file"=>str_replace("video.xx.fbcdn.net","scontent.xx.fbcdn.net",$link['src'])
            ]
        ];
        return json_encode($data);
    }

}
echo getVideo("VIDEO-ID"); // Your Video ID