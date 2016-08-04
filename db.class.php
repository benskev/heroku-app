<?php
class MyDB extends SQLite3
  {
     function __construct()
     {
        $this->open('test.db');
     }

     function run($sql)
     {
           $ret = $this->exec($sql);
           if(!$ret){
              echo $this->lastErrorMsg();
           } else {
             $row = $ret->fetchArray(SQLITE3_ASSOC)
             //echo "Records created successfully\n";
           }
           return $row;
           $db->close();
     }
  }
?>
