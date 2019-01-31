<?php

namespace Sprain\SwissQrBill\DataGroup\Abstracts;

use Sprain\SwissQrBill\DataGroup\Interfaces\QrCodeableInterface;
use Sprain\SwissQrBill\Validator\Interfaces\SelfValidatableInterface;
use Sprain\SwissQrBill\Validator\SelfValidatableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadataInterface;

abstract class Address implements QrCodeableInterface, SelfValidatableInterface
{
    use SelfValidatableTrait;

    /**
     * Name or company
     *
     * @var string
     */
    private $name;

    /**
     * Country (ISO 3166-1 alpha-2)
     *
     * @var string
     */
    private $country;

    abstract public function getFullAddress() : string;

    abstract public function getQrCodeData() : array;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country) : self
    {
        $this->country = strtoupper($country);

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadataInterface $metadata) : void
    {
        $metadata->addPropertyConstraints('name', [
            new Assert\NotBlank(),
            new Assert\Length([
                'max' => 70
            ])
        ]);

        $metadata->addPropertyConstraints('country', [
            new Assert\NotBlank(),
            new Assert\Country()
        ]);
    }
}