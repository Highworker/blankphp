<?php
namespace Sergejandreev\Blankphp\Entities;

class Recipe extends AbstractEntity
{
    protected ?string $name = null;
    protected ?string $description = null;
    protected ?string $making = null;
    protected array $ingridients = [];
    protected array $comments = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Recipe
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Recipe
    {
        $this->description = $description;

        return $this;
    }

    public function getMaking(): ?string
    {
        return $this->making;
    }

    public function setMaking(?string $making): Recipe
    {
        $this->making = $making;

        return $this;
    }

    public function getIngridients(): array
    {
        return $this->ingridients;
    }

    /**
     * @param Ingridient[] $ingridients
     * @return $this
     */
    public function setIngridients(array $ingridients): Recipe
    {
        $this->ingridients = $ingridients;
        return $this;
    }

    /**
     * @param string $ingridient
     * @return $this
     */
    public function addIngridient(string $ingridient): Recipe
    {
       $this->ingridients[] = $ingridient;
       return $this;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $comment
     * @return $this
     */
    public function addComment(string $comment): Recipe
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function setComments(array $comments): Recipe
    {
        $this->comments = $comments;
        return $this;
    }

}