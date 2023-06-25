<?php

use Alura\Mvc\Repository\VideoRepository;

$host = 'localhost';
$dbname = 'db-aluraplay';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$repository = new VideoRepository($pdo);
$videosList = $repository->all();

if (isset($_GET['sucesso'])) {
    $resultado = $_GET['sucesso'];
    if ($resultado == '0') {
        echo '
            <script>
            alert("Falha ao executar ação!");
            window.location.href = "/";
            </script>
        ';
    } else {
        echo '
            <script>
            alert("Ação executada com sucesso!");
            window.location.href = "/";
            </script>
        ';
    }
}
?>
<?php require_once 'inicio-html.php'; ?>

    <ul class="videos__container" alt="videos alura">
        <?php foreach ($videosList as $video): ?>
        <li class="videos__item">
            <iframe width="100%" height="72%" src="<?php echo $video->url;?>"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            <div class="descricao-video">
                <img src="img/logo.png" alt="logo canal alura">
                <h3><?php echo $video->title;?></h3>
                <div class="acoes-video">
                    <a href="/editar-video?id=<?=$video->id;?>">Editar</a>
                    <a href="/remover-video?id=<?=$video->id;?>">Excluir</a>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
<?php require_once 'fim-html.php'; ?>