<h1>Pessoas</h1>

<ul>
<?php foreach ($pessoas as $pessoa): ?>
    <li><?php echo $pessoa['nome']; ?></li>
<?php endforeach; ?>
</ul>


<ul>
    <li><a href="index.php?controller=pessoas&action=cadastrar">Cadastrar Nova Pessoa</a></li>
</ul>
