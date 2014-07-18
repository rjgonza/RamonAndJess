<html>
  <head></head>
  <body>
    <h1>Instagram Tag Search</h1>
    <?php
    if (!isset($_POST['submit'])) {
    ?>
    <form method="post" 
      action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      Search for:
      <input type="text" name="q" /> 
      <input type="submit" name="submit" value="Search" />      
    </form>
    <?php
    } else {
    ?>
    <h2>Search results for '<?php echo $_POST['q']; ?>'</h2>
    <?php
      require_once 'Zend/Loader.php';
      Zend_Loader::loadClass('Zend_Http_Client');

      // define consumer key and secret
      // available from Instagram API console
      $CLIENT_ID = '543839601c3a4c53ab70984b54422a23';
      $CLIENT_SECRET = '1e494f65ea0246d18e94a9bb6e688116';

      try {
        // initialize client
        $client = new Zend_Http_Client('https://api.instagram.com/v1/tags/search');
        $client->setParameterGet('client_id', $CLIENT_ID);
        $client->setParameterGet('q', $_POST['q']);

        // get and display similar tags
        $response = $client->request();
        $result = json_decode($response->getBody());
        $data = $result->data;  
        if (count($data) > 0) {
          echo '<ul>';
          foreach ($data as $item) {
            echo '<li>' . $item->name . ' (' . $item->media_count . 
              ') </li>';
          }
          echo '</ul>';
        }
      } catch (Exception $e) {
        echo 'ERROR: ' . $e->getMessage() . print_r($client);
        exit;
      }
    }  
    ?>
  </body>
</html>