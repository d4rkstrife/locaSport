<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToOne(mappedBy: 'article', cascade: ['persist', 'remove'])]
    private ?ArticlePicture $articlePicture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getArticlePicture(): ?ArticlePicture
    {
        return $this->articlePicture;
    }

    public function setArticlePicture(ArticlePicture $articlePicture): self
    {
        // set the owning side of the relation if necessary
        if ($articlePicture->getArticle() !== $this) {
            $articlePicture->setArticle($this);
        }

        $this->articlePicture = $articlePicture;

        return $this;
    }
}
