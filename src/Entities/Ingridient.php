<?php
namespace Sergejandreev\Blankphp\Entities;

class Ingridient extends AbstractEntity
{
    protected ?string $name = null;
    protected ?string $description = null;
    protected ?bool $includedInRecipe = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Ingridient
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Ingridient
    {
        $this->description = $description;
        return $this;
    }

    public function includeToRecipe()
    {}

}