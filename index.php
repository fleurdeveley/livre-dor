<?php 
require_once 'Message.php';
require_once 'GuestBook.php';

$errors = null;
$success = false;
$guestBook = new guestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');


if (isset($_POST['username'], $_POST['message'])){
    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isValid()){
        $guestBook->addMessage($message);
        $success = true;
        $_POST = [];
    } else {
        $errors = $message->getErrors();
    }
}

$messages = $guestBook->getMessages();
$title = "Livre d'Or"; 
require 'header.php'; ?>

<div class="container">
    <h1>Livre d'Or</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">formulaire invalide</div>
    <?php endif ?>

    <?php if ($success): ?>
        <div class="alert alert-success">merci pour votre message</div>
    <?php endif ?>

    <form action="" method="POST">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '') ?>" type="text" name="username" placeholder="Votre pseudo" class="form-control <?php isset($errors['username']) ? 'is-valid' : '' ?>">
            <?php if (isset($errors['username'])): ?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <textarea type="text" name="message" placeholder="Votre message" class="form-control <?php isset($errors['message']) ? 'is-valid' : '' ?>"><?= htmlentities($_POST['username'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="invalid-feedback"><?= $errors['message'] ?></div>
            <?php endif ?>
        </div>
        <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if (!empty($messages)): ?>
    <h1 class="mt-4">Vos messages</h1>

    <?php foreach($messages as $message): ?>
        <?= $message->toHTML() ?>
    <?php endforeach ?>
    <?php endif ?>
</div>

<?php require 'footer.php';?>
