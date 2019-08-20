<?php
class Basket{
    	private $catalog;	//list of products with prices
    	private $minDeliveryRuleTotal;	//minimim shipping rule order price
	private $minDeliveryRuleRate;	//minimum shipping rule rate
	private $maxDeliveryRuleTotal;	//maximum shipping rule order price
	private $maxDeliveryRuleRate;	//maximum shipping rule rate
    	private $productsList;	//ordered products list to add/remove (with quantity) 
	private $productsListTotal;	//ordered products total
	private $shippingCost;	//shipping cost on order total as per rules
  
//initialisation
    public function __construct(){
        $this->catalog = [   
            	'R01' => 32.95,
		'G01' => 24.95,
        	'B01' => 7.95            
        ];
        $this->minDeliveryRuleTotal = 50;  
	$this->minDeliveryRuleRate = 4.95;  
        $this->maxDeliveryRuleTotal = 90;
	$this->maxDeliveryRuleRate = 2.95;   
	$this->shippingCost = 0;
	$this->productsListTotal = 0;
        $this->productsList = $this->catalog = [	//assocaitive array created for convenience in invoice display
        	'R01' => 0,
		'G01' => 0,
            	'B01' => 0            
        ];
	    //alternate approach
	    /*
	    	$this->productsList = [];	
	    */
    }
	
//add product
    public function addProduct($productCode) {  
        //due to the convenience approach
	    $this->productsList[$productCode]+=1;
	//alternate approach
	/*    $this->productsList[] = $productCode;*/

    }
	
//remove product	
    public function removeProduct($productCodeParam) {  
        //due to the convenience approach
	if($this->productsList[$productCodeParam]>=1)
		$this->productsList[$productCodeParam]-=1;
	else
		$this->productsList[$productCodeParam]=0;
	 //alternate approach
	    /*foreach($this->productsList as $index => $productCode) {
            if($productCode == $productCodeParam) {
                unset($this->products[$index]);
                break;
            }
        }*/
	    
    }
	
//fetch all products	
    public function fetchAllProducts() {  
        return $this->productsList;
    }
	
//calculate total of basket	
    public function getTotal() {  
        $this->productsListTotal = 0;        
	    //due to the convenience approach
	foreach($this->productsList as $productCode => $qty) {			
           
            if($productCode != 'R01'){
			$this->productsListTotal += ($this->catalog[$productCode]*$qty);                    
	    }else{
		$quo=$qty/2;
		$rem=$qty%2;
		if($rem==0){	//for even quantity: total for this product will be (quotient*price + quotient*half price)
			  $this->productsListTotal += (($quo*$this->catalog[$productCode]) + ($quo *($this->catalog[$productCode]/2));
		}else {	//for even quantity: total for this product will be (sum of quotient & remainder*price) + (quantity - sum of quotient & remainder)*half price
			  $this->productsListTotal += (($quo + $rem)*$this->catalog[$productCode])+(($qty - ($quo + $rem))*($this->catalog[$productCode]/2));
		}				      
	    }
         }
//alternate approach 
/*
     $redWidgetExists = false;
        if(count($this->productsList) == 0) {
            return 0;
        }
        foreach($this->productsList as $product) {			
           
            if($product != 'R01'){ //for all other products simply add to sub total
				$this->productsListTotal += $this->catalog[$product];                    
			}else{	//for red widgets for alternate piece charge half of the price usong redwidget flag which resets once set true
				$this->productsListTotal += (($redWidgetExists)?($this->catalog[$product] / 2):$this->catalog[$product]);					 				
				$redWidgetExists = !$redWidgetExists;             
			}
        }
*/						       
        //shipping rules calculations
        if($this->productsListTotal < $this->minDeliveryRuleTotal) { 
            $this->shippingCost = $this->minDeliveryRuleRate;
        } else if($this->productsListTotal < $this->maxDeliveryRuleTotal) { 
            $this->shippingCost = $this->maxDeliveryRuleRate;
        }
        return round($this->productsListTotal+$this->shippingCost, 2);	//rounding to 2 decimals as shown in input samples
    }//end function getTotal
}//end class
