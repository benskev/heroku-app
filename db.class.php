<?php
ini_set('display_errors','on');
class MyDB extends SQLite3
  {
     function __construct()
     {
        echo "asdf";
        $this->open('test.db');
     }

     function get($sql)
     {
           $ret = $this->exec($sql);
           if(!$ret){
              echo $this->lastErrorMsg();
           } else {
             $row = $ret->fetchArray(SQLITE3_ASSOC);
             //echo "Records created successfully\n";
           }
           return $row;
           $db->close();
     }

     function run($sql)
     {
       $ret = $this->exec($sql);
       if(!$ret){
          echo $this->lastErrorMsg();
       }
     }
  }
?>
