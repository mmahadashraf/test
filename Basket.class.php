<?php
class Basket{
    	private $catalog;	//list of products with prices
    	private $minDeliveryRuleTotal;	//minimim shipping rule order price
	private $minDeliveryRuleRate;	//minimum shipping rule rate
	private $maxDeliveryRuleTotal;	//maximum shipping rule order price
	private $maxDeliveryRuleRate;	//maximum shipping rule rate
    	private $productsList;	//ordered products list to add/remove
	private $productsListTotal;	//ordered products total

  
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
	$this->productsListTotal = 0;	 
    	$this->productsList = [];	     
	
    }
	
//add product
    public function addProduct($productCode) {  

        $this->productsList[] = $productCode;

    }
	
//remove product	
    public function removeProduct($productCodeParam) {  

	    foreach($this->productsList as $index => $productCode) {

            if($productCode == $productCodeParam) {
                unset($this->productsList[$index]);
                break;
            }
        }
	    
    }
	
//fetch all products	
    public function fetchAllProducts() {  
        return $this->productsList;
    }
	
//calculate total of basket	
    public function getTotal() {  
        $this->productsListTotal = 0;        	

        $redWidgetExists = false;
        if(count($this->productsList) == 0) {
            return 0;
        }
        foreach($this->productsList as $product) {			
           
            if($product != 'R01'){ //for all other products simply add to sub total
				$this->productsListTotal += $this->catalog[$product];                    
			}else{	//for red widgets for alternate piece charge half of the price using redwidget flag which resets once set true
				$this->productsListTotal += (($redWidgetExists)?($this->catalog[$product] / 2):$this->catalog[$product]);					 				
				$redWidgetExists = !$redWidgetExists;             
			}
        }
						       
        //shipping rules calculations
        if($this->productsListTotal <= $this->minDeliveryRuleTotal) { 
            $this->productsListTotal += $this->minDeliveryRuleRate;
        } else if($this->productsListTotal <= $this->maxDeliveryRuleTotal) { 
            $this->productsListTotal += $this->maxDeliveryRuleRate;
        }
        return round($this->productsListTotal, 2);	//rounding to 2 decimals as shown in input samples
    }//end function getTotal
}//end class
