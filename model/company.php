<?
class Company extends dmModel {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $url;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $admin;
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $person;
    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address; // post code

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description; // del

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Accounting")
     */
    private $accountapp;
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $accountlogin;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $accountpass;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $accountkey1;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $accountkey2;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $accountparm1;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $accountparm2;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isrounded;
    /**
     * @ORM\Column(type="boolean")
     */
    private $removehtml;
    /**
     * @ORM\Column(type="boolean")
     */
    private $translatetask;
    /**
     * @ORM\Column(type="boolean")
     */
    private $stackhours;
    /**
     * @ORM\Column(type="boolean")
     */
    private $createclients;
    /**
     * @ORM\Column(type="boolean")
     */
    private $createproducts;
    /**
     * @ORM\Column(type="boolean")
     */
    private $createinvoices;
    /**
     * @ORM\Column(type="boolean")
     */
    private $jobqueue;
    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $invoicesperiod;
    /**
     * @ORM\Column(type="boolean")
     */
    private $createnewinvoices;
    /**
     * @ORM\Column(type="boolean")
     */
    private $donetasks; // Teamwork
    /**
     * @ORM\Column(type="boolean")
     */
    private $cronon;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $vatcoeff;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logofile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motto;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $mobilephone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Timetracking", mappedBy="company")
     */
    private $tracking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trackingapp")
     */
    private $trackingapp;
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $cid;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Translation")
     */
    private $translation;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $transparm1;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $transparm2;
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $transparm3;

    /**
     * @var string
     */
    private $adminlogin;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $business;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cronline;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ismain;

