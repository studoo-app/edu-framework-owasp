<?php

namespace Model;

use Entity\Comment;
use Exception;
use PDO;
use Studoo\EduFramework\Core\Service\DatabaseService;

class CommentModel
{
    private PDO $bdd;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->bdd = DatabaseService::getConnect();
    }
    public function fetchAll(): array
    {
        $request = $this->bdd->prepare('SELECT * FROM comment');
        $request->execute();
        $commentsArray = [];

        foreach ($request->fetchAll() as $value)
        {
            $comment = new Comment($value["id"],$value["name"],$value["body"]);
            $commentsArray[] = $comment;
        }

        return $commentsArray;

    }

    public function create(Comment $comment): void
    {
        $request = $this->bdd->prepare('INSERT INTO comment(name, body) VALUES(:name, :body)');
        $request->execute(['name' => $comment->getName(), 'body' => $comment->getBody()]);
    }

    public function truncate(){
        $resetRequest = $this->bdd->prepare('TRUNCATE TABLE comment');
        $resetRequest->execute();

        $popuplateRequest = $this->bdd->prepare("INSERT INTO `comment` (`id`, `name`, `body`) VALUES (1, 'Limmy Lesbieraufrai', 'Le premier commentaire'),(2, 'Evy Damant', 'Ceci est un deuxieme contenu de commentaire');");
        $popuplateRequest->execute();
    }

}