<?php
class Basket{
    private $catalog;
    private $minDeliveryRuleTotal;
	private $minDeliveryRuleRate;
	private $maxDeliveryRuleTotal;
	private $maxDeliveryRuleRate;
    private $productsList;
	private $productsListTotal;
	private $shippingCost;
  
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
        $this->productsList = $this->catalog = [   
            'R01' => 0,
			'G01' => 0,
            'B01' => 0            
        ];
    }
    public function addProduct($productCode) {  
        $this->productsList[$productCode]+=1;
    }
	public function removeProduct($productCodeParam) {  
        if($this->productsList[$productCodeParam]>=1)
			$this->productsList[$productCodeParam]-=1;
		else
			$this->productsList[$productCodeParam]=0;
    }
	public function fetchAllProducts() {  
        return $this->productsList;
    }
    public function getTotal() {  
        $this->productsListTotal = 0;        
		foreach($this->productsList as $productCode => $qty) {			
           
            if($productCode != 'R01'){
				$this->productsListTotal += ($this->catalog[$productCode]*$qty);                    
			}else{
				$quo=$qty/2;
				$rem=$qty%2;
				if($rem==0){//for even quantity: total for this product will be (quotient*price + quotient*half price)
				  $this->productsListTotal += (($quo*$this->catalog[$productCode]) + ($quo *($this->catalog[$productCode]/2));
				}else {//for even quantity: total for this product will be (sum of quotient & remainder*price) + (quantity - sum of quotient & remainder)*half price
				  $this->productsListTotal += (($quo + $rem)*$this->catalog[$productCode])+(($qty - ($quo + $rem))*($this->catalog[$productCode]/2));
				}				      
			}
        }
        
        if($this->productsListTotal < $this->minDeliveryRuleTotal) { 
            $this->shippingCost = $this->minDeliveryRuleRate;
        } else if($this->productsListTotal < $this->maxDeliveryRuleTotal) { 
            $this->shippingCost = $this->maxDeliveryRuleRate;
        }
        return round($this->productsListTotal+$this->shippingCost, 2);
    }
}
