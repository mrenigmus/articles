<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Articles - ваш источник информации на различные темы. На сайте вы найдете полезные статьи по разным областям знаний.">
    <meta name="keywords" content="articles, статьи, информация, знания, сайт, блог">
    <meta name="author" content="Ваше Имя">
    <title>Articles</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lunasima:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite('resources/sass/app.scss')
</head>

<body>
    <div id="app" class="app"></div>
    @vite('resources/js/app.ts')
</body>

</html>
