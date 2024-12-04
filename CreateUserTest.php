<?php
use PHPUnit\Framework\TestCase;
require ('CreateUsers.php');

class CreateUserTest extends TestCase
{
    protected $pdoMock;
    protected $con;

    protected function setUp(): void
    {
        // Create a mock PDO instance
        $this->pdoMock = $this->createMock(PDO::class);

        // Mock the prepare method to return a mock PDOStatement
        $this->con = $this->pdoMock;
    }

    // Test case for when the role exists
    public function testCreateUserWithValidRole()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['Id' => 1]);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Test the createUser function
        $email = "test@example.com";
        $password = "securepassword";
        $roleName = "Admin";

        $this->expectOutputString("User created successfully.");
        createUser($email, $password, $roleName);
    }

    // Test case for when the role does not exist
    public function testCreateUserWithInvalidRole()
    {

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(false);  // No role found


        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Test the createUser function
        $email = "test@example.com";
        $password = "securepassword";
        $roleName = "InvalidRole";

        // Expect an exception to be thrown
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Role not found.");

        createUser($email, $password, $roleName);
    }

    // Test case for when the insert statement fails
    public function testCreateUserInsertFails()
    {

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['Id' => 1]);


        $this->pdoMock->method('prepare')->willReturn($stmtMock);
        $stmtMock->method('execute')->willThrowException(new Exception('Insert failed'));

        // Test the createUser function
        $email = "test@example.com";
        $password = "securepassword";
        $roleName = "Admin";

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Insert failed');

        createUser($email, $password, $roleName);
    }
}
?>
