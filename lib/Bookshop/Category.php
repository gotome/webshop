<?php
namespace Bookshop;
/**
 * Category
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     John Doe <jd@fbi.gov>
 */
class Category extends Entity {

  private $name;

  /**
   * getter for the private parameter $name
   *
   * @return string
   */
  public function getName() : string {
    return $this->name;
  }

  public function __construct(int $id, string $name) {
    parent::__construct($id);
    $this->name = $name;
  }

}