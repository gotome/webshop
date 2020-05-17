<?php 
namespace Webshop;

/**
 * Article
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     Gerald Rieß 
 */
class Article extends Entity {

    private $shoppingListId;
    private $description;
    private $amount;    
    private $highestPrice;
    private $deletedFlag;
    private $doneFlag;

    public function __construct(
        int $id, 
        int $shoppingListId, 
        string $description, int $amount, float $highestPrice, 
        bool $deletedFlag, bool $doneFlag
    ) {
            parent::__construct($id);
            $this->shoppingListId = $shoppingListId;
            $this->description = $description;
            $this->amount = $amount; 
            $this->highestPrice = $highestPrice;
            $this->deletedFlag = $deletedFlag;
            $this->doneFlag = $doneFlag;
    }

    public function getShoppingListId() : int {
        return $this->shoppingListId;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function getAmount() : int {
        return $this->amount;
    }

    public function getHighestPrice() : float {
        return $this->highestPrice;
    }

    public function getDeletedFlag() : bool {
        return $this->deletedFlag;
    }

    public function getDoneFlag() : bool {
        return $this->doneFlag;
    }
    

}