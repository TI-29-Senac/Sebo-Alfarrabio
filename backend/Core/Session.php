<?php
namespace Sebo\Alfarrabio\Core;

class Session {
<<<<<<< HEAD
    public function __construct() {
=======
    public function __construct(){
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, $value): void{
        $_SESSION[$key] = $value;
    }

    public function get(string $key){
        return $_SESSION[$key] ?? null;
    }

<<<<<<< HEAD
    public function has (string $key): bool{
        return isset($_SESSION[$key]);
    }

    public function destroy (): void{
       $_SESSION = [];
         if (ini_get("session.use_cookies")) {
              $params = session_get_cookie_params();
              setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
              );
         }
         session_destroy();
=======
    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public function destroy(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
    }
}