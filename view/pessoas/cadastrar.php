<h1>Cadastrar</h1>

<?php if (isset($error) && !empty($error)): ?>
<div style="padding: 40px 0; color: red;"><?php echo $error; ?></div>
<?php endif; ?>

<form name="frmMain" method="post" action="">
    
    <input type="text" name="nome" placeholder="Nome"/>
    <input type="email" name="email" placeholder="E-mail"/>
    
    <button type="submit">Cadastrar</button>
    
</form>

