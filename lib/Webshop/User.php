<?php

namespace Webshop;

/**
 * User
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     Gerald Rieß 
 */
class User extends Entity {

  private $firstName; 
  private $lastName; 
  private $userName;
  private $passwordHash;
  private $deletedFlag;
  private $roleBitCode; 

  public function __construct(
    int $id, 
    string $firstName, string $lastName, string $userName, 
    string $passwordHash, int $roleBitCode, bool $deletedFlag
  ) {
      parent::__construct($id);
      $this->firstName = $firstName; 
      $this->lastName = $lastName; 
      $this->userName = $userName;
      $this->passwordHash = $passwordHash;
      $this->roleBitCode = $roleBitCode;
      $this->deletedFlag = $deletedFlag; 
  }

  /**
   * getter for the private parameter $userName
   *
   * @return string
   */
  public function getUserName() : string {
    return $this->userName;
  }

  /**
   * getter for the private parameter $passwordHash
   *
   * @return string
   */
  public function getPasswordHash() : string {
    return $this->passwordHash;
  }

    /**
   * getter for the private parameter $firstName
   *
   * @return string
   */
  public function getFirstName() : string {
    return $this->firstName;
  }

   /**
   * getter for the private parameter $lastName
   *
   * @return string
   */
  public function getLastName() : string {
    return $this->lastName;
  }

     /**
   * getter for the private parameter $getDeletedFlag
   *
   * @return string
   */
  public function getDeletedFlag() : bool {
    return $this->deletedFlag;
  }

  /**
   * getter for the private parameter $hasRole
   *
   * @return string
   */
  public function hasRole(int $bitCode) : bool {
    return $this->roleBitCode & $bitCode;
  }
}