    public function __construct()
    {
        $this->tracking = []; //new ArrayCollection();
    }
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?int
    {
        // return $this->id ? $this->id : 999;
        return $this->id;
    }
    public function getCompany(): ?Company
    {
        return $this;
    }
    public function getName(): ?string
    {
        return $this->name ? $this->name : "";
    }
    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $value): self
    {
        $this->address = $value;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $value): self
    {
        $this->description = $value;
        return $this;
    }
    public function __toString()
    {
        return $this->getName();
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
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $value): self
    {
        $this->url = $value;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(?string $value): self
    {
        $this->person = $value;
        return $this;
    }

    public function getCid(): ?string
    {
        return $this->cid;
    }

    public function setCid(?string $value): self
    {
        $this->cid = $value;
        return $this;
    }
    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $value): self
    {
        $this->admin = $value;
        return $this;
    }

    public function getIsmain(): ?bool
    {
        return $this->ismain;
    }

    public function setIsmain(bool $ismain): self
    {
        $this->ismain = $ismain;

        return $this;
    }

    public function getAccountlogin(): ?string
    {
        return $this->accountlogin;
    }

    public function setAccountlogin(?string $accountlogin): self
    {
        $this->accountlogin = $accountlogin;

        return $this;
    }

    public function getAccountkey1(): ?string
    {
        return $this->accountkey1;
    }

    public function setAccountkey1(?string $accountkey1): self
    {
        $this->accountkey1 = $accountkey1;

        return $this;
    }

    public function getAccountkey2(): ?string
    {
        return $this->accountkey2;
    }

    public function setAccountkey2(?string $accountkey2): self
    {
        $this->accountkey2 = $accountkey2;

        return $this;
    }

    public function getIsrounded(): ?bool
    {
        return $this->isrounded;
    }

    public function setIsrounded(bool $isrounded): self
    {
        $this->isrounded = $isrounded;

        return $this;
    }
    public function getRemovehtml(): ?bool
    {
        return $this->removehtml;
    }

    public function setRemovehtml(bool $value): self
    {
        $this->removehtml = $value;
        return $this;
    }
    public function getCronon(): ?bool
    {
        return $this->cronon;
    }
    public function setCronon(bool $value): self
    {
        $this->cronon = $value;
        return $this;
    }

    public function getVatcoeff(): ?int
    {
        return $this->vatcoeff;
    }

    public function setVatcoeff(?int $vatcoeff): self
    {
        $this->vatcoeff = $vatcoeff;

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

    public function getLogofile(): ?string
    {
        return $this->logofile;
    }

    public function setLogofile(?string $logofile): self
    {
        $this->logofile = $logofile;

        return $this;
    }

    public function getMotto(): ?string
    {
        return $this->motto;
    }

    public function setMotto(?string $motto): self
    {
        $this->motto = $motto;

        return $this;
    }

    public function getAccountpass(): ?string
    {
        return $this->accountpass;
    }

    public function setAccountpass(?string $accountpass): self
    {
        $this->accountpass = $accountpass;

        return $this;
    }

    public function getAccountparm1(): ?string
    {
        return $this->accountparm1;
    }

    public function setAccountparm1(?string $accountparm1): self
    {
        $this->accountparm1 = $accountparm1;

        return $this;
    }

    public function getAccountparm2(): ?string
    {
        return $this->accountparm2;
    }

    public function setAccountparm2(?string $accountparm2): self
    {
        $this->accountparm2 = $accountparm2;

        return $this;
    }

    public function getAccountapp(): ?array
    {
        return $this->accountapp;
    }
    public function setAccountapp(?array $value): self
    {
        $this->accountapp = $value;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getMobilephone(): ?string
    {
        return $this->mobilephone;
    }
    public function setMobilephone(?string $mobilephone): self
    {
        $this->mobilephone = $mobilephone;

        return $this;
    }
    public function getTrackingapp()
    {
        return $this->trackingapp;
    }
    public function setTrackingapp($value): self
    {
        $this->trackingapp = $value;
        return $this;
    }
    public function getTranslation()
    {
        return $this->translation;
    }
    public function setTranslation($value): self
    {
        $this->translation = $value;
        return $this;
    }
    public function getTransparm1()
    {
        return $this->transparm1;
    }
    public function setTransparm1($value): self
    {
        $this->transparm1 = $value;
        return $this;
    }
    public function getTransparm2()
    {
        return $this->transparm2;
    }
    public function setTransparm2($value): self
    {
        $this->transparm2 = $value;
        return $this;
    }
    public function getTransparm3()
    {
        return $this->transparm3;
    }
    public function setTransparm3($value): self
    {
        $this->transparm3 = $value;
        return $this;
    }

    public function getStartdate()
    {
        return $this->startdate;
    }
    public function setStartdate($value): self
    {
        $this->startdate = $value;
        return $this;
    }
    public function getAdminlogin(): ?string
    {
        return $this->adminlogin;
    }
    public function setAdminlogin(?string $value): self
    {
        $this->adminlogin = $value;
        return $this;
    }
    /**
     * @return Collection|Timetracking[]
     */
    public function getTracking(): ?array //Collection
    {
        return $this->tracking;
    }

    public function addTracking($tracking): self
    {
        // if (!$this->tracking->contains($tracking)) {
        //     $this->tracking[] = $tracking;
        // }
        // $tracking->setCompany($this);
        return $this;
    }
    public function initTracking(): self
    {
        foreach ($this->tracking as $track) {
            $this->removeTracking($track);
        }
        return $this;
    }
    public function removeCompany(): self
    {
        foreach ($this->tracking as $tracking) {
            $tracking->setCompany(null);
        }
        return $this;
    }
    public function removeOld($em): self
    {
        foreach ($this->tracking as $tracking) {
            if ($tracking->getCompany() === null) {
                $this->removeTracking($tracking);
                $em->remove($tracking);
            };
        }
        return $this;
    }
    public function removeTracking($tracking): self
    {
        // if ($this->tracking->contains($tracking)) {
        //     $this->tracking->removeElement($tracking);
        //     // set the owning side to null (unless already changed)
        //     if ($tracking->getCompany() === $this) {
        //         $tracking->setCompany(null);
        //     }
        // }

        return $this;
    }

    public function getBusiness(): ?string
    {
        return $this->business;
    }

    public function setBusiness(?string $value): self
    {
        $this->business = $value;
        return $this;
    }

    public function getCronline(): ?string
    {
        return $this->cronline;
    }

    public function setCronline(?string $cronline): self
    {
        $this->cronline = $cronline;

        return $this;
    }

    public function getTranslatetask(): ?bool
    {
        return $this->translatetask;
    }
    public function setTranslatetask(bool $value): self
    {
        $this->translatetask = $value;
        return $this;
    }
    public function getStackhours(): ?bool
    {
        return $this->stackhours;
    }
    public function setStackhours(bool $value): self
    {
        $this->stackhours = $value;
        return $this;
    }
    public function getCreateclients(): ?bool
    {
        return $this->createclients;
    }
    public function setCreateclients(bool $value): self
    {
        $this->createclients = $value;
        return $this;
    }
    public function getCreateproducts(): ?bool
    {
        return $this->createproducts;
    }
    public function setCreateproducts(bool $value): self
    {
        $this->createproducts = $value;
        return $this;
    }
    public function getCreateinvoices(): ?bool
    {
        return $this->createinvoices;
    }
    public function setCreateinvoices(?bool $value): self
    {
        $this->createinvoices = $value;
        return $this;
    }
    public function getJobqueue(): ?bool
    {
        return $this->jobqueue;
    }
    public function setJobqueue(?bool $value): self
    {
        $this->jobqueue = $value;
        return $this;
    }
    public function getCreatenewinvoices(): ?bool
    {
        return $this->createnewinvoices;
    }
    public function setCreatenewinvoices(bool $value): self
    {
        $this->createnewinvoices = $value;
        return $this;
    }
    public function getDonetasks(): bool
    {
        return $this->donetasks;
    }
    public function setDonetasks(bool $value): self
    {
        $this->donetasks = $value;
        return $this;
    }
    public function getInvoicesperiod(): ?bool
    {
        return $this->invoicesperiod;
    }
    public function setInvoicesperiod(bool $value): self
    {
        $this->invoicesperiod = $value;
        return $this;
    }


}