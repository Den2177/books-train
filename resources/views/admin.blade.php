<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('public/assets/css/app.css')}}">
    <title>Admin Page</title>
</head>
<body>
<header class="header">
    <div class="container">
        <a href="/" class="logo">Logo</a>
    </div>

</header>
<main class="main">
    <div class="container">
        <div class="grid f1f3">
            <div class="sidebars vertical g20">
                <form action="{{route('books.store')}}" method="post" enctype="multipart/form-data"
                      class="card vertical g20">
                    @csrf
                    <h3>Создать книгу</h3>
                    <input type="text" class="input" placeholder="Название" name="title">
                    <input class="input" placeholder="Описание" name="text">
                    <input type="file" class="input" placeholder="Описание" name="image">
                    <select class="input" multiple name="genres[]">
                        <option value="null" selected disabled>Жанры</option>
                        @foreach($genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                        @endforeach
                    </select>
                    <select class="input" name="author_id">
                        <option value="null" selected disabled>Автор</option>
                        @foreach($authors as $author)
                            <option value="{{$author->id}}">{{$author->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn mt20">Создать</button>
                </form>

                <form action="{{route('authors.store')}}" method="post" class="card vertical g20">
                    @csrf
                    <h3>Создать автора</h3>
                    <input type="text" class="input" placeholder="Название" name="name">
                    <button class="btn mt20">Создать</button>
                </form>

                <form action="{{route('genres.store')}}" method="post" class="card vertical g20">
                    @csrf
                    <h3>Создать жанр</h3>
                    <input type="text" class="input" placeholder="Название" name="name">
                    <button class="btn mt20">Создать</button>
                </form>

                <form action="{{route('users.store')}}" method="post" class="card vertical g20">
                    @csrf
                    <h3>Создать пользователя</h3>
                    <input type="text" class="input" placeholder="Логин" name="login">
                    <input type="text" class="input" placeholder="Пароль" name="password">
                    <button class="btn mt20">Создать</button>
                </form>
            </div>
            <div class="right">
                <h2>Книги</h2>
                <div class="grid f2 mt20">
                    @foreach($books as $book)
                        <form action="{{route('books.update', $book->id)}}" method="post" class="card admin-book vertical g20">
                            @method('PATCH')
                            @csrf
                            <div class="vertical g5">
                                <div class="hint">Название:</div>
                                <input type="text" class="input" value="{{$book->title}}" name="title">
                            </div>
                            <div class="vertical g5">
                                <div class="hint">Описание:</div>
                                <input type="text" class="input" value="{{$book->text}}" name="text">
                            </div>
                            <div class="vertical g5">
                                <div class="hint">Изображение:</div>
                                <input type="file" class="input" name="image">
                            </div>
                            <select class="input" multiple name="genres[]">
                                <option value="" selected disabled>Жанры</option>
                                @foreach($genres as $genre)
                                    <option {{$book->genres->map(fn($i) => $i->id)->contains($genre->id) ? 'selected' : ''}} value="{{$genre->id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                            <select class="input" name="author_id">
                                <option value="" selected disabled>Автор</option>
                                @foreach($authors as $author)
                                    <option {{$book->author_id === $author->id ? 'selected' : ''}} value="{{$author->id}}">{{$author->name}}</option>
                                @endforeach
                            </select>
                            <div class="vertical g5 mt20">
                                <button class="btn">Применить изменения</button>
                                <a href="{{route('books.destroy', $book->id)}}" class="btn reversed">Удалить</a>
                            </div>
                        </form>
                    @endforeach
                </div>

                <h2 class="mt20">Авторы</h2>
                <div class="grid f2 mt20">
                    @foreach($authors as $author)
                        <form action="{{route('authors.update', $author->id)}}" method="post" class="card admin-book vertical g20">
                            @method('PATCH')
                            @csrf
                            <div class="vertical g5">
                                <div class="hint">Название:</div>
                                <input type="text" class="input" value="{{$author->name}}" name="name">
                            </div>
                            <div class="vertical g5 mt20">
                                <button class="btn">Применить изменения</button>
                                <a href="{{route('authors.destroy', $author->id)}}" class="btn reversed">Удалить</a>
                            </div>
                        </form>
                    @endforeach
                </div>

                <h2 class="mt20">Жанры</h2>
                <div class="grid f2 mt20">
                    @foreach($genres as $genre)
                        <form action="{{route('genres.update', $genre->id)}}" method="post" class="card admin-book vertical g20">
                            @method('PATCH')
                            @csrf
                            <div class="vertical g5">
                                <div class="hint">Название:</div>
                                <input type="text" class="input" value="{{$genre->name}}" name="name">
                            </div>
                            <div class="vertical g5 mt20">
                                <button class="btn">Применить изменения</button>
                                <a href="{{route('genres.destroy', $genre->id)}}" class="btn reversed">Удалить</a>
                            </div>
                        </form>
                    @endforeach
                </div>

                <h2 class="mt20">Пользователя</h2>
                <div class="grid f2 mt20">
                    @foreach($users as $user)
                        <form action="{{route('users.update', $user->id)}}" method="post" class="card admin-book vertical g20">
                            @method('PATCH')
                            @csrf
                            <div class="vertical g5">
                                <div class="hint">Логин:</div>
                                <input type="text" class="input" value="{{$user->login}}" name="login">
                            </div>
                            <div class="vertical g5">
                                <div class="hint">Пароль:</div>
                                <input type="text" class="input" value="{{$user->password}}" name="password">
                            </div>
                            <div class="vertical g5">
                                <div class="hint">Права:</div>
                                <select name="isAdmin" class="input">
                                    <option {{$user->isAdmin ? 'selected' : ''}} value="1">Администратор</option>
                                    <option {{$user->isAdmin ? '' : 'selected'}} value="0">Пользователь</option>
                                </select>
                            </div>
                            <div class="vertical g5 mt20">
                                <button class="btn">Применить изменения</button>
                                <a href="{{route('users.destroy', $user->id)}}" class="btn reversed">Удалить</a>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</main>
<script>
    if (!localStorage.isAdmin) {
        window.location.href = '/';
    }
</script>
</body>
</html>
