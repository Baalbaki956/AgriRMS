<?php
class Connection {

    private $host = "localhost";
    private $db = "agrirms";
    private $username = "root";
    private $password = "";
    private $con;

    function connect() {
        $this->con = mysqli_connect($this->host, $this->username, $this->password, $this->db);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        return $this->con;
    }

    function executeQuery($query) {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Database access failed: " . mysqli_error($conn));
        }

        return $result;
    }

    function getCon() {
        return $this->con;
    }

    function fetchRow($result) {
        if ($result instanceof mysqli_result) {
            return mysqli_fetch_assoc($result);
        } else {
            return [];
        }
    }

    function getNumRows($result) {
        return mysqli_num_rows($result);
    }

    function getInsertId() {
        return mysqli_insert_id($this->con);
    }

    function close() {
        mysqli_close($this->con);
    }

    function fetchRows($result) {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
?>
