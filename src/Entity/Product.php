<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $price;

     /**
     * @ORM\Column(type="text")
    */
   	private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;




    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

      public function getDescription()
    {
        return $this->description;
    }


       public function setId($id)
    {
        $this->id = $id;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

      public function setDescription($description)
    {
        $this->description = $description;
    }




}
