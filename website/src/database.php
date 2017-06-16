<?php
class Database {
     private $connection;
     private $databaseName;
     private $tableName;

     public function connect($host, $username, $password) {
         $res = true;
         $this->connection = @mysqli_connect($host, $username, $password) or $res = false;
         return $res;
     }

     public function query($query) {
         return mysqli_query($this->connection, $query);
     }

     public function getDatabaseList() {
         $result = $this->query("SHOW DATABASES");
         $rowCount = mysqli_num_rows($result);

         for($i = 0; $i < $rowCount; $i++) {
             $row = mysqli_fetch_row($result);+
             $res[$i] = $row[0];
         }

         return $res;
     }

     public function getTableList() {
         $result = $this->query("SHOW TABLES");
         $rowCount = mysqli_num_rows($result);

         for($i = 0; $i < $rowCount; $i++) {
             $row = mysqli_fetch_row($result);+
             $res[$i] = $row[0];
         }

         return $res;
     }

     public function getTableColumns($tableName) {
         $result = $this->query("DESCRIBE ".$tableName);
         $rowCount = mysqli_num_rows($result);

         for($i = 0; $i < $rowCount; $i++) {
             $row = mysqli_fetch_row($result);+
             $res[$i] = $row[0];
         }

         return $res;
     }

     public function getTableContent($tableName) {
         $result = $this->query("SELECT * FROM ".$tableName);
         $rowCount = mysqli_num_rows($result);
         $res = null;

         for($i = 0; $i < $rowCount; $i++) {
             $row = mysqli_fetch_row($result);
             $res[$i] = $row;
         }

         return $res;
     }

     public function getTableContentWhere($tableName, $condition) {
         $result = $this->query("SELECT * FROM ".$tableName." WHERE ".$condition);
         $rowCount = mysqli_num_rows($result);
         $res = null;

         for($i = 0; $i < $rowCount; $i++) {
             $row = mysqli_fetch_row($result);
             $res[$i] = $row;
         }

         return $res;
     }

     public function selectDatabaseFromForm($fieldName) {
         if(isset($_GET[$fieldName])) {

             $this->databaseName = $_GET[$fieldName];
             if(!mysqli_select_db($this->databaseName)) return false;
             return true;
         
         }

         return false;
     }

     public function selectDatabase($databaseName) {
         $this->databaseName = $databaseName;
         if(!mysqli_select_db($this->connection, $this->databaseName)) return false;
         return true;
     }

 }
?>