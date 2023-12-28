<?php

/* listing function */
class Listing extends HomePage{

	private $recordPerPage = 9;
	public $limitFrom = 0;
	public $limitTo = 9;
	public $listingQuery;
	private $totalProducts;



	function __construct($con) {
		$this->con = $con;	
		$this->setConnection($con);
		   }

//fetch Products
	//////// Listing Products /////////
	public function filterProducts(){
		$condition = "";
		$join = "";
		if(isset($_SESSION['filter'])){

			if(isset($_SESSION['filter']['max'])){
				$condition .= " and p.discount<".$_SESSION['filter']['max'];
			}
			if(isset($_SESSION['filter']['max'])){
				$condition .= " and p.discount>".$_SESSION['filter']['min'];
			}
			





			if(isset($_SESSION['filter']['checked'])){

				foreach($_SESSION['filter']['checked'] as $checked){
	
	
					$count = count($checked); 
	
					if($count != 0){
	
						$typeTemp = $checked;
						if($count == 1){
							foreach($checked as $v)
							{
							$condition .= " AND ".$v;
						    }
						    // $condition .= " AND ".$checked[0];
						}else{
						
						
							$condition .= " AND (";
		
							$condition .= " ".array_shift($typeTemp);
							
							foreach($typeTemp as $value){
								$condition .= " OR ".$value;
							}
						
							$condition .= " )";
						}
					}
	
				}
			
					
				}

				if((isset($_SESSION['filter']['search']))&&($_SESSION['filter']['search']!="")){
					$condition .= " AND product_name like '%".$_SESSION['filter']['search']."%'";
				}

				// if((isset($_SESSION['filter']['brand']))&&($_SESSION['filter']['brand']!="")){
				// 	$condition .= " AND brand like '%".$_SESSION['filter']['search']."%'";
				// }

			if(isset($_SESSION['filter']['orderBy'])&&($_SESSION['filter']['orderBy']!="")){

				if(explode(' ',$_SESSION['filter']['orderBy'])[0]=='and')
				{
				$condition .= $_SESSION['filter']['orderBy']." group by p.group_code order by p.id desc";

				}
                else
                {
				// $condition .= " AND p.discount = ANY(SELECT MIN(discount) as amount FROM products group by group_code)";

				// $condition .=  " order by  ".$_SESSION['filter']['orderBy'];
			$condition .= " group by p.group_code";

			   }

			}else{
	    		$condition .= " group by p.group_code order by p.id desc";
			}

			if((isset($_SESSION['filter']['search']))&&($_SESSION['filter']['search']!="")){
				$condition .= " ,locate('".$_SESSION['filter']['search']."', product_name) desc";
			}
			
		}else{
			$condition .= " group by p.group_code order by p.id desc";
			
		}




  	$this->listingQuery = 'SELECT p.*,c.classtype_id,(SELECT price FROM `today_deal` WHERE (concat(startdate," ",starttime)<= NOW()) AND (concat(enddate," ",endtime)>=NOW()) AND pid=p.id) As dealPrice FROM products p,category c WHERE p.status="Active" AND c.id=p.cat_id '.$condition;
	if(isset($_SESSION['limitTo']) && $_SESSION['limitFrom'])
	{
	   $query = $this->listingQuery. ' limit '.$_SESSION['limitFrom'].','.$_SESSION['limitTo'];
       // unset($_SESSION['limitFrom']);
       // unset($_SESSION['limitTo']);
	}
	else
	{
	   $query = $this->listingQuery. ' limit '.$this->limitFrom.','.$this->limitTo;
	}
// 	 echo $query;
		$result = $this->getDataArray($query);
		return $result; // Query was successfully
	}
	//////// Listing Products /////////
    
	//////// Total Listing Products ////////
	private function totalListingProducts(){
		$query = mysqli_query($this->con,$this->listingQuery);
		$this->totalProducts = mysqli_num_rows($query);
	}
	//////// Total Listing Products ////////

	//////// Get Total Listing Products ////////
	public function totalProducts(){
		$this->totalListingProducts();
		return $this->totalProducts;
	}
	//////// Get Total Listing Products ////////

 ////getmax price by cat or sucat id/////
function getMax($categoryType,$listingId )
{
	switch ($categoryType) {
        case "cat_id":
        $where="cat_id";
        $column = "price,discount";
        
        break;
        case "subcat_id":
        $where="subcat_id";
        $column = "price,discount";

        break;

      }

      $query = 'SELECT '.$column.' from  products WHERE '.$where.'="'.$listingId.'" AND status="Active"';
      $data = $this->getDataArray($query);

    $max = 0;
    foreach( $data as $k => $v )
    {
    	if($v['price']>$v['discount'])
    	{
    		$price=$v['price'];
    	}
    	else
    	{
    		$price=$v['discount'];

    	}
    	if($max<$price)
    		$max=$price;

    }
    return $max;
}

public function getOrderByProducts($products,$orderBy)
{
	foreach($products as $key=>$value)
	{
		if($value['dealPrice']!="")
		{
			$products[$key]['actualPrice']=$value['dealPrice'];
		}
		elseif($value['discount']!='0')
		{
			$products[$key]['actualPrice']=$value['discount'];

		}
		else
		{
			$products[$key]['actualPrice']=$value['price'];

		}
	}
	
	// echo "<pre>";
	// print_r($products);
   array_multisort(array_map(function($element) {
      return $element['actualPrice'];
  }, $products), SORT_DESC, $products);

	if($orderBy=='ASC')
   array_multisort(array_map(function($element) {
      return $element['actualPrice'];
  }, $products), SORT_ASC, $products);




   return $products;
}  
public  function getDealProducts()
	{
		$query='SELECT p.*,c.classtype_id,(SELECT price FROM `today_deal` WHERE (concat(startdate," ",starttime)<= DATE_SUB(NOW(), INTERVAL 7 DAY) ) AND (concat(enddate," ",endtime)>=DATE_SUB(NOW(), INTERVAL 7 DAY) ) AND pid=p.id) As dealPrice FROM products p,category c WHERE p.status="Active"';
		$result = $this->getDataArray($query);
		return $result; // Query was successfully

	}
	//////// Set Limit From Products ////////
	public function limitFrom($limit){
			$this->limitFrom = $limit;
	}
	//////// Set Limit From Products ////////

	//////// Set Limit To Products ////////
	public function limitTo($limit){
		$this->limitTo = $limit;
	}
	//////// Set Limit To Products ////////

	//////// Set Record Per Page To Products ////////
	public function recordPerPage(){
		return $this->recordPerPage;
	}
	//////// Set Record Per Page To Products ////////

	//////// Record Showing From Products ////////
	public function recordFrom(){

		return ($this->totalProducts() != 0) ? $this->limitFrom+1 : 0;
	}
	//////// Record Showing From Products ////////

	//////// Record Showing To Products ////////
	public function recordTo(){
		return ($this->totalProducts() > $this->limitTo) ? $this->limitTo : $this->totalProducts();
	}
	//////// Record Showing To Products ////////

	public function totalPages(){
		return abs(ceil($this->totalProducts()/$this->recordPerPage));

	}
}

$listing = new Listing($con);




?>