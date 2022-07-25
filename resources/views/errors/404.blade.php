<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opemedios - 404</title>
    <style type="text/css">
        body {
          display: inline-block;
          background: #00AFF9 url({{asset('images/satelite.jpg')}}) center/cover no-repeat;
          height: 100vh;
          margin: 0;
          color: white;
        }

        h1 {
          margin: .8em 3rem 0 3rem;
          font: 8em Roboto;
        }
        p {
          display: inline-block;
          margin: .1em 3rem;
          font: 2em Roboto;
        }
        a {
            display: inline-block;
            font: 1.2em Roboto;
            float:right;
            text-decoration: none;
            color:  white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Algo salio mal</p>
    <p style="display:block;">{{ $exception->getMessage() }}</p>
    <br>
    <a href="{{ back() }}">Regresar</a>
</body>
</html>