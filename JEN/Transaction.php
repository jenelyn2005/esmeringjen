<?php
/**
 * Transaction.php
 * Wraps multiple database operations in a single PDO transaction so they
 * either all succeed or all fail together (atomicity).
 *
 * Usage:
 *   Transaction::run($db, function () use ($db, $user_id, $certificate_type) {
 *       $db->prepare("INSERT INTO certificate_requests (...)")->execute([...]);
 *       $db->prepare("INSERT INTO payments (...)")->execute([...]);
 *   });
 */
class Transaction
{
    /**
     * Run a callable inside a database transaction.
     * Commits on success, rolls back on failure, then re-throws the exception.
     *
     * @param PDO $conn  The PDO connection.
     * @param callable $work  The work to perform inside the transaction.
     * @return mixed The return value of $work.
     */
    public static function run(PDO $conn, callable $work)
    {
        $conn->beginTransaction();
        try {
            $result = $work();
            $conn->commit();
            return $result;
        } catch (Throwable $exception) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            throw $exception;
        }
    }

    /**
     * Run a callable inside a named savepoint (nested transaction).
     *
     * @param PDO $conn  The PDO connection.
     * @param string $name  Savepoint name (alphanumeric + underscore only).
     * @param callable $work  The work to perform inside the savepoint.
     * @return void
     */
    public static function savepoint(PDO $conn, string $name, callable $work): void
    {
        $name = preg_replace('/[^A-Za-z0-9_]/', '', $name) ?: 'sp';
        $conn->exec("SAVEPOINT {$name}");
        try {
            $work();
            $conn->exec("RELEASE SAVEPOINT {$name}");
        } catch (Throwable $exception) {
            $conn->exec("ROLLBACK TO SAVEPOINT {$name}");
            $conn->exec("RELEASE SAVEPOINT {$name}");
            throw $exception;
        }
    }
}
