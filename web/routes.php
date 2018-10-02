<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        require_once('models/user.php');      
        $controller = new PagesController();
      break;
      case 'incidents':
        require_once('models/user.php');   
        require_once('models/incident.php');
        require_once('models/software.php');
        require_once('models/hardware.php');
        require_once('models/status.php');
        require_once('models/actie.php');
        require_once('models/prioriteit.php');
        $controller = new IncidentsController();
      break;
      case 'gebruikers':
        require_once('models/user.php');
        require_once('models/groep.php');
        $controller = new GebruikersController();
      break;
      case 'acties':
        require_once('models/actie.php');      
        $controller = new ActiesController();
      break;
    }

    $controller->{ $action }();
  }

  $controllers = array('pages' => ['home', 'login', 'register', 'logout', 'error'],
                       'incidents' => ['index', 'show', 'new', 'edit', 'melden'],
                       'gebruikers' => ['index', 'new', 'edit'],
                       'acties' => ['delete']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>