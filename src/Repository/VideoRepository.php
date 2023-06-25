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
        $sql = 'INSERT INTO videos (url, title) VALUES (?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $video->url);
        $stmt->bindValue(2, $video->title);

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

    public function update(Video $video): bool
    {
        $sqlQuery = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(':url',$video->url);
        $stmt->bindValue(':title',$video->title);
        $stmt->bindValue(':id',$video->id, PDO::PARAM_INT);
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

        return $video;
    }
}