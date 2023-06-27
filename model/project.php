<?

class Project extends dmModel {
    static function GetTableName() {
        return 'projecten';
    }

    private $id;
    private $name;
    private $customer_id;
    private $budget;
    private $hours;
    private $hoursleft;
    private $description;
    private $createdat;
    private $updatedat;
    private $company_id;

    public function getCompany()
    {
        return $this->company_id;
    }
    public function setCompany($company_id): self
    {
        $this->company_id = $company_id;
        return $this;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCustomer()
    {
        return $this->customer_id;
    }

    public function setCustomer($customer_id): self
    {
        $this->customer_id = $customer_id;
        return $this;
    }
    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): self
    {
        $this->budget = $budget;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedat()
    {
        return $this->createdat;
    }

    public function setCreatedat($createdat): self
    {
        $this->createdat = $createdat;
        return $this;
    }

    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    public function setUpdatedat($updatedat): self
    {
        $this->updatedat = $updatedat;
        return $this;
    }
    public function getHoursleft(): ?int
    {
        return $this->hoursleft;
    }
    public function setHoursleft(int $hoursleft): self
    {
        $this->hoursleft = $hoursleft;
        return $this;
    }
    public function getHours(): ?int
    {
        return $this->hours;
    }
    public function setHours(int $hours): self
    {
        $this->hours = $hours;
        return $this;
    }
    public function __toString()
    {
        $name = $this->getName();
        return $name ? $name : 'Projecten name';
    }


}