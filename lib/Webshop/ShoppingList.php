<?php 
namespace Webshop;

/**
 * Shopping List
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     Gerald Rieß 
 */
class ShoppingList extends Entity {

    private $ownerId;
    private $helperId;
    private $endDate;    
    private $paidPrice;
    private $state;
    private $name;

    public function __construct(
        int $id, 
        int $ownerId, 
        $helperId, string $endDate, $paidPrice, 
        string $state, string $name 
    ) {
            parent::__construct($id);
            $this->ownerId = $ownerId;
            $this->helperId = $helperId;
            $this->endDate = $endDate; 
            $this->paidPrice = $paidPrice;
            $this->state = $state;
            $this->name = $name;
    }

    public function getOwnerId() : int {
        return $this->ownerId;
    }

    public function getHelperId() {
        return $this->helperId;
    }

    public function getEndDate() : string {
        return $this->endDate;
    }

    public function getPaidPrice() {
        return $this->paidPrice;
    }

    public function getState() : string {
        return $this->state;
    }

    public function getName() : string {
        return $this->name;
    }
    
}
