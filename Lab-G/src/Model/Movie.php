<?php
namespace App\Model;

use App\Service\Config;

class Movie
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $producer = null;
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Movie
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Movie
    {
        $this->title = $title;

        return $this;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(?string $producer): Movie
    {
        $this->producer = $producer;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Movie
    {
        $this->description = $description;

        return $this;
    }

    public static function fromArray($array): Movie
    {
        $movie = new self();
        $movie->fill($array);

        return $movie;
    }

    public function fill($array): Movie
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['producer'])) {
            $this->setProducer($array['producer']);
        }
        if (isset($array['description'])) {
            $this->setDescription($array['description']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM movie';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $movies = [];
        $moviesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($moviesArray as $movieArray) {
            $movies[] = self::fromArray($movieArray);
        }

        return $movies;
    }

    public static function find($id): ?Movie
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM movie WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $movieArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $movieArray) {
            return null;
        }
        $movie = Movie::fromArray($movieArray);

        return $movie;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO movie (title, producer, description) VALUES (:title, :producer, :description)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'producer' => $this->getProducer(),
                'description' => $this->getDescription(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE movie SET title = :title, producer = :producer, description = :description WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':description' => $this->getDescription(),
                ':producer' => $this->getProducer(),
                ':title' => $this->getTitle(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM movie WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setTitle(null);
        $this->setProducer(null);
        $this->setDescription(null);
    }
}
