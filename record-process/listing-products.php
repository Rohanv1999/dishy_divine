
<?php 

require('../config.php');

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'].'/listing.php';   

// print_r($url);
// exit();

$data = array();
$result = '';

if(isset($_POST['pageNo'])){

    $pageNo = $_POST['pageNo'];

    $limitFrom = (($pageNo-1) * $listing->recordPerPage());
    $listing->limitFrom($limitFrom);
    $limitTo = ($limitFrom + $listing->recordPerPage());
    $listing->limitTo($limitTo);
    $_SESSION['limitFrom']=$limitFrom;
    $_SESSION['limitTo']=$limitTo;

    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id']);

}


////////// Filter Products By Price Range //////////
if(isset($_POST['priceRange'])){
    
    $_SESSION['filter']['max'] = $_POST['maxPrice'];
    $_SESSION['filter']['min'] = $_POST['minPrice'];
    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id'],'max'=>$_POST['maxPrice'],'min'=>$_POST['minPrice']);

}
////////// Filter Products By Price Range //////////


////////// Order By Listing Products //////////
if(isset($_POST['orderByVal'])){

unset($_SESSION['filter']['orderBy']);

if($_POST['orderByVal']!='popularity'){
    $_SESSION['filter']['orderBy'] = $_POST['orderByVal'];
}
    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id']);

}
////////// Order By Listing Products //////////

////////// Checked Filter Listing Products //////////
if(isset($_POST['action'])){

if($_POST['action'] == 'addFilter'){

    $type = $_POST['type'];
    if(isset($_POST['classtypeId']))
    {
    $classtype_id=explode(",",$_POST['classtypeId']);
    if(isset($_SESSION['classtype_id']))
    {
       foreach ($classtype_id as  $value)
       {

      if(!in_array($value, $_SESSION['classtype_id'])){
            $_SESSION['classtype_id'][] = $value;     ////// Add Filter

        }
      }
       
    }else{
      foreach ($classtype_id as  $value) {
            $_SESSION['classtype_id'][] = $value;     ////// Add Filter
      }
    
    }
   }
    if(isset($_SESSION['filter']['checked'][$type])){
        if(!in_array($_POST['condition'], $_SESSION['filter']['checked'][$type])){
            $_SESSION['filter']['checked'][$type][] = $_POST['condition'];     ////// Add Filter

        }
    }else{
            $_SESSION['filter']['checked'][$type][] = $_POST['condition'];     ////// Add Filter
    }
    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id']);
}



if($_POST['action'] == 'removeFilter'){
 $condition=array();
 $classtypeId=array();
    $type = $_POST['type'];
    $condition[]=$_POST['condition'];
    // echo $_POST['classtypeId'];
     $classtype_id=explode(",",$_POST['classtypeId']);
    if(isset($_SESSION['classtype_id']))
    {
       foreach ($classtype_id as  $value)
       {
           $classtypeId[]=$value;

     }
}
    if(isset($_SESSION['filter']['checked'][$type])){
         $key=array_keys(array_intersect($_SESSION['filter']['checked'][$type], $condition));
        //$key = array_search($_POST['condition'], $_SESSION['filter']['checked'][$type]);
         foreach($key as $k)
         {
        unset($_SESSION['filter']['checked'][$type][$k]);
        }   
                ////// Remove Filter
    }
    if($type=='cat')
    {
    if(isset($_SESSION['classtype_id'])){
        // print_r($classtypeId);
        // print_r($_SESSION['classtype_id']);
        // print_r(array_intersect($_SESSION['classtype_id'], $classtypeId));
        //  $key=array_keys(array_intersect($_SESSION['classtype_id'], $classtypeId));
        //  print_r($key);
        //$key = array_search($_POST['condition'], $_SESSION['filter']['checked'][$type]);
         foreach($_SESSION['classtype_id'] as $k=>$v)
         {
            foreach($classtypeId as $v1)
            {
                if($v==$v1)
                {
            unset($_SESSION['classtype_id'][$k]);
                }
    }
        }   
                ////// Remove Filter
    }
}
    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id']);


}


if($_POST['action'] == 'addRating'){

    if(isset($_SESSION['filter']['rating'])){
        if(!in_array($_POST['value'], $_SESSION['filter']['rating'])){
            $_SESSION['filter']['rating'][] = $_POST['value'];     ////// Add Filter
        }
    }else{
        $_SESSION['filter']['rating'][] = $_POST['value'];     ////// Add Filter
    }
    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id']);
  
    
}

if($_POST['action'] == 'removeRating'){

    if(isset($_SESSION['filter']['rating'])){
        $key = array_search($_POST['value'], $_SESSION['filter']['rating']);
        unset($_SESSION['filter']['rating'][$key]);             ////// Remove Filter
    }
    $_SESSION['fill']=array('filter'=>$_SESSION['filter']['checked'],'class'=>$_SESSION['classtype_id']);

}


// print_r($_POST);
// exit();

}
    $products = $listing->filterProducts();


    // print_r($listing->totalProducts());exit();
    $data['totalProducts'] = $listing->totalProducts();
    $data['totalPages'] = $listing->totalPages();
    $data['recordFrom'] = $listing->recordFrom();
    $data['recordTo'] = $listing->recordTo();
    
    $data['query'] = $listing->listingQuery;
    $data['session'] = $_SESSION;
    echo json_encode($data);
    ?>