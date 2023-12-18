<?php


function check_login($con,$is_user){ //detects if user is logged in or not

    if (isset($_SESSION['ID'])){
        $ID =$_SESSION['ID'];

        $query ="select * from fp_admin where admin_id = '$ID' limit 1";

        if ($is_user){
            $query ="select * from fp_users where user_id = '$ID' limit 1";
        }        
        
        $result = mysqli_query($con,$query);
        if ($result && mysqli_num_rows($result) > 0){

            $user_data = mysqli_fetch_assoc($result);
            return $user_data; //returns true
        }
    }

    return false;
}

function Redirect($location,$delay){
    RedirectStart($location,$delay);
    return "<script>console.log('test')</script>";
   
}

function RedirectStart($l,$d){
    
    sleep($d);
    header("Location: $l");
}



function processTextData($textData, $user)
{
    $delimiter = "<!/r>";

    $datas = explode($delimiter, $textData);
 
    $value = '';
    $cont_increment = 0;
    $toggle_type = true;
    $val1 = '';
    $val2 = '';
    $break = false;
    $alt = false;
    foreach ($datas as $data) {
        $val = trim($data);

        if ($toggle_type) {
            $toggle_type = false;
            $val1 = $val;
        } else {
            $toggle_type = true;
            $val2 = $val;

            if ($user){
                
                if ($cont_increment == 0){
                    $value .= "<div class='product-display-divider'>";
                }
                if (($cont_increment * 2) >= ( (count($datas)-1)/2 ) && !$break){
                    $value .="</div><div class='product-display-divider'>";
                    $break = true;
                    $alt = false;
                }
                if ($alt){
                    $alt = false;
                    $value .= "
                    <div class='product-display-detail-a'>
                        <p> $val1 </p>
                        <p> $val2 </p>
                      
                    </div>";
                }else{
                    $alt = true;
                    $value .= "
                    <div class='product-display-detail-b'>
                        <p> $val1 </p>
                        <p> $val2 </p>
                      
                    </div>";
                }
               
                if ($cont_increment == (count($datas)-1)){
                    $value .= "</div>";
                }

            }
            else{
                 $value .= "
                <div class='product-detail-cont' id='product-detail-cont-id-$cont_increment'>
                    <input class='product-detail-input' placeholder='Detail Type' type='text' id='p-detail-$cont_increment-0' value='$val1'>
                    <input  class='product-detail-input' placeholder='Type Info'type='text' id='p-detail-$cont_increment-1' value='$val2'>
                    <div class='product-detail-cont-remove' onclick='RemoveDetailCont($cont_increment);'>
                    </div>
                </div>";
            }
           
            $cont_increment++;
        }
    }

    return $value;
}



