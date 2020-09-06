<?php 


// function updateArray(&$data, $action='remove', $pos, $newVal=null) {
//     if ($action == 'remove') {
//         if (is_array($data)) {
//             unset($data[$pos]);
//         }
//         array_values($data);
//     }
//     if ($action == 'add') {
//         if (is_array($data)) {
//              $data[$pos] = $newVal;
//         }
//         array_values($data);
//     }
// }

// $arr = array(1,2,3,4,5);
// updateArray($arr, 'remove', 1);
// updateArray($arr, 'add', 5, 'new');

// print_r($arr);



class arrayTest { 

    public $arr;

    function addArray(&$data, $action='remove', $pos, $newVal=null) {
        if ($action == 'add') {
            if (is_array($data)) {
                $data[$pos] = $newVal;
            }
            array_values($data);
        }
        if ($action == 'remove') {
            if (is_array($data)) {
                unset($data[$pos]);
            }
            array_values($data);
            $this->arr = $data;
        }
        $this->arr = $data;
    }



}

$obj = new arrayTest();

$arr = array(1,2,3,4,5);
$obj->addArray($arr, 'add', 1, 6);
print_r($obj->arr);


exit;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function getClientIP(){
    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $client_ip = $_SERVER['HTTP_CLIENT_IP'];
    } 
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
    {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } 
    else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
        $client_ip = $_SERVER['HTTP_X_FORWARDED'];
    } 
    else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $client_ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } 
    else if(isset($_SERVER['HTTP_FORWARDED'])) {
        $client_ip = $_SERVER['HTTP_FORWARDED'];
    } 
    else if(isset($_SERVER['REMOTE_ADDR'])) {
        $client_ip = $_SERVER['REMOTE_ADDR'];
    }
    return $client_ip;
}

function isBlocked($ip_block = array(), $client_ip = null) 
{
    // print_r($ip_block);
    // echo $client_ip;
    // echo "<br>";

    $blocked = false;
    foreach($ip_block as $ip) 
    {
        if($client_ip == $ip)
        {
            $blocked = true;
            break;
        }
        elseif(strpos($ip, '*') !== false)
        {
            $digits = explode(".", $ip);
            $client_ip_digits = explode(".", $client_ip);
            if($digits[1] == '*' && $digits[0] == $client_ip_digits[0])
            {
                $blocked = true;
                break;
                }
                else if($digits[2] == '*' && $digits[0] == $client_ip_digits[0] && $digits[1] == $client_ip_digits[1]){
                    $blocked = true;
                    break;
                }
                else if($digits[3] == '*' && $digits[0] == $client_ip_digits[0] && $digits[1] == $client_ip_digits[1] && $digits[2] == $client_ip_digits[2]){
                    $blocked = true;
                break;
            }
        }
        else if(strpos($ip, "-") !== false)
        {
            list($start_ip, $end_ip) = explode("-", $ip);
            $client_ip_long = ip2long($ip);
            $start_ip = preg_replace('/\s+/', '', $start_ip);
            $end_ip = preg_replace('/\s+/', '', $end_ip);
            $start_ip_long = ip2long($start_ip);
            $end_ip_long = ip2long($end_ip);
            if($client_ip_long >= $start_ip_long && $client_ip_long <= $end_ip_long)
            {
                $blocked = true;
                break;
            }
        }
    }
    return $blocked;
    
}

$client_ip = getClientIP();

$sql = "SELECT ip_address FROM blockip";
$result = $conn->query($sql);

$ip_block = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $ip_block[] = $row['ip_address'];
  }
} 

$isBlocked = isBlocked($ip_block, $client_ip);

if (!empty($isBlocked)) {
    echo "You Can't Access This Site!";
    exit;
}


mysqli_close($conn);
