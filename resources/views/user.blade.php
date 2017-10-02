<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<div class="container">

    <table class="table">
        <thead>
        <tr>
            <th>name</th>
            <th>NID</th>
            <th>no	Birthday</th>
            <th>phone</th>
            <th>email</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @if (!empty($response))


                <td>
                  {{$response->name  }}
                </td>
                <td>
                  {{$response->nid  }}
                </td>
                <td>
                  {{$response->no_Birthday  }}
                </td>
                <td>
                  {{$responses->phone  }}
                </td>
                <td>
                  {{$responses->email  }}
                </td>

            @endif
        </tr>

        </tbody>
    </table>
</div>



</body>
</html>