<?php

class MyCustomSessionHandler implements SessionHandlerInterface {

    protected $table_sess = 'sessions';
    protected $col_sid = 'sid';
    protected $col_expiry = 'expiry';
    protected $col_data = 'data';

    protected $expiry;
    protected $db;

    public function __construct() {

        // Create DB connection
        $this->db = $this->dbConnect();
        $this->expiry = time() + (int) ini_get('session.gc_maxlifetime');
    }

    private function dbConnect() {

        try {
            $db = new PDO('mysql:host=localhost;dbname=sess_handler', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Initialize session
     * @param string $save_path The path where to store/retrieve the session.
     * @param string $name The session name.
     * @return bool
     */
    public function open($save_path, $name) {
        return true;
    }

    /**
     * Reads session data
     * @param string $session_id The session id to read data for.
     * @return string
     */
    public function read($session_id) {

        $sql = "SELECT $this->col_expiry, $this->col_data
        FROM $this->table_sess WHERE $this->col_sid =" . $this->db->quote($session_id);

        $result = $this->db->query($sql);
        $data = $result->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            if ($data[$this->col_expiry] < time()) {
                // Return an empty string if data out of date
                return '';
            }
            return $data[$this->col_data];
        }
        return '';
    }


    /**
     * Write session data
     * @param string $session_id The session id.
     * @param string $session_data <p>
     * @return bool
     */
    public function write($session_id, $session_data) {

        $sql = "INSERT INTO $this->table_sess SET 
                  $this->col_sid=" . $this->db->quote($session_id) .",
                  $this->col_expiry=" . $this->db->quote($this->expiry) . ",
                  $this->col_data=" . $this->db->quote($session_data) . " 
                  ON DUPLICATE KEY UPDATE
                  $this->col_data=" . $this->db->quote($session_data);
        $this->db->query($sql);

        return true;
    }

    /**
     * Close the session
     * @return bool
     */
    public function close() {
        return true;
    }

    /**
     * Garbage collection
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime) {
        $sql = "DELETE FROM $this->table_sess 
                    WHERE $this->col_expiry <" . time();
        $this->db->query($sql);
        return true;
    }

    /**
     * Destroy a session
     * @param string $session_id The session ID being destroyed.
     * @return bool
     */
    public function destroy($session_id) {

        $sql = "DELETE FROM $this->table_sess 
                    WHERE $this->col_sid=" . $this->db->quote($session_id);
        $this->db->query($sql);
        return true;
    }
}