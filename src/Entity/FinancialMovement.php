<?php

namespace App\Entity;

use App\Repository\FinancialMovementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FinancialMovementRepository::class)
 */
class FinancialMovement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $account_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): ?int
    {
        return $this->account_id;
    }

    public function setAccountId(int $account_id): self
    {
        $this->account_id = $account_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function getDateAsString(): ?string
    {
        return $this->date->format('Y-m-d');
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function setDateToToday() {
        $this->setDate(new \DateTime('today'));
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getAmountInEuro(): ?string
    {
        return number_format((float)$this->amount, 2, '.', '') . ' EUR';
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

}
