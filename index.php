<?php
$page = 'index'; ?>
<?php require_once "function.php" ?>
<?php header('Content-type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Zadanie č.3 | Michal Čech</title>

    <!-- Bootstrap -->
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico'/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <script src="vendor/imsky/holder/holder.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1>Zadanie č.3 - AUTH
                    <small>vypracoval Michal Čech</small>
                </h1>
            </div>
        </div>
    </div>
    <?php
    if (($flash = FlashMessage::getMessage()) && isset($flash['type']) && isset($flash['message'])): ?>
        <?php if (isset($flash['type']) && $flash['type'] == "error"): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error:</strong> <?php echo $flash['message']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($flash['type']) && $flash['type'] == "success"): ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success:</strong> <?php echo $flash['message']; ?>
            </div>
            <?php
        endif;
    endif;
    if (MessagesList::hasMessages()):
        foreach (MessagesList::getAll() as $error): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error:</strong> <?php echo $error->getMessage(); ?>
            </div>
        <?php endforeach;
    endif;

    $facade = new GoogleFacade();

    $client = $facade->getClient();

    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);
    } else {
        $authUrl = $client->createAuthUrl();
    }

    if (!isset($authUrl) || User::check()) :

        $logged_user = User::getLoggedUser();
        ?>
        <div class="row">
            <div class="col-sm-2 pull-right text-right">
                <a href="action.php?method=logout" class="btn btn-warning btn-block">Logout</a>
            </div>

            <?php if ($logged_user->hasPassword()) : ?>

                <div class="col-sm-2 pull-right">
                    <a href="action.php?method=changePassword" class="btn btn-success btn-gray btn-block"
                       data-toggle="modal" data-target="#modal">
                        Change password
                    </a>
                </div>

            <?php else : ?>

                <div class="col-sm-2 pull-right">
                    <a href="action.php?method=setPassword" class="btn btn-success btn-gray btn-block"
                       data-toggle="modal"
                       data-target="#modal">
                        Set password
                    </a>
                </div>

            <?php endif; ?>

            <div class="col-sm-2 pull-right">
                <a href="action.php?method=history" class="btn btn-success btn-gray btn-block" data-toggle="modal"
                   data-target="#modal">Login history</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?php if ($logged_user->getPicture()): ?>
                    <img src="<?php echo $logged_user->getPicture(); ?>" class="img-responsive img-circle"
                         alt="<?php echo $logged_user->getFullName(); ?>">
                <?php else: ?>
                    <img data-src="holder.js/200x200/#fff:#000" class="img-responsive img-circle"
                         alt="<?php echo $logged_user->getFullName(); ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
                <h2>
                    Hello <?php echo $logged_user->getFullName(); ?> (<?php echo $logged_user->getEmail(); ?>)
                </h2>
            </div>
        </div>
    <?php else : ?>

        <div class="row">
            <div class="col-sm-2 col-sm-offset-1">
                <a class="btn btn-primary btn-block" data-toggle="modal"
                   data-target="#edit_modal"
                   href="action.php?method=registration">Registration</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="page-header">
                    <h2>Login
                        <small>by email & password</small>
                    </h2>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form class="form form-horizontal" action="action.php?method=login" method="post">
                            <div class="form-group">
                                <input type="email" value="" id="email" name="email" class="form-control"
                                       placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" value="" id="l_password" name="password" class="form-control"
                                       placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Login" class="pull-right btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="page-header">
                    <h2>Login to LDAP
                        <small>by AIS login & password</small>
                    </h2>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form class="form form-horizontal" action="action.php?method=ldap" method="post">
                            <div class="form-group">
                                <input type="text" value="" id="login" name="login" class="form-control"
                                       placeholder="Login">
                            </div>
                            <div class="form-group">
                                <input type="password" value="" id="ldap_password" name="password" class="form-control"
                                       placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Login" class="pull-right btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="page-header">
                    <h2>OAUTH login
                        <small>by Google</small>
                    </h2>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <?php if (isset($authUrl)) : ?>
                            <a class="btn btn-info btn-block" href='<?php echo $authUrl ?>'>Connect Me!</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <p></p>
        </div>
    <?php endif; ?>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    });

</script>
<div class="modal fade" id="modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
</body>
</html>