<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=VisiteRepository::class)
 * @Vich\Uploadable
 */
class Visite
{
    
    /**
     * @Callback
     * @param ExecutionContextInterface $contexte
     */
    public function validate(ExecutionContextInterface $contexte) {
        $image = $this->getImageFile();
        if($image != null && $image !=""){
            $tailleImage = @getimagesize($image);
            if($tailleImage != null){
                if($tailleImage[0]>1300 || $tailleImage[1]>1300){
                $contexte->buildViolation('Cette image est trop grande (taille max 1300x1300)')
                    ->atPath('imageFile')
                    ->addViolation();
                }
            }
            else{
                $contexte->buildViolation('Le fichier selectionné n\'est pas une image !')
                        ->atPath('imageFile')
                        ->addViolation();
            }

        }
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *NOTE: This is not a mapped field of entity metadata, just a simple property.
     *@Vich\UploadableField(mapping="visites", fileNameProperty="imageName")
     *@var File|null
     */
    private ?File $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable = "true")
     * @var string|null
     */
    private ?string $imageName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pays;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datecreation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tempmin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tempmax;

    /**
     * @ORM\ManyToMany(targetEntity=Environnement::class)
     */
    private $environnements;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {
        $this->environnements = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDatecreation(): ?DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(?string $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    public function getTempmin(): ?int
    {
        return $this->tempmin;
    }

    public function setTempmin(?int $tempmin): self
    {
        $this->tempmin = $tempmin;

        return $this;
    }

    public function getTempmax(): ?int
    {
        return $this->tempmax;
    }

    public function setTempmax(?int $tempmax): self
    {
        $this->tempmax = $tempmax;

        return $this;
    }
    
    public function getDatecreationString() : string{
        if($this->datecreation == null){
            return '';
        }
        else{
            return $this->datecreation->format('d/m/y');
        }
    }

    /**
     * @return Collection<int, Environnement>
     */
    public function getEnvironnements(): Collection
    {
        return $this->environnements;
    }

    public function addEnvironnement(Environnement $environnement): self
    {
        if (!$this->environnements->contains($environnement)) {
            $this->environnements[] = $environnement;
        }

        return $this;
    }

    public function removeEnvironnement(Environnement $environnement): self
    {
        $this->environnements->removeElement($environnement);

        return $this;
    }
    
    public function getImageFile(): ?File {
        return $this->imageFile;
    }

    public function getImageName(): ?string {
        return $this->imageName;
    }

    public function setImageFile(?File $imageFile): self {
        $this->imageFile = $imageFile;
        if (null !== $this->imageFile){
            $this->updated_at = new DateTime('now');
        }
        return $this;
    }

    public function setImageName(?string $imageName): self {
        $this->imageName = $imageName;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


}
