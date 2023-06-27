<?php

class Client extends dmModel
{
    private $id;
    private $name;
    private $address;
    private $invoice;
    private $telephone;
    private $email;
    private $password;
    private $admin_id;
    private $hash;
    private $person;
    private $description;
    private $rate;
    private $toggl_id;
    private $Code;
    private $AddDatum;
    private $projects;
    private $postcode;
    private $visibility;
    private $company_id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clientgroup")
     */
    private $group_id;
    private $hidden;
    private $pilot;
    private $plustaskid;
    private $plustaskdate;
    private $linktrack;
    private $timeEntries;

    public function __construct()
    {
        $this->invoice = []; //new ArrayCollection();
        $this->projects = []; //new ArrayCollection();
        $this->timeEntries = []; //new ArrayCollection();
    }

    static function __GetFields()
    {
        // List headers
        return
            [
                ['label' => 'Client Name',      'name' => 'name'],
                ['label' => 'Toggl ID',         'name' => 'togglid'],
                ['label' => 'Address',          'name' => 'address'],
                ['label' => 'Activity',         'name' => 'description'],
                ['label' => 'Telephone',        'name' => 'telephone'],
                ['label' => 'E-Mail',           'name' => 'email'],
                ['label' => 'Contact person',   'name' => 'person'],
                ['label' => 'Pay rate',         'name' => 'rate']
            ];
    }
    static function __GetFields2()
    {
        // List headers
        return
            [
                ['label' => 'Client Name',      'name' => 'name'],
                ['label' => 'Contact person',   'name' => 'person'],
                ['label' => 'Address',          'name' => 'address'],
                ['label' => 'Telephone',        'name' => 'telephone'],
                ['label' => 'E-Mail',           'name' => 'email'],
            ];
    }
    static function __GetFieldsClients()
    {
        // List headers
        return
            [
                ['label' => 'Name',         'name' => 'name'],
                ['label' => 'Group',        'name' => 'group_id'],
            ];
    }

    public function getPilot(): ?int
    {
        return $this->pilot;
    }

    public function setPilot(?int $value): self
    {
        $this->pilot = $value;
        return $this;
    }
    public function getAdmin()
    {
        return $this->admin_id;
    }

    public function setAdmin($value): self
    {
        $this->admin_id = $value;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(?string $value): self
    {
        $this->visibility = $value;
        return $this;
    }
    public function getGroup()
    {
        return $this->group_id;
    }

    public function setGroup($value): self
    {
        $this->group_id = $value;
        return $this;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $Address): self
    {
        $this->address = $Address;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    public function addInvoice($invoice): self
    {
        // if (!$this->invoice->contains($invoice)) {
        //     $this->invoice[] = $invoice;
        //     $invoice->setCustomer($this);
        // }

        return $this;
    }

    public function removeInvoice($invoice): self
    {
        // if ($this->invoice->contains($invoice)) {
        //     $this->invoice->removeElement($invoice);
        //     // set the owning side to null (unless already changed)
        //     if ($invoice->getCustomer() === $this) {
        //         $invoice->setCustomer(null);
        //     }
        // }

        return $this;
    }

    public function __toString()
    {
        $name = $this->getName();
        return $name ? $name : 'client-name';
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(?string $person): self
    {
        $this->person = $person;

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

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(?string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getTogglId(): ?int
    {
        return $this->toggl_id;
    }

    public function setTogglId(?int $toggl_id): self
    {
        $this->toggl_id = $toggl_id;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        // if (!$this->projects->contains($project)) {
        //     $this->projects[] = $project;
        //     $project->setCustomer($this);
        // }

        return $this;
    }

    public function removeProject($project): self
    {
        // if ($this->projects->contains($project)) {
        //     $this->projects->removeElement($project);
        //     // set the owning side to null (unless already changed)
        //     if ($project->getCustomer() === $this) {
        //         $project->setCustomer(null);
        //     }
        // }

        return $this;
    }

    /**
     * @return Collection|TimeEntry[]
     */
    public function getTimeEntries()
    {
        return $this->timeEntries;
    }

    public function addTimeEntry($timeEntry): self
    {
        // if (!$this->timeEntries->contains($timeEntry)) {
        //     $this->timeEntries[] = $timeEntry;
        //     $timeEntry->setCustomer($this);
        // }

        return $this;
    }

    public function removeTimeEntry($timeEntry): self
    {
        // if ($this->timeEntries->contains($timeEntry)) {
        //     $this->timeEntries->removeElement($timeEntry);
        //     // set the owning side to null (unless already changed)
        //     if ($timeEntry->getCustomer() === $this) {
        //         $timeEntry->setCustomer(null);
        //     }
        // }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(?string $Code): self
    {
        $this->Code = $Code;
        return $this;
    }

    public function getAddDatum(): ?string
    {
        return $this->AddDatum;
    }

    public function setAddDatum(?string $AddDatum): self
    {
        $this->AddDatum = $AddDatum;
        return $this;
    }


    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCompany()
    {
        return $this->company_id;
    }

    public function setCompany($company): self
    {
        $this->company_id = $company;

        return $this;
    }

    public function getLinktrack(): ?bool
    {
        return $this->linktrack;
    }

    public function setLinktrack(?bool $value): self
    {
        $this->linktrack = $value;
        return $this;
    }
    public function getPlustaskdate(): ?bool
    {
        return $this->plustaskdate;
    }

    public function setPlustaskdate(?bool $value): self
    {
        $this->plustaskdate = $value;
        return $this;
    }
    public function getPlustaskid(): ?bool
    {
        return $this->plustaskid;
    }

    public function setPlustaskid(?bool $value): self
    {
        $this->plustaskid = $value;
        return $this;
    }
    public function getHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }
    public function setDefault(): self
    {
        $this->name = 'New Customer';
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    public function setPassword(string $value): self
    {
        $this->password = $value;
        return $this;
    }
    public function getHash(): string
    {
        return (string) $this->hash;
    }
    public function setHash(string $value): self
    {
        $this->hash = $value;
        return $this;
    }
}
