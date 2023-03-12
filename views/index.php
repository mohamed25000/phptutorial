<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>
</head>
<body>
    Home Page
    <hr />
    <div>
        <?php if(!empty($invoice)): ?>
            Invoice ID: <?= htmlspecialchars($invoice["id"], ENT_QUOTES) ?>
            Invoice amount: <?= htmlspecialchars($invoice["amount"], ENT_QUOTES) ?>
            User: <?= htmlspecialchars($invoice["full_name"], ENT_QUOTES) ?>
        <?php endif; ?>
    </div>
</body>
</html>