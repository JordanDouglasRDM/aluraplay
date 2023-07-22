<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use http\Exception\InvalidArgumentException;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)
    {

    }

    public function add(Video $video): Video
    {
        $sql = 'INSERT INTO videos (url, title, image_path) VALUES (:url, :title, :image_path)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->title);
        $stmt->bindValue(':image_path', $video->getFilePath());

        if ($stmt->execute() === false) {
            throw new InvalidArgumentException();
        }
        $id = $this->pdo->lastInsertId();

        $video->setId(intval($id));
        return $video;
    }

    public function remove(int $id): bool
    {
        $sqlQuery = 'DELETE FROM videos WHERE id = ?';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function removeFrame(int $id): bool
    {
        $sqlQuery = 'UPDATE videos SET image_path = null WHERE id = ?';

        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function update(Video $video): bool
    {
        $updateImageSql = '';
        if ($video->getFilePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }
        $sqlQuery = "UPDATE videos SET
                        url = :url,
                        title = :title
                        $updateImageSql
                        WHERE id = :id;";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->title);
        $stmt->bindValue(':id', $video->id, PDO::PARAM_INT);

        if ($video->getFilePath() !== null) {
            $stmt->bindValue(':image_path', $video->getFilePath());
        }
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...),
            $videoList
        );
    }

    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, \PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);
        if ($videoData['image_path'] !== null) {
            $video->setFilePath($videoData['image_path']);
        }

        return $video;
    }

    public function createSlug(string $nome): string
    {
        $file_parts = pathinfo($nome);
        $slug_base = preg_replace('/[^A-Za-z0-9-]+/', '-', $file_parts['filename']);
        $slug_base = strtolower($slug_base);
        $slug = $slug_base . '.' . $file_parts['extension'];
        return $slug;
    }
